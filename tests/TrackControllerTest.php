<?php

class TrackControllerTest extends TestCase
{
    function __construct(){
        $this->setApiPath('v1', 'track');

        $this->setPostData([
            'track' => 1,
            'title' => 'Track 123',
            'album_id' => 1,
            'active' => true
        ]);

        $this->setPatchData([
            'track' => 2,
            'title' => 'Track 123 Updated',
            'album_id' => 2,
            'active' => false
        ]);
    }
}