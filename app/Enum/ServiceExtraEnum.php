<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class ServiceExtraEnum extends Enum
{
    /**
     * @var mixed[]
     */
    public const EXTRAS = [
        ServicesEnum::GRAPHIC_DESIGN => [
            'DL',
            'A4',
            'A3',
            'A2',
            'A1',
            'POS',
            'Pull-up Banner',
            'Whats on Guide',
            'Hi apps',
            'Facebook',
            'Instagram',
            'TV Screen',
        ],

        ServicesEnum::SOCIAL_MEDIA => [
            'Facebook Event',
            'Facebook Post',
            'Instagram',
            'Twitter',
        ],

        ServicesEnum::SOCIAL_MEDIA_SPEND => [
            'Facebook',
            'Instagram',
            'Youtube',
            'Twitter',
            'Tiktok',
        ],

        ServicesEnum::WEBSITE => [
            'Homepage Header',
            "What's On",
            'Bistro',
            'Custom',
        ],

        ServicesEnum::ANIMATION => [
            'Bank Ends',
            'Landscape',
            'Portrait',
            'MP4',
            'Bank Ends',
            'POS',
            'EGM',
            'Custom',
            'Social Media',
        ],

        ServicesEnum::PRINT => [
            'A0',
            'A1',
            'A2',
            'A3',
            'A4',
            'Pull Up Banner',
            'Blades Sign',
            'DL Postcard',
            'Doublesided DL',
            'Doublesided A4',
            'Custom',
        ],
    ];
}
