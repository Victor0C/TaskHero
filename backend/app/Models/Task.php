<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'desc',
        'expired_date',
        'done',
    ];

    protected $casts = [
        'done' => 'boolean'
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }
}
