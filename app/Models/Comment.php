<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'author_id',
        'body',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
