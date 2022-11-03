<?php

declare(strict_types=1);

namespace App\Services\SMS;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Services\SMS\Exceptions\SmsApiException;
use App\Services\SMS\Interfaces\SmsClientInterface;
use App\Services\SMS\Interfaces\SmsConfigResolverInterface;
use App\Services\SMS\Resources\SmsConfigResource;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use function sprintf;

final class SmsClient implements SmsClientInterface
{
    private ErrorLogInterface $sentryHandler;

    private SmsConfigResource $config;

    private ClientInterface $client;

    public function __construct(
        ClientInterface            $client,
        ErrorLogInterface          $sentryHandler,
        SmsConfigResolverInterface $configResolver,
    ) {
        $this->config = $configResolver->resolve();
        $this->client = $client;
        $this->sentryHandler = $sentryHandler;
    }

    /**
     * @throws SmsApiException
     */
    public function makeRequest(string $method, string $url, ?array $options = null): array
    {
        $options = $options ?? [];

        $url = sprintf(
            '%s/%s',
            $this->config->getUrl(),
            $url
        );

        $options = $options = array_merge([
            'auth' => [
                $this->config->getUsername(),
                $this->config->getPassword(),
            ],
        ], $options);

        try {
            $response = $this->client->request($method, $url, $options);

            $body = $response->getBody()->getContents();

            if ($response->getStatusCode() !== ResponseAlias::HTTP_OK) {
                $error = json_decode($body, true);

                throw new SmsApiException(
                    'Invalid Response.',
                    ''
                );
            }

            return json_decode($body, true);
        } catch (GuzzleException | RequestException | SmsApiException $exception) {
            $this->sentryHandler->reportError($exception);

            throw new SmsApiException(
                'Invalid Response.',
                ''
            );
        }
    }
}
