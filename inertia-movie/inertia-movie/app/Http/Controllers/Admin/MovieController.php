<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use App\Models\Movie;
use App\Models\Genre;

class MovieController extends Controller
{
    //
    public function index(){

        $perPage = Request::input('perPage') ?: 5;

        return Inertia::render('Movies/Index', [
            'movies' => Movie::query()
                    ->when(Request::input('search'), function($quesry, $search) {
                        $quesry->where('title', 'like',"%{$search}%");
                    })->when(Request::has('column'), function($quesry){
                        $quesry->orderBy(Request::input('column') ,
                        Request::input('direction'));
                    })
                    ->paginate($perPage),
                    // ->whithQueryString(),,
            'filters' => Request::only(['search','perPage','column','direction'])
        ]);
    }

    public function store(){

        $movie = Movie::where('tmdb_id', Request::input('movieTMDBId'))->exists();
        if ($movie) {
            return Redirect::back()->with('flash.banner','Movie Exists.');
        }

        $apiMovie = Http::asJson()->get(config('services.tmdb.endpoint').'movie/'.Request::input('movieTMDBId').'?api_key='.config('services.tmdb.secret').'&language=en-US');

        if ($apiMovie->successful()) {
            $newMovie = $apiMovie->json();

            $created_movie = Movie::create([
                'tmdb_id' => $apiMovie['id'],
                'title' => $apiMovie['title'],
                'runtime' => $apiMovie['runtime'],
                'rating' => $apiMovie['vote_average'],
                'release_date' => $apiMovie['release_date'],
                'lang' => $apiMovie['original_language'],
                'video_format' => 'HD',
                'is_public' => false,
                'overview' => $apiMovie['overview'],
                'poster_path' => $apiMovie['poster_path'],
                'backdrop_path' => $apiMovie['backdrop_path']
            ]);
            $tmdb_genres = $apiMovie['genres'];
            $tmdb_genres_ids = collect($tmdb_genres)->pluck('id');
            $genres = Genre::whereIn('tmdb_id', $tmdb_genres_ids)->get();
            $created_movie->genres()->attach($genres);
            return Redirect::back()->with('flash.banner','Movie Create.');

        } else {
            return Redirect::back()->with('flash.banner','Movie Api Error.');;
        }

    }

    public function edit(Movie $movie){
        return Inertia::render('Movies/Edit',['movie' => $movie]);
    }

    public function update(Movie $movie){

        $movie->update(Request::validate([
            'title' => 'required',
            'poster_path' => 'required',
            'runtime' => 'required',
            'lang' => 'required',
            'video_format' => 'required',
            'rating' => 'required',
            'backdrop_path' => 'required',
            'overview' => 'required',
            'is_public' => 'required'
        ]));

        return Redirect::route('admin.movies.index')->with('flash.banner','Movie Updated.');
    }

    public function destroy(Movie $movie){

        $movie->genres()->sync([]);
        $movie->delete();
        return Redirect::route('admin.movies.index')->with('flash.banner','Movie Deleted.')->with('flash.bannerStyle','danger');
    }
}
