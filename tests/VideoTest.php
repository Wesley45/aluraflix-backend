<?php

use Laravel\Lumen\Testing\DatabaseMigrations;

class VideoTest extends TestCase
{
    use DatabaseMigrations;

    public function testShouldBeAbleToCreateAVideo()
    {
        $data = [
            'title' => 'Diferença entre Back-End e Front-End com Mario Souto',
            'description' => 'Qual a diferença entre Back-end e Front-end? É possível se especializar nas duas áreas? Como é a rotina desses profissionais e com quais outras áreas da tecnologia acabam se relacionando?',
            'url' => 'https://www.youtube.com/watch?v=xrRy3RI3HE4&t=766s'
        ];

        $response = $this->call('POST', '/api/videos', $data);

        $this->assertEquals(201, $response->status());
    }

    public function testShouldBeAbleToGeAllVideo()
    {
        $response = $this->call('GET', '/api/videos');
        $videos = json_decode($response->content(), true);

        echo "<pre>";
        print_r($videos);
        echo "<pre>";
        $this->assertEquals(200, $response->status());
    }
}
