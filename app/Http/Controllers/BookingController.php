<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\MeetingRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class BookingController extends Controller
{
    public function bookmeeting(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'datetime' => 'required|date|after:now',
            'duration' => 'required|integer|in:30,60,90',
            'members' => 'required|integer|min:1',
            'room_id' => 'required|exists:meeting_rooms,id',
        ]);

        $user = Auth::user();
        $datetime = $request->datetime;

        // Convert to Carbon instance and get only the date part
        $date = Carbon::parse($datetime)->toDateString();
        $bookingsToday = Booking::where('user_id', $user->id)
            ->whereDate('date_time', $date)
            ->count();
        $maxBookings = $user->subscription->max_bookings_per_day ?? 3;

        if ($bookingsToday >= $maxBookings) {
            return response()->json(['error' => 'You have reached the max limit of ' . $maxBookings . ' bookings '.$date.'.'], 403);
        }

        Booking::create([
            'user_id' => $user->id,
            'meeting_room_id' => $request->room_id,
            'meeting_name' => $request->name,
            'date_time' => $request->datetime,
            'duration' => $request->duration,
            'members' => $request->members,
        ]);

        return response()->json(['message' => 'Booking successful']);
    }

    public function myBookings(Request $request)
    {
        $user = Auth::user();

        $query = Booking::where('user_id', $user->id)->with('room');

        if ($request->has('filter') && $request->filter === 'past') {
            $query->where('date_time', '<', now());
        } else {
            $query->where('date_time', '>=', now());
        }

        $bookings = $query->orderBy('date_time', 'asc')->paginate(5);

        return response()->json($bookings);
    }

    public function getAvailableRooms(Request $request)
    {
        // Logic to fetch rooms based on members
        $rooms = MeetingRoom::where('capacity', '>=', $request->members)->get();
        return response()->json($rooms);
    }
}
