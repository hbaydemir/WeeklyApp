<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'plan_id',
        'user_id',
        'due_date',
        'status',
    ];

    // Plan ile ilişki
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
