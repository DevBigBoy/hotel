<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\Intl\Countries;

class BookingController extends Controller
{
    public function checkout()
    {

        $countries = Countries::getNames();
        return view('frontend.pages.checkout.index', compact('countries'));
    }
}
