<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',    // New phone field
        'is_admin', // Necessary here to enable promoting users from the Staff page
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean', // So Laravel treats it as true/false
        ];
    }

    /**
     * Relationship: The user with the tickets they have created.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'user_id');
    }

    /**
     * Relationship: The admin with the tickets they have resolved (for the "Hero of the Week" system).
     */
    public function solvedTickets()
    {
        return $this->hasMany(Ticket::class, 'solver_id');
    }

    /**
     * The comments written by this user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}