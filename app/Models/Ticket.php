<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

   /**

* Fields that can be filled in (Mass Assignment)

* Resolved_by has been updated to solver_id to match the database

*/
    protected $fillable = [
        'user_id', 
        'title', 
        'description', 
        'status', 
        'resolution_notes', 
        'solver_id' 
    ];

  /**

* Relationship with the employee who opened the ticket (the person with the problem)

*/
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**

* Relationship with the admin who solved the problem (the system hero)

*/
    public function solver()
    {
        // // We link the solver_id field to the Users table.
        return $this->belongsTo(User::class, 'solver_id');
    }

    public function comments() {
    return $this->hasMany(Comment::class)->latest();
}
}