<?php

declare(strict_types=1);

namespace App\Http\Requests\API\SocialMedia;

use App\Enum\SocialMediaStatusesEnum;
use App\Http\Requests\BaseRequest;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

final class CreateSocialMediaRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getPost(): string
    {
        return $this->getString('post');
    }

    public function getCopy(): ?string
    {
        return $this->getString('copy');
    }

    public function getNotes(): ?string
    {
        return $this->getString('notes');
    }

    public function getStatus(): SocialMediaStatusesEnum
    {
        return new SocialMediaStatusesEnum($this->getString('status'));
    }

    public function getChannels(): array
    {
        return $this->getArray('channels');
    }

    public function getPostDate(): ?Carbon
    {
        if ($this->getString('post_date') === null) {
            return null;
        }

        return new Carbon($this->getString('post_date'));
    }

    public function getPostTime(): ?string
    {
        return $this->getString('post_time');
    }

    public function getAttachments(): ?array
    {
        return $this->file('attachments');
    }

    public function getFileIds()
    {
        return $this->get('file_ids');
    }

    public function getCampaignType(): ?string
    {
        return $this->getString('campaign_type');
    }

    public function rules(): array
    {
        return [
            'campaign_type' => 'string|nullable',
            'post' => 'required|string',
            'copy' => 'string|nullable',
            'status' => [
                'string',
                Rule::in(SocialMediaStatusesEnum::toArray()),
            ],
            'channels' => 'array|nullable',
            'notes' => 'string|nullable',
            'post_date' => 'date|nullable',
            'attachments' => '',
            'file_ids' => 'array|nullable',
        ];
    }
}
