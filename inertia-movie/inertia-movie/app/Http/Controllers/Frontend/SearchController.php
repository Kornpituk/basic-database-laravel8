<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;

class SearchController extends Controller
{
    //
    public function search(){

        $data = (new SpatiSearch ())
        ->registerModel(Movie::class, 'title')
        ->registerModel(TvShow::class, 'name')
        ->registerModel(Season::class, 'name')
        ->registerModel(Cast::class, 'name')
        ->registerModel(Episode::class, 'name')
        ->search($this->search);

        return response()->json($data);

    }
}
