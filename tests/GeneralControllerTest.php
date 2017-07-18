<?php

class GeneralControllerTest extends TestCase
{
    function __construct(){
        $faker = Faker\Factory::create();

        $this->setApiPath('v1', 'general');

        $this->setPostData([
            'code' => $faker->text(10),
            'descCode' => $faker->text(15),
            'desc' => $faker->text(1000),
            'order' => 99,
            'isActive' => true
        ]);

        $this->setPatchData([
            'code' => 'TST!',
            'descCode' => 'TST!',
            'desc' => 'Test data!',
            'order' => 100,
            'isActive' => false
        ]);
    }
}