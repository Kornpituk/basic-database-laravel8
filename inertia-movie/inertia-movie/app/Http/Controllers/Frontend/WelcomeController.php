<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Movie;
use App\Models\TvShow;
use App\Models\Episode;
use App\Models\Season;

class WelcomeController extends Controller
{
    //
    
    public function index(){

        $movies = Movie::orderBy('updated_at', 'desc')->with('genres')->take(12)->get();
        $tvShows = TvShow::withCount('seasons')->orderBy('created_at', 'desc')->take(12)->get();
        $episodes = Episode::orderBy('created_at', 'desc')->with('season')->take(12)->get();


        return Inertia::render('Welcome',[
            'movies' => $movies,
            'episodes' => $episodes,
            'tvShows' => $tvShows,
        ]);
    }
}
