<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function english()
    {
        App::setLocale('en');
        Session::put('locale', 'en');

        $notification = [
            'message' => 'The English Running successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

    public function thailand()
    {
        App::setLocale('th');
        Session::put('locale', 'th');

        $notification = [
            'message' => 'The Thailand Running successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

    public function khmer()
    {
        App::setLocale('km');
        Session::put('locale', 'km');

        $notification = [
            'message' => 'The Khmer Running successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }
}
