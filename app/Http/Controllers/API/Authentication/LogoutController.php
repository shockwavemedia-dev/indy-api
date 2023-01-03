<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Authentication;

use App\Http\Controllers\API\AbstractAPIController;
use Exception;
use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;
use Symfony\Component\HttpFoundation\Response;

final class LogoutController extends AbstractAPIController
{
    private RefreshTokenRepository $refreshTokenRepository;

    private TokenRepository $tokenRepository;

    public function __construct(
        RefreshTokenRepository $refreshTokenRepository,
        TokenRepository $tokenRepository
    ) {
        $this->refreshTokenRepository = $refreshTokenRepository;
        $this->tokenRepository = $tokenRepository;
    }

    public function __invoke(): JsonResource
    {
        try {
            /** @var \App\Models\User $user */
            $user = auth()->user();

            $token = $user?->token();

            if ($token?->id === null) {
                return $this->respondError('No access.', Response::HTTP_UNAUTHORIZED);
            }

            $this->tokenRepository->revokeAccessToken($token->id);
            $this->refreshTokenRepository->revokeRefreshTokensByAccessTokenId($token->id);

            return new JsonResource([
                'status' => 'success',
                'message' => 'logout',
            ]);
            // @codeCoverageIgnoreStart
        } catch (Exception $exception) {
            return $this->respondInternalError([
                'error' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ]);
            // @codeCoverageIgnoreEnd
        }
    }
}
