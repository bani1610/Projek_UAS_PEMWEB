<?php
// File: app/Models/Post.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    /**
     * Menentukan primary key tabel.
     *
     * @var string
     */
    protected $primaryKey = 'post_id';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'kategori_id',
        'judul',
        'isi_post',
        'image_path',
        'mood_tag',
    ];

    /**
     * Mendefinisikan relasi "belongs to" ke model User.
     * Setiap Post dimiliki oleh satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Mendefinisikan relasi "belongs to" ke model Category.
     * Setiap Post masuk dalam satu Category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'kategori_id', 'kategori_id');
    }

    /**
     * Mendefinisikan relasi one-to-many ke model Comment.
     * Satu Post bisa memiliki banyak Comment.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_id', 'post_id');
    }


}
