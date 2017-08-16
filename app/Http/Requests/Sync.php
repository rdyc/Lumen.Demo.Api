<?php

namespace App\Http\Requests;

/**
 * @SWG\Definition(@SWG\Xml(name="Sync"))
 */
class Sync
{

    /**
     * @SWG\Property(
     *     title="client",
     *     description="Client or device identifier",
     *     type="string"
     * )
     * @var string
     */
    public $client;

    /**
     * @SWG\Property(
     *     title="version",
     *     description="Client or device current version",
     *     type="string"
     * )
     * @var string
     */
    public $version;
}