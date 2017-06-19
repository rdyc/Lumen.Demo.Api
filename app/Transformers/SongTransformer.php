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

        return $this->collection($artist, App::make(ArtistTransformer::class));
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