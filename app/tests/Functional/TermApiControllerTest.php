<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\AbstractTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TermApiControllerTest extends AbstractTestCase
{
    private const BASE_URL = '/api/v2/terms';

    public function testGetTermsShouldRetrieveAList(): void
    {
        $response = $this->client->request(Request::METHOD_GET, self::BASE_URL);
        $content = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertIsArray($content);

        $this->assertArrayHasKey('id', $content[0]);
        $this->assertArrayHasKey('taxonomy', $content[0]);

        $this->assertEquals(1, $content[0]['id']);
        $this->assertEquals('area', $content[0]['taxonomy']);
    }

    public function testGetOneTermShouldRetrieveAObject(): void
    {
        $response = $this->client->request(Request::METHOD_GET, self::BASE_URL.'/1');
        $content = json_decode($response->getContent());

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertIsObject($content);

        $this->assertObjectHasProperty('@entityType', $content);
        $this->assertEquals('term', $content->{'@entityType'});
    }

    public function testGetOneTermShouldReturnNotFound(): void
    {
        $nonExistentId = 99999999;
        $response = $this->client->request(Request::METHOD_GET, self::BASE_URL.'/'.$nonExistentId);

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testDeleteTermShouldReturnNoContent(): void
    {
        $response = $this->client->request(Request::METHOD_DELETE, self::BASE_URL.'/1');

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testDeletedTermShouldReturnNotFound(): void
    {
        $this->client->request(Request::METHOD_DELETE, self::BASE_URL.'/2');

        $response = $this->client->request(Request::METHOD_DELETE, self::BASE_URL.'/2');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}