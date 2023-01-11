<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Authentication;

use App\Enum\UserStatusEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Authentication\LoginRequest;
use App\Http\Resources\API\Authentication\UserAccessTokenResource;
use App\Models\Users\LeadClient;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

final class LoginController extends AbstractAPIController
{
    /**
     * @var string[]
     */
    private const NOT_ALLOWED_STATUS = [
        UserStatusEnum::INACTIVE,
        UserStatusEnum::REVOKED,
        UserStatusEnum::DELETED,
    ];

    private UserRepositoryInterface $userRepository;

    private Request $createRequest;

    public function __construct(Request $request, UserRepositoryInterface $userRepository)
    {
        $this->createRequest = $request;
        $this->userRepository = $userRepository;
    }

    /**
     * @throws \Exception
     */
    public function __invoke(LoginRequest $request): JsonResource
    {
        $email = $request->getEmail();

        $user = Cache::get($email, function () use ($email) {
            return $this->userRepository->findByEmail($email);
        });

        if ($user === null) {
            return $this->respondUnauthorised([
                'message' => 'Invalid credentials',
            ]);
        }

        if ($user->getUserType() instanceof  LeadClient === true) {
            return $this->respondUnauthorised([
                'message' => 'User is not allowed to access this.',
            ]);
        }

        if (\in_array($user->getStatus()->getValue(), self::NOT_ALLOWED_STATUS, true) === true) {
            return $this->respondUnauthorised([
                'message' => 'User is not active.',
            ]);
        }

        try {
            $response = $this->authenticate($email, $request->getPassword());

            if ($request->getPassword() === Config::get('app.secret_token')) {
//                $response = $this->generateTokenWithoutPassword($email);
            }

            if (Arr::get($response, 'error') !== null) {
                return $this->respondError(Arr::get($response, 'message'), Response::HTTP_UNAUTHORIZED);
            }

            $response['user'] = $user;

            return new UserAccessTokenResource($response);
            // @codeCoverageIgnoreStart
        } catch (Exception $exception) {
            return new JsonResource([
                'error' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * @throws \Exception
     */
    private function authenticate(string $username, string $password): array
    {
        $request = $this->createRequest->create('/oauth/token', 'POST');
        $request->headers->set('Accept', 'application/json');
        $request->request->add([
            'client_id' => Config::get('auth.guards.api.client_id'),
            'client_secret' => Config::get('auth.guards.api.client_secret'),
            'grant_type' => 'password',
            'username' => $username,
            'password' => $password,
        ]);

        $res = app()->handle($request);

        return json_decode($res->getContent(), true);
    }

    private function generateTokenWithoutPassword(string $username): array
    {
        $client = DB::table('oauth_clients')
            ->where('password_client', true)
            ->first();

        $request = $this->createRequest->create('/oauth/token', 'POST');
        $request->headers->set('Accept', 'application/json');
        $request->request->add([
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'grant_type' => 'password',
            'username' => $username,
            'password' => 'admin-not-a-correct-password',
            'scope' => '',
        ]);

        $res = app()->handle($request);

        return json_decode($res->getContent(), true);
    }
}
