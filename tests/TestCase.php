<?php

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    protected $apiVersion;
    
    protected $apiPath;

    protected $postData;

    protected $patchData;
    
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    public function setApiPath($version, $path){
        $this->apiVersion = $version;
        $this->apiPath = $path;
    }

    public function setPostData($array){
        $this->postData = $array;
    }

    public function setPatchData($array){
        $this->patchData = $array;
    }

    /**
     * @test
     */
    public function get_status_code_should_be_200(){
        $this->withoutMiddleware();

        $this->get('/'. $this->apiVersion . '/'. $this->apiPath)->seeStatusCode(200);
    }

    /**
     * @test
     * @depends get_status_code_should_be_200
     */
    public function post_status_code_should_be_201(){
        $this->withoutMiddleware();

        $content = $this->post('/'. $this->apiVersion . '/'. $this->apiPath, $this->postData)->seeStatusCode(201)->response->getContent();

        if($content){
            $json = json_decode($content);

            return $json->id;
        }
    }

    /**
     * @test
     * @depends post_status_code_should_be_201
     */
    public function get_id_status_code_should_be_200($id){
        if(!$id){
            $this->assertFalse();
        }

        $this->withoutMiddleware();

        $this->get('/'. $this->apiVersion . '/'. $this->apiPath .'/'. $id)
            ->seeStatusCode(200)
            ->seeJson([
                'id' => $id
            ]);

        return $id;
    }

    /**
     * @test
     * @depends get_id_status_code_should_be_200
     */
    public function patch_status_code_should_be_202($id){
        $this->withoutMiddleware();

        $this->patch('/'. $this->apiVersion . '/'. $this->apiPath .'/'. $id, $this->patchData)->seeStatusCode(202);
        
        return $id;
    }

    /**
     * @test
     * @depends patch_status_code_should_be_202
     */
    public function get_patch_status_code_should_be_200($id){
        if(!$id){
            $this->assertFalse();
        }

        $this->withoutMiddleware();

        $this->get('/'. $this->apiVersion . '/'. $this->apiPath .'/'. $id)
            ->seeStatusCode(200)
            ->seeJson($this->patchData);

        return $id;
    }

    /**
     * @test
     * @depends get_patch_status_code_should_be_200
     */
    public function delete_status_code_should_be_202($id){
        $this->withoutMiddleware();

        $this->delete('/'. $this->apiVersion . '/'. $this->apiPath .'/'. $id)->seeStatusCode(202);

        return $id;
    }

    /**
     * @test
     * @depends delete_status_code_should_be_202
     */
    public function get_deleted_status_code_should_be_404($id){
        if(!$id){
            $this->assertFalse();
        }

        $this->withoutMiddleware();

        $this->get('/'. $this->apiVersion . '/'. $this->apiPath .'/'. $id)->seeStatusCode(404);
    }
}
