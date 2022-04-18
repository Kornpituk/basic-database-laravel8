<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Searchable\SearchResult;
use Spatie\Searchable\Searchable;
// use App\Models\Season;
// use Illuminate\Database\Eloquent\Relations\hasMany;

class TvShow extends Model implements Searchable
{
    use HasFactory;

    protected $fillable = ['tmdb_id','name','slug','poster_path','created_year'];

    public function getSearchResult(): SearchResult {
        
        $url = route('tvShow.show', $this->slug);
        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->name,
            $url
        );
    }

    public function setNameAttribute($value){

        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function seasons(){

        return $this->hasMany(Season::class);
    }


}
