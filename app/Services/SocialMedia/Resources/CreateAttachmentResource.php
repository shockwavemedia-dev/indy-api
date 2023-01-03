<?php

declare(strict_types=1);

namespace App\Services\SocialMedia\Resources;

use App\Models\File;
use App\Models\SocialMedia;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateAttachmentResource extends DataTransferObject
{
    public SocialMedia $socialMedia;

    public File $file;

    /**
     * @return SocialMedia
     */
    public function getSocialMedia(): SocialMedia
    {
        return $this->socialMedia;
    }

    /**
     * @return File
     */
    public function getFile(): File
    {
        return $this->file;
    }
}
