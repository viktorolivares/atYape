<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifyApk extends Model
{
    use HasFactory;

    protected $table = 'notify_apk';

    protected $fillable = [
        'message',
    ];
}
