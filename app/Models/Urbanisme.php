<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Urbanisme extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'latitude',
        'longitude',
        'photo_path',
        'status',
    ];

    /**
     * Get the user that owns the urbanisme request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
