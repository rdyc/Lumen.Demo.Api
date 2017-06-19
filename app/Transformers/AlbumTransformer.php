<?php

namespace App\Transformers;

use Illuminate\Support\Facades\App;
use App\Models\Album;
use League\Fractal\TransformerAbstract;

class AlbumTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'artist',
        'songs'
    ];

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Album $album)
    {
        /*$result =  new \stdClass();
        $result->id = (int) $album->id;
        $result->title = $album->title;
        $result->released = $album->released;
        $result->active = (bool) $album->active;

        return get_object_vars($result);*/

        return $album->toArray();
    }

    /**
     * Include Artist
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeArtist(Album $album)
    {
        $artist = $album->artist;

        if(!$artist){
            return null;
        }

        return $this->item($artist, App::make(ArtistTransformer::class));
    }

    /**
     * Include Songs
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeSongs(Album $album)
    {
        $songs = $album->songs;

        return $songs ? $this->collection($songs, App::make(SongTransformer::class)) : null;
    }
}