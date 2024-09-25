<?php

namespace LegacyFcm\FcmHelper\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    use HasFactory;

    protected $table = 'push_notifications';
    protected $fillable = [
        'title',
        'content',
        'data',
        'type'
    ];
}
