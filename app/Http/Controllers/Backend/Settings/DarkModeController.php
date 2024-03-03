<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class DarkModeController extends Controller
{
    public function __invoke(Request $request)
    {
        // Retrieve the current mode from the cookie (default is 'off')
        $currentMode = Cookie::get('dark_mode', 'off');

        // Toggle the mode
        $newMode = $currentMode === 'off' ? 'on' : 'off';

        // Save the new mode in a cookie for 1 year
        Cookie::queue('dark_mode', $newMode, 525600); // 1 year in minutes

        return response()->json(['dark_mode' => $newMode]);
    }
}
