<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tasks extends Model
{
    protected $primaryKey = 'task_id';

    protected $fillable = [
        'user_id', 'judul_tugas', 'deskripsi', 'deadline',
        'kategori', 'prioritas', 'beban_kognitif', 'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
