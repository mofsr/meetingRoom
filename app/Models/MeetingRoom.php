<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingRoom extends Model
{
    use HasFactory;

     public function booking()
    {
        return $this->hasMany(Booking::class, 'meeting_room_id', 'id');
    }
}
