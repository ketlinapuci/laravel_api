<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    //specify the mass assignable column in the fillable attribute
    protected $fillable = ['name'];

// A task belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
