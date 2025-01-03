<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    // Formdan gelen bu alanların veri tabanına yazılmasına izin verir
    protected $fillable = [
        'name',
        'user_id',
    ];

    // Plan ile User arasındaki ilişki
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
