<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller 
{
    /**
     * Display a listing of tickets with a smart dashboard and advanced filtering system.
     */
    public function index(Request $request) 
    {
        // --- Smart Statistics Section (For Dashboard) ---
        
        // 1. General Statistics
        $totalTickets = Ticket::count();
        $pendingTickets = Ticket::where('status', 'pending')->count();
        $resolvedToday = Ticket::where('status', 'resolved')->whereDate('updated_at', today())->count();
        
        // 2. Fetch "System Hero" (Top admin resolving tickets based on solver_id relationship)
        // Note: Ensure the solvedTickets relationship exists in the User model
        $topAdmin = User::where('is_admin', true)
                    ->withCount(['solvedTickets' => function($query) {
                        $query->where('status', 'resolved');
                    }])
                    ->orderBy('solved_tickets_count', 'desc')
                    ->first();

        // --- Ticket Retrieval with Filtering Section ---

        // 1. Start with Query and load user relationships
        $query = Ticket::with(['user', 'solver']);

        // Adjustment: If the user is not an admin AND not the Super Admin (you), they only see their own tickets
        if (!auth()->user()->is_admin && auth()->user()->email !== 'aboodasfour@gmail.com') {
            $query->where('user_id', auth()->id());
        }

        // 2. Search Filter (ID, Title, Description, or Employee Name)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%$search%")
                  ->orWhere('title', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'like', "%$search%");
                  });
            });
        }

        // 2.5 Ticket Origin Filter - Added here
        if ($request->filled('origin')) {
            if ($request->origin === 'internal') {
                // Tickets opened by Supervisor or Admins
                $query->whereHas('user', function($u) {
                    $u->where('is_admin', true)->orWhere('email', 'aboodasfour@gmail.com');
                });
            } elseif ($request->origin === 'staff') {
                // Tickets opened by regular staff only
                $query->whereHas('user', function($u) {
                    $u->where('is_admin', false)->where('email', '!=', 'aboodasfour@gmail.com');
                });
            }
        }

        // 3. Status Filter
        if ($request->filled('status_filter')) {
            $query->where('status', $request->status_filter);
        }

        // 4. Date Filter (From and To)
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // 5. Get results ordered by latest first
        $tickets = $query->latest()->get();

        // Send all data to the View
        return view('tickets.index', compact(
            'tickets', 
            'totalTickets', 
            'pendingTickets', 
            'resolvedToday', 
            'topAdmin'
        ));
    }

    /**
     * Show the form for creating a new ticket.
     */
    public function create() 
    {
        return view('tickets.create');
    }

    /**
     * Store a newly created ticket in the database.
     */
    public function store(Request $request) 
    {
        // Validate inputs
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
        ]);

        // Create ticket with status automatically set to 'pending'
        Ticket::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'pending', 
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully.');
    }

    /**
     * Update ticket status (Admin only)
     */
    public function update(Request $request, Ticket $ticket) 
    {
        // Allow if user is admin/supervisor, or if they are the ticket owner (to re-open it)
        if (!auth()->user()->is_admin && auth()->user()->email !== 'aboodasfour@gmail.com' && auth()->id() !== $ticket->user_id) {
            return back()->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'status' => 'required|in:pending,resolved',
            'note' => 'required|string|max:500', // Mandatory note to justify the change
        ]);

        // 1. Update ticket status
        $ticket->update([
            'status' => $request->status,
            'solver_id' => auth()->user()->is_admin ? auth()->id() : $ticket->solver_id,
        ]);

        // 2. Automatically log the movement in the Timeline (Comments)
        $statusText = $request->status == 'resolved' ? 'Resolved the ticket' : 'Re-opened/Set to Pending';
        $ticket->comments()->create([
            'user_id' => auth()->id(),
            'comment' => "🔄 [Status Changed to " . strtoupper($request->status) . "]: " . $request->note,
        ]);

        return back()->with('success', 'Ticket status updated and logged in timeline!');
    }

    /**
     * Private Super Admin Dashboard
     */
    public function dashboard()
    {
        // Protection: Ensure the email is your personal email only (Super Admin)
        if (auth()->user()->email !== 'aboodasfour@gmail.com') {
            abort(403);
        }

        $totalTickets = Ticket::count();
        $pendingTickets = Ticket::where('status', 'pending')->count();
        $resolvedToday = Ticket::where('status', 'resolved')->whereDate('updated_at', today())->count();
        
        $topAdmin = User::where('is_admin', true)
                    ->withCount(['solvedTickets' => function($query) {
                        $query->where('status', 'resolved');
                    }])
                    ->orderBy('solved_tickets_count', 'desc')
                    ->first();

        // Fetch only the last 5 tickets for quick view
        $recentTickets = Ticket::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalTickets', 'pendingTickets', 'resolvedToday', 'topAdmin', 'recentTickets'));
    }

    /**
     * Store a comment on a ticket.
     */
    public function storeComment(Request $request, Ticket $ticket)
    {
        // Ensure the comment is not empty
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        // Save comment and link it to the ticket and current user
        $ticket->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        // Smart touch: If the commenter is an admin, update "last person to handle the ticket"
        if (auth()->user()->is_admin || auth()->user()->email === 'aboodasfour@gmail.com') {
            $ticket->update(['solver_id' => auth()->id()]);
        }

        return back()->with('success', 'Update added to ticket timeline!');
    }
}