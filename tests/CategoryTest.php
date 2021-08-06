<?php

use Laravel\Lumen\Testing\DatabaseMigrations;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->json('POST', 'api/categories', $this->getFreeCategory());
    }

    /**
     * @dataProvider getCategory
     */
    public function testShouldBeAbleToCreateACategory(array $category)
    {
        $response = $this->json('POST', 'api/categories', $category,
            ['Accept' => 'application/json']);

        $response->seeStatusCode(201);
        $response->seeJsonStructure([
            'id',
            'title',
            'color',
        ]);
        $response->seeJsonEquals([
            'id' => 2,
            'title' => $category['title'],
            'color' => $category['color']
        ]);
    }

    /**
     * @return string[][]
     */
    public function getCategory(): array
    {
        $category = [
            'title' => 'Jogos',
            'color' => '#FF00FF'
        ];

        return [[$category]];
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
