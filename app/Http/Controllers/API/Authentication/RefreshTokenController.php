<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Authentication;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Authentication\RefreshTokenRequest;
use App\Http\Resources\API\Authentication\UserAccessTokenResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

final class RefreshTokenController extends AbstractAPIController
{
    public function __invoke(RefreshTokenRequest $request): JsonResource
    {
        $refreshToken = $request->getRefreshToken();

        try {
            $response = $this->generateRefreshToken($refreshToken);

            if (Arr::get($response, 'error') !== null) {
                return $this->respondError(Arr::get($response, 'message'), Response::HTTP_UNAUTHORIZED);
            }

            return new UserAccessTokenResource($response);
            // @codeCoverageIgnoreStart
        } catch (Exception $exception) {
            return $this->respondInternalError([
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ]);
            // @codeCoverageIgnoreEnd
        }
    }

    /**
     * @throws \Exception
     */
    private function generateRefreshToken(string $refreshToken): array
    {
        $request = Request::create('/oauth/token', 'POST');
        $request->headers->set('Accept', 'application/json');
        $request->request->add([
            'client_id' => Config::get('auth.guards.api.client_id'),
            'client_secret' => Config::get('auth.guards.api.client_secret'),
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'scope' => '',
        ]);

        $res = app()->handle($request);

        return json_decode($res->getContent(), true);
    }
}
