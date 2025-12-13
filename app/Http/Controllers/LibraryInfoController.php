<?php

namespace App\Http\Controllers;

use App\Models\LibraryInfo;
use App\Models\Event;
use Illuminate\Http\Request;

class LibraryInfoController extends Controller
{
    public function index()
    {
        $recentEvents = Event::recent()->take(3)->get();
        $libraryName = LibraryInfo::get('library_name', 'Perpustakaan');
        
        return view('welcome', compact('recentEvents', 'libraryName'));
    }

    public function show()
    {
        $infos = [
            'library_name' => LibraryInfo::get('library_name'),
            'opening_hours' => LibraryInfo::get('opening_hours'),
            'address' => LibraryInfo::get('address'),
            'phone' => LibraryInfo::get('phone'),
            'email' => LibraryInfo::get('email'),
            'rules' => LibraryInfo::get('rules'),
        ];

        return view('info.show', compact('infos'));
    }

    public function events()
    {
        $events = Event::orderBy('event_date', 'desc')->paginate(10);
        
        return view('info.events', compact('events'));
    }
}
