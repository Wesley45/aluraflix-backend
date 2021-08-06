<?php

use Laravel\Lumen\Testing\DatabaseMigrations;

class VideoTest extends TestCase
{
    use DatabaseMigrations;

    private array $data = [
        'title' => 'Diferença entre Back-End e Front-End com Mario Souto',
        'description' => 'Qual a diferença entre Back-end e Front-end? É possível se especializar nas duas áreas? Como é a rotina desses profissionais e com quais outras áreas da tecnologia acabam se relacionando?',
        'url' => 'https://www.youtube.com/watch?v=xrRy3RI3HE4&t=766s'
    ];

    private $responseData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->json('POST', 'api/categories', $this->getFreeCategory(), ['Accept' => 'application/json']);

        $this->responseData = $this->json(
            'POST',
            'api/videos',
            $this->data,
            ['Accept' => 'application/json']);
    }

    public function testShouldBeAbleToCreateAVideo()
    {
        $this->responseData->seeStatusCode(201)
            ->seeJsonStructure([
                'categoryId',
                'title',
                'description',
                'url',
            ])
            ->seeJsonEquals([
                'id' => 1,
                'categoryId' => 1,
                'title' => $this->data['title'],
                'description' => $this->data['description'],
                'url' => $this->data['url'],
            ]);
    }

    public function testShouldBeAbleToGeAllVideo()
    {
        $response = $this->get('api/videos')
            ->seeStatusCode(200)
            ->seeJsonStructure(
                ['data' =>
                    [
                        0 => [
                            'id',
                            'categoryId',
                            'title',
                            'description',
                            'url',
                        ]
                    ]
                ]
            );

        $video = json_decode($response->response->content());

        $this->assertEquals(1, $video->data[0]->id);
        $this->assertEquals($this->data['title'], $video->data[0]->title);
        $this->assertEquals($this->data['description'], $video->data[0]->description);
        $this->assertEquals($this->data['url'], $video->data[0]->url);
    }

    public function testShouldBeAbleToUpdateVideo()
    {
        $updateData = [
            'title' => 'Diferença entre Back-End e Front-End com Mario Santos',
            'description' => 'Qual a diferença entre Back-end e Front-end? É possível se especializar nas duas áreas? Como é a rotina desses profissionais e com quais outras áreas da tecnologia acabam se relacionando?',
            'url' => 'https://www.youtube.com/watch?v=xrRy3RI3HE4&t=766s'
        ];

        $this->json('PUT', 'api/videos/1', $updateData, ['Accept' => 'application/json'])
            ->seeStatusCode(200)
            ->seeJsonStructure([
                'id',
                'categoryId',
                'title',
                'description',
                'url',
            ])
            ->seeJsonEquals([
                'id' => 1,
                'categoryId' => 1,
                'title' => $updateData['title'],
                'description' => $updateData['description'],
                'url' => $updateData['url'],
            ]);
    }

    public function testShouldBeAbleToDeleteAVideo()
    {
        $this->json('DELETE', 'api/videos/1', [], ['Accept' => 'application/json'])
            ->seeStatusCode(204);
    }

    /**
     * @return string[]
     */
    private function getFreeCategory(): array
    {
        $category = [
            'title' => 'Livre',
            'color' => '#FF0000'
        ];

        return $category;
    }
}
