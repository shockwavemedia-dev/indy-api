<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\SocialMedia;

use App\Enum\EmailStatusEnum;
use App\Enum\NotificationStatusEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\SocialMedia\CreateSocialMediaCommentRequest;
use App\Http\Resources\API\SocialMedia\SocialMediaResource;
use App\Jobs\SocialMedia\MentionedSlackNotificationJob;
use App\Models\SocialMedia;
use App\Models\SocialMediaComment;
use App\Models\User;
use App\Repositories\Interfaces\SocialMediaRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\EmailLogs\Interfaces\EmailLogFactoryInterface;
use App\Services\EmailLogs\resources\CreateEmailLogResource;
use App\Services\Notifications\Interfaces\NotificationFactoryInterface;
use App\Services\Notifications\Interfaces\NotificationUserFactoryInterface;
use App\Services\Notifications\Resources\CreateNotificationResource;
use App\Services\Notifications\Resources\CreateNotificationUserResource;
use App\Services\SocialMedia\Interfaces\SocialMediaCommentFactoryInterface;
use App\Services\SocialMedia\Resources\CreateCommentResource;
use Illuminate\Http\Resources\Json\JsonResource;

final class CreateSocialMediaCommentController extends AbstractAPIController
{
    private EmailLogFactoryInterface $emailLogFactory;

    private NotificationFactoryInterface $notificationFactory;

    private NotificationUserFactoryInterface $notificationUserFactory;

    private SocialMediaRepositoryInterface $socialMediaRepository;

    private SocialMediaCommentFactoryInterface $socialMediaCommentFactory;

    private UserRepositoryInterface $userRepository;

    public function __construct(
        EmailLogFactoryInterface $emailLogFactory,
        NotificationFactoryInterface $notificationFactory,
        NotificationUserFactoryInterface $notificationUserFactory,
        SocialMediaRepositoryInterface $socialMediaRepository,
        SocialMediaCommentFactoryInterface $socialMediaCommentFactory,
        UserRepositoryInterface $userRepository,
    ) {
        $this->emailLogFactory = $emailLogFactory;
        $this->notificationFactory = $notificationFactory;
        $this->notificationUserFactory = $notificationUserFactory;
        $this->socialMediaCommentFactory = $socialMediaCommentFactory;
        $this->socialMediaRepository = $socialMediaRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function __invoke(CreateSocialMediaCommentRequest $request, int $id): JsonResource
    {
        /** @var SocialMedia $socialMedia */
        $socialMedia = $this->socialMediaRepository->find($id);

        if ($socialMedia === null) {
            return $this->respondNotFound([
                'message' => 'Social Media not found',
            ]);
        }

        $socialMediaComment = $this->socialMediaCommentFactory->make(new CreateCommentResource([
            'createdBy' => $this->getUser(),
            'socialMedia' => $socialMedia,
            'comment' => $request->getComment(),
        ]));

        if ($request->getTaggedUsers() !== null) {
            $users = $this->userRepository->findByIds($request->getTaggedUsers());

            // @Todo Transfer to a job
            /** @var User $user */
            foreach ($users as $user) {
                $emailLog = $this->emailLogFactory->make(new CreateEmailLogResource([
                    'message' => 'Send email from mention comments.',
                    'to' => $user->getEmail(),
                    'status' => new EmailStatusEnum(EmailStatusEnum::PENDING),
                    'emailType' => $socialMediaComment,
                ]));

                $user->sendEmailToMentionedSocialMediaUser(
                    $socialMedia,
                    $this->getUser(),
                    $emailLog
                );

                MentionedSlackNotificationJob::dispatch(
                    $this->getUser()->getId(),
                    $user->getId(),
                    $socialMedia->getId()
                );

                $this->saveNotification(
                    $socialMediaComment,
                    $user,
                    \sprintf(
                        'Hi %s, You have been mentioned by %s in a comment in social media %s',
                        $user->getFirstName(),
                        $this->getUser()->getFirstName(),
                        $socialMedia->getPost(),
                    ),
                );
            }
        }

        return new SocialMediaResource($socialMedia);
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function saveNotification(
        SocialMediaComment $socialMediaComment,
        User $user,
        string $title
    ): void {
        $notificationResource = new CreateNotificationResource([
            'morphable' => $socialMediaComment,
            'link' => \sprintf('social-media/%s', $socialMediaComment->getSocialMedia()->getId()),
            'statusEnum' => new NotificationStatusEnum(NotificationStatusEnum::NEW),
            'title' => $title,
        ]);

        $notification = $this->notificationFactory->make($notificationResource);

        $this->notificationUserFactory->make(new CreateNotificationUserResource([
            'notification' => $notification,
            'user' => $user,
        ]));
    }
}
