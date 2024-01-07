<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiGateway
{
    private const string CONTENT_TYPE = 'application/ld+json';

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly string $apiHost,
        private readonly string $apiPrefix
    ) {
    }

    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function get(string $entity, int $page = 1): array
    {
        return $this->request(Request::METHOD_GET, "{$this->makeEndpoint($entity)}?page=$page");
    }

    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getById(string $entity, int $id): array
    {
        return $this->request(Request::METHOD_GET, $this->makeEndpoint($entity, $id));
    }

    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function post(string $entity, array $values): array
    {
        return $this->request(Request::METHOD_POST, $this->makeEndpoint($entity), $values);
    }

    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function put(string $entity, int $id, array $values): array
    {
        return $this->request(Request::METHOD_PUT, $this->makeEndpoint($entity, $id), $values);
    }

    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function delete(string $entity, int $id): array
    {
        return $this->request(Request::METHOD_DELETE, $this->makeEndpoint($entity, $id));
    }

    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function request(string $method, string $endpoint, ?array $values = null): array
    {
        $options = [
            'headers' => [
                'content-type' => self::CONTENT_TYPE
            ]
        ];

        if ($values !== null) {
            $options['body'] = json_encode($values);
        }

        $response = $this->client->request($method, $endpoint, $options);

        return $response->getContent() ? $response->toArray() : ['status' => $response->getStatusCode()];
    }

    public function makeIri(string $entity, ?int $id = null): string
    {
        $iri = "{$this->apiPrefix}/$entity";

        return $id !== null ? "$iri/$id" : $iri;
    }

    public function makeEndpoint(string $entity, ?int $id = null): string
    {
        $iri = $this->makeIri($entity, $id);

        return "{$this->apiHost}/$iri";
    }

    public function getApiHost(): string
    {
        return $this->apiHost;
    }

    public function getApiPrefix(): string
    {
        return $this->apiPrefix;
    }
}
