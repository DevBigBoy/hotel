<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Room;
use App\Models\Team;
use App\Models\BookArea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $teams = Team::active()->latest()->get();
        $bookArea = BookArea::latest()->first();

        $rooms = Room::with(['roomType', 'roomNumbers'])
            // ->withAvailableRoomNumbersCount()
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
