<?php

declare(strict_types=1);

namespace App\Services\MailChimp\Resources;

use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

final class CampaignResource extends DataTransferObject
{
    public int $clicks;

    public int $emailsSent;

    public string $id;

    public string $listId;

    public int $opens;

    public string $sendTime;

    public string $subjectLine;

    public string $title;

    public function getClicks(): int
    {
        return $this->clicks;
    }

    public function getEmailsSent(): int
    {
        return $this->emailsSent;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getListId(): string
    {
        return $this->listId;
    }

    public function getOpens(): int
    {
        return $this->opens;
    }

    public function getSendTime(): string
    {
        $sendDate = new Carbon($this->sendTime);

        return $sendDate->format('d-m-Y g:iA');
    }

    public function getSubjectLine(): string
    {
        return $this->subjectLine;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
