<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
     protected $fillable = [
        'user_id','meeting_room_id','meeting_name','date_time','duration','members'
    ];
      public function room()
    {
        return $this->belongsTo(MeetingRoom::class, 'meeting_room_id', 'id');
    }
}
