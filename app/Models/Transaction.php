<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'transaction',
        'message',
        'person',
        'system',
        'amount',
        'state',
        'details',
        'register_date',
        'external_user',
        'created_by',
        'updated_by',

    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function setPersonAttribute($value)
    {
        $this->attributes['person'] = mb_strtoupper($value);
    }

    public function setDetailsAttribute($value)
    {
        $this->attributes['details'] = mb_strtoupper($value);
    }

    public function setMessageAttribute($value)
    {
        $this->attributes['message'] = mb_strtoupper($value);
    }

}
