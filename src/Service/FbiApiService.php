<?php
declare(strict_types=1);

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class FbiApiService
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly string $apiPath,
    ) {
    }

    public function caseExists(string $query): bool
    {
        $response = $this->client->request('GET', $this->apiPath . '/v1/list', [
            'query' => [
                'title' => $query,
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            return false;
        }

        $data = $response->toArray(false);
        return !empty($data['items']);
    }
}
