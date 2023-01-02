<?php

declare(strict_types=1);

namespace App\Services\SocialMedia\Resources;

use App\Models\SocialMedia;
use App\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateCommentResource extends DataTransferObject
{
    public SocialMedia $socialMedia;

    public User $createdBy;

    public string $comment;

    /**
     * @return SocialMedia
     */
    public function getSocialMedia(): SocialMedia
    {
        return $this->socialMedia;
    }

    /**
     * @return User
     */
    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }
}
