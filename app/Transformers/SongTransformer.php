<?php

namespace App\Transformers;

use Illuminate\Support\Facades\App;
use App\Models\Song;
use League\Fractal\TransformerAbstract;

class SongTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'album',
        'artist'
    ];

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Song $song)
    {
        /*$result =  new \stdClass();
        $result->id = (int) $album->id;
        $result->title = $album->title;
        $result->released = $album->released;
        $result->active = (bool) $album->active;

        return get_object_vars($result);*/

        return $song->toArray();
    }

    /**
     * Include artist
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeArtist(Song $song)
    {
        $artist = $song->artist;

        if(!$artist){
            return null;
        }

        return $this->item($artist, App::make(ArtistTransformer::class));
    }

    /**
     * Include album
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeAlbum(Song $song)
    {
        $albums = $song->albums;

        if(!$albums){
            return null;
        }

        return $this->collection($albums, App::make(AlbumTransformer::class));
    }
}