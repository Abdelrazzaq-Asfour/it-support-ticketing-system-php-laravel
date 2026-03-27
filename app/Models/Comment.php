<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // الحقول المسموح بتعبئتها
    protected $fillable = ['ticket_id', 'user_id', 'comment'];

    /**
     * العلاقة: التعليق ينتمي لمستخدم (الذي كتبه)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * العلاقة: التعليق ينتمي لتذكرة معينة
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}