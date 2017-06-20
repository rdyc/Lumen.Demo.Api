<?php

class ArtistControllerTest extends TestCase
{
    function __construct(){
        $this->setApiPath('v1', 'artist');

        $this->setPostData([
            'name' => 'Artist 123',
            'active' => true
        ]);

        $this->setPatchData([
            'name' => 'Artist 123 Updated',
            'active' => false
        ]);
    }
}