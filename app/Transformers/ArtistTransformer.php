<?php

namespace App\Transformers;

use App\Models\Artist;
use Illuminate\Support\Facades\App;
use League\Fractal\TransformerAbstract;

/**
 * @SWG\Definition(
 *         definition="Artist",
 *         type="object",
 *         required={"id", "name", "active"},
 *         @SWG\Property(
 *             property="id",
 *             type="integer",
 *             format="int32"
 *         ),
 *         @SWG\Property(
 *             property="name",
 *             type="string"
 *         ),
 *         @SWG\Property(
 *             property="active",
 *             type="boolean"
 *         )
 *     )
 */
class ArtistTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'albums',
        'songs',
        'songs.albums'
    ];

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Artist $artist)
    {
        return [
            'id' => $artist->id,
            'name' => $artist->name,
            'active' => $artist->active
        ];
    }

    /**
     * Include albums
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeAlbums(Artist $artist)
    {
        $albums = $artist->albums;

        if (!$albums) {
            return null;
        }

        return $this->collection($albums, App::make(AlbumTransformer::class));
    }

    /**
     * Include songs
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeSongs(Artist $artist)
    {
        $songs = $artist->songs;

        if (!$songs) {
            return null;
        }

        return $this->collection($songs, App::make(SongTransformer::class));
    }
}