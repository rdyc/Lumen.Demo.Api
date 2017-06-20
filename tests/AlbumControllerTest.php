<?php

class AlbumControllerTest extends TestCase
{
    function __construct(){
        $this->setApiPath('v1', 'album');

        $this->setPostData([
            'artist_id' => 80,
            'title' => 'Album 123',
            'released' => '2017-06-10',
            'active' => true
        ]);

        $this->setPatchData([
            'title' => 'Album 123 Updated',
            'released' => '2017-06-10',
            'active' => false
        ]);
    }
}