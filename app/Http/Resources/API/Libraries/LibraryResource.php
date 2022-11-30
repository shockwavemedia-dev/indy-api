<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Libraries;

use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;
use App\Models\Library;

final class LibraryResource extends Resource
{
    public static $wrap = null;

    private ?bool $showLink = false;

    public function __construct($resource, ?bool $showLink = false)
    {
        $this->showLink = $showLink;
        parent::__construct($resource);
    }

    /**
     * @return mixed[]
     *
     * @throws \App\Exceptions\InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof Library) === false) {
            throw new InvalidResourceTypeException(
                Library::class
            );
        }

        /** @var \App\Models\Library $library */
        $library = $this->resource;

        $category = $library->getLibraryCategory();

        $result = [
            'id' => $library->getId(),
            'title' => $library->getTitle(),
            'description' => $library->getDescription(),
            'library_category_name' => $category->getName(),
            'library_category_id' => $category->getId(),
        ];

        if ($this->showLink === true) {
            $result['video_link'] = $library->getVideoLink() ?? $library->getFile()?->getUrl();
        }

        return $result;
    }
}
