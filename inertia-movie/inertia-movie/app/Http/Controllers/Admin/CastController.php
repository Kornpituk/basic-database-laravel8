<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Models\Cast;

class CastController extends Controller
{
    //
    public function index(){
        $perPage = Request::input('perPage') ?: 5;
        return Inertia::render('Casts/Index', [
            'casts' => Cast::query()
                    ->when(Request::input('search'), function($quesry, $search) {
                        $quesry->where('name', 'like',"%{$search}%");
                    })
                    ->paginate($perPage),
                    // ->whithQueryString(),,
            'filters' => Request::only(['search','perPage'])
        ]);
    }

    public function store(){
        $cast = Cast::where('tmdb_id', Request::input('castTMDBId'))->first();
        if($cast){
            // return Redirect::route('admin.casts.index')->with('flash.banner','Cast Exists.');
            return Redirect::back()->with('flash.banner','Cast Exists.');
        }

        $tmdb_cast = Http::get(config('services.tmdb.endpoint').'person/'.Request::input('castTMDBId').'?api_key='.config('services.tmdb.secret').'&language=en-US');

         if ($tmdb_cast->successful()) {
            Cast::create([
        'tmdb_id' => $tmdb_cast['id'],
        'name'    => $tmdb_cast['name'],
        'slug'    => Str::slug($tmdb_cast['name']),
        'poster_path' => $tmdb_cast['profile_path']
            ]);
            // return Redirect::route('admin.casts.index')->with('flash.banner','Cast Created.'); 
            return Redirect::back()->with('flash.banner','Cast Created.'); 
        } else {
            // return Redirect::route('admin.casts.index')->with('flash.banner','Cast Api Error.');
            return Redirect::back()->with('flash.banner','Cast Api Error.'); 
        }
    }

    public function edit(Cast $cast){
        return Inertia::render('Casts/Edit',['cast' => $cast]);
    }

    public function update(Cast $cast){
        
        $validated = Request::validate([
            'name' => 'required',
            'poster_path' => 'required'
        ]);

        $cast->update($validated);
        return Redirect::route('admin.casts.index')->with('flash.banner','Cast Update.');
    }

    public function show(Cast $cast){
        $cast->delete();
        return Redirect::route('admin.casts.index')->with('flash.banner','Cast Delete.');
    }
}
