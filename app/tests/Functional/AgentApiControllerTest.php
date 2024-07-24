<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\DataFixtures\AgentFixtures;
use App\Tests\AbstractTestCase;
use App\Tests\fixtures\AgentTestFixtures;
use MapasCulturais\App;
use MapasCulturais\Entities\User;
use ReflectionClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AgentApiControllerTest extends AbstractTestCase
{
    private const BASE_URL = '/api/v2/agents';

    public function testAuthentication()
    {
        $app = App::i();
        $reflection = new ReflectionClass($app);
        $method = $reflection->getMethod('_setAuthenticatedUser');

        $user = $app->en->getRepository(User::class)->findOneBy(['id' => 1]);
        $method->invoke($app, $user);

//        $authentication = $this->client->request(Request::METHOD_GET, 'http://localhost/autenticacao/fakeLogin/?fake_authentication_user_id=7');
//        $this->assertEquals(Response::HTTP_OK, $authentication->getStatusCode());
    }

    public function testGetAgentsShouldRetrieveAList(): void
    {
        $response = $this->client->request(Request::METHOD_GET, self::BASE_URL);
        $content = json_decode($response->getContent());

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertIsArray($content);
    }

    public function testGetOneAgentShouldRetrieveAObject(): void
    {
        $response = $this->client->request(Request::METHOD_GET, self::BASE_URL.'/1');
        $content = json_decode($response->getContent());

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertIsObject($content);
    }

    public function testGetAgentTypesShouldRetrieveAList(): void
    {
        $response = $this->client->request(Request::METHOD_GET, self::BASE_URL.'/types');
        $content = json_decode($response->getContent());

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertIsArray($content);
    }

    public function testGetAgentOpportunitiesShouldRetrieveAList(): void
    {
        $response = $this->client->request(Request::METHOD_GET, self::BASE_URL.'/1/opportunities');
        $content = json_decode($response->getContent());

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertIsArray($content);
    }

    public function testCreateAgentShouldCreateAnAgent(): void
    {
        $agentTestFixtures = AgentTestFixtures::partial();

        $response = $this->client->request(Request::METHOD_POST, self::BASE_URL, [
            'body' => $agentTestFixtures->json(),
        ]);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $content = json_decode($response->getContent());

        $this->assertEquals('Agent Test', $content->name);
    }

    public function testDeleteAgentShouldReturnSuccess(): void
    {
        $response = $this->client->request(Request::METHOD_DELETE, self::BASE_URL.'/2');
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());

        $response = $this->client->request(Request::METHOD_GET, self::BASE_URL.'/2');
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testUpdate(): void
    {
        $agentTestFixtures = AgentTestFixtures::completeInstance();

        $response = $this->client->request(Request::METHOD_PATCH, self::BASE_URL.'/7', [
            'body' => $agentTestFixtures->json(),
        ]);

        $content = json_decode($response->getContent(), true);
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertIsArray($content);
        foreach ($agentTestFixtures->toArray() as $key => $value) {
            $this->assertEquals($value, $content[$key]);
        }
    }

    public function testUpdateNotFoundedResource(): void
    {
        $agentTestFixtures = AgentTestFixtures::partial();

        $url = sprintf(self::BASE_URL.'/%s', 1969);

        $response = $this->client->request(Request::METHOD_PATCH, $url, [
            'body' => $agentTestFixtures->json(),
        ]);

        $error = [
            'error' => 'The resource was not found.',
        ];

        $content = json_decode($response->getContent(false), true);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertIsArray($content);
        $this->assertEquals($error, $content);
    }
}
