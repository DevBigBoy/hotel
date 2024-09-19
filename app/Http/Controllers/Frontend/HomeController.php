<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Room;
use App\Models\Team;
use App\Models\BookArea;
use App\Http\Controllers\Controller;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $teams = Team::active()->latest()->get();

        $bookArea = BookArea::latest()->first();

        $rooms = Room::select(
            [
                'rooms.id',
                'rooms.room_type_id',
                'rooms.short_desc',
                'rooms.total_adults',
                'rooms.total_children',
                'rooms.size',
                'rooms.view',
                'rooms.bed_style',
                'rooms.capacity',
                'rooms.image',
                'rooms.price_per_night',
                'rooms.discount',
                'rooms.status'
            ]
        )
            ->where('rooms.status', '=', 'available')
            ->whereHas('roomNumbers')
            ->with(['roomType:id,name'])
            ->limit(4)
            ->get();

        $posts = Post::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view(
            'frontend.index',
            [
                'teams' => $teams,
                'bookarea' => $bookArea,
                'rooms' => $rooms,
                'posts' => $posts,
            ]
        );
    }
}
