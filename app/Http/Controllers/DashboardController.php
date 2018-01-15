<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Show;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->admin == 1) {
            return view('dashboard.admin');
        }
        return view('dashboard.home');
    }

    public function search($search)
    {
        $searchUsers = User::where('name', 'like', '%' . $search . '%')->get();
        $searchShows = Show::where('name', 'like', '%' . $search . '%')->get();

        return view('dashboard.search', compact('searchUsers', 'searchShows', 'search'));
    }
}
