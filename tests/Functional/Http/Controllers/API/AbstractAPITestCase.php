<?php

declare(strict_types=1);

namespace Tests\Functional\Http\Controllers\API;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\TestResponse;
use Laravel\Passport\ClientRepository;
use Tests\TestCase;

abstract class AbstractAPITestCase extends TestCase
{
    use DatabaseTransactions;

    public array $headers = [];

    public function delete($uri, array $data = [], array $headers = []): TestResponse
    {
        $headers = \array_merge($headers, $this->headers);

        $response = parent::delete($uri, $data, $headers);

        $this->headers = [];

        return $response;
    }

    public function get($uri, array $headers = []): TestResponse
    {
        $headers = \array_merge($headers, $this->headers);

        $response = parent::get($uri, $headers);

        $this->headers = [];

        return $response;
    }

    public function post($uri, array $data = [], array $headers = []): TestResponse
    {
        $headers = \array_merge($headers, $this->headers);

        $response = parent::post($uri, $data, $headers);

        $this->headers = [];

        return $response;
    }

    public function put($uri, array $data = [], array $headers = []): TestResponse
    {
        $headers = \array_merge($headers, $this->headers);

        $response = parent::put($uri, $data, $headers);

        $this->headers = [];

        return $response;
    }

    public function toArrayResponse(TestResponse $response): array {
        $response = \json_decode($response->getContent(), true);

        return $response['data'] ?? $response;
    }

    protected function setHeadersToken(User $user): void
    {
        $token = $user->createToken('TestToken', [])->accessToken;

        $this->headers['Accept'] = 'application/json';

        $this->headers['Authorization'] = 'Bearer '.$token;
    }

    public function setUp(): void
    {
        parent::setUp();

        $adminUser = $this->env->user()->user;
        $clientRepository = new ClientRepository();

        $client = $clientRepository->createPersonalAccessClient(
            null, 'Test Personal Access Client', '/'
        );

        $password = $clientRepository->create(
            $adminUser->getId(),
            'Test Password Grant',
            '/',
            null,
            false,
            true,
            false
        );

        putenv(\sprintf('CLIENT_SECRET=%s',$password->secret));
        putenv(\sprintf('CLIENT_ID=%s',$password->id));

        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => $client->id,
            'created_at' => new Carbon(),
            'updated_at' => new Carbon(),
        ]);
//        $this->markTestSkipped('must be revisited.');
    }
}
