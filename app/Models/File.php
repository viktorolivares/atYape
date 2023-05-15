<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


class File extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'path',
        'filename',
        'mime_type',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'file_id');
    }

}
