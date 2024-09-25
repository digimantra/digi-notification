<?php

namespace DigiNotification\FcmHelper\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $fillable = [
        'title',
        'content',
        'data',
        'type'
    ];
}
