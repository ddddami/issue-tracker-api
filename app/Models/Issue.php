<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status'];

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}