<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'seen_status',
        'deliver_status'
    ];

    public function message() {
        return $this->belongsTo(Message::class);
    }
}
