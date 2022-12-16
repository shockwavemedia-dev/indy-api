<?php

declare(strict_types=1);

namespace App\Jobs\PrinterJobs;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Models\PrinterJob;
use App\Repositories\Interfaces\PrinterJobRepositoryInterface;
use App\Services\Slack\Exceptions\SlackSendMessageException;
use App\Services\Slack\Exceptions\SlackUserNullException;
use App\Services\Slack\Interfaces\SlackSendMessageInterface;
use App\Services\Slack\Interfaces\SlackUserResolverInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

final class GenericPrintManagerSlackNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $message;

    private int $printerJobId;

    public function __construct(int $printerJobId, string $message)
    {
        $this->printerJobId = $printerJobId;
        $this->message = $message;
    }

    /**
     * @throws \Exception
     */
    public function handle(
        PrinterJobRepositoryInterface $printerJobRepository,
        SlackUserResolverInterface $slackUserResolver,
        SlackSendMessageInterface $slackSendMessage,
        ErrorLogInterface $sentryHandler
    ): void {
        /** @var PrinterJob $printerJob */
        $printerJob = $printerJobRepository->find($this->printerJobId);

        $printerUser = $printerJob->getPrinter()->getUser();

        try {
            $url = Config::get('mail.client_url', null);

            if ($url === null) {
                throw new \Exception('Url for client is empty');
            }

            $url = sprintf('%s/printer-jobs/%s', $url, $this->printerJobId);

            $slackUser = $slackUserResolver->findSlackUser($printerUser);

            $slackSendMessage->sendMessage($slackUser, \sprintf('%s %s', $this->message, $url));

            $sentryHandler->log($this->message);
        } catch (SlackUserNullException|SlackSendMessageException $exception) {
            $sentryHandler->log(sprintf('This email does not have slack account %s', $printerUser->getEmail()));
        } catch (UnknownProperties $e) {
            $sentryHandler->reportError($e);
        }
    }
}
