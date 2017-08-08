<?php

class SyncControllerTest extends TestCase
{
    function __construct()
    {
        parent::__construct($name = null, $data = [], $dataName = '');

        $faker = Faker\Factory::create();

        $this->setApiPath('v1', 'sync');

        $this->setPostData([
            'code' => $faker->text(10)
        ]);

        $this->setPatchData([
            'code' => 'TST!'
        ]);
    }
}