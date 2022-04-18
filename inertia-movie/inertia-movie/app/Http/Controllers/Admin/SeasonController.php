<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use App\Models\TvShow;
use App\Models\Season;

class SeasonController extends Controller
{
    //
    public function index(TvShow $tvShow){

        $perPage = Request::input('perPage') ?: 5;

        return Inertia::render('TvShows/Seasons/Index', [
            'seasons' => Season::query()
                    ->where('tv_show_id', $tvShow->id)
                    ->when(Request::input('search'), function($quesry, $search) {
                        $quesry->where('name', 'like',"%{$search}%");
                    })
                    ->paginate($perPage),
                    // ->whithQueryString(),
            'filters' => Request::only(['search','perPage']),
            'tvShow' => $tvShow
        ]);

    }

    public function store(TvShow $tvShow)
    {
        $season = $tvShow->seasons()->where('season_number', Request::input('seasonNumber'))->exists();
        if($season){
            return Redirect::back()->with('flash.banner','Season Exists.');
        }

        $tmdb_season = Http::asJson()->get(config('services.tmdb.endpoint').'tv/'.$tvShow->tmdb_id . '/season/' . Request::input('seasonNumber').'?api_key='.config('services.tmdb.secret').'&language=en-US');
        // dd($tmdb_season);
         if ($tmdb_season->successful()) {
            Season::create([
                'tv_show_id' => $tvShow->id,
                'tmdb_id' => $tmdb_season['id'],
                'name'    => $tmdb_season['name'],
                'poster_path' => $tmdb_season['poster_path'],
                'season_number' => $tmdb_season['season_number']
            ]);
            return Redirect::back()->with('flash.banner','Season Created.'); 
        } else {
            return Redirect::back()->with('flash.banner','Season Api Error.'); 
        }
    }

    public function edit(TvShow $tvShow, Season $season){
        return Inertia::render('TvShows/Seasons/Episodes/Edit',[
            'tvShow' => $tvShow,
            'season' => $season
        ]);
    }

    public function update(TvShow $tvShow, Season $season){

        $season->update(Request::validate([
            'name' => 'required',
            'poster_path' => 'required'
        ]));
        return Redirect::route('admin.seasons.index', $tvShow->id)->with('flash.banner','Season Update.');
    }

    public function destroy(TvShow $tvShow, Season $season){
        $season->delete();
        return Redirect::route('admin.seasons.index', $tvShow->id)->with('flash.banner','Season Delete.')->with('flash.bannerStyle','danger');
    }
}
