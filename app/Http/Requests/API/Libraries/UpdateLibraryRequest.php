<?php

declare(strict_types=1);

namespace App\Http\Requests\API\Libraries;

use App\Http\Requests\BaseRequest;
use Illuminate\Http\UploadedFile;

final class UpdateLibraryRequest extends BaseRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function getFile(): ?UploadedFile
    {
        return $this->file('file');
    }

    public function getTitle(): ?string
    {
        return $this->getString('title');
    }

    public function getLibraryCategoryId(): int
    {
        return $this->getInt('library_category_id');
    }

    public function getDescription(): ?string
    {
        return $this->getString('description');
    }

    public function getVideoLink(): ?string
    {
        return $this->getString('video_link');
    }

    public function rules(): array
    {
        return [
            'title' => 'string|unique:App\Models\Library,title',
            'library_category_id' => 'required|int|exists:App\Models\LibraryCategory,id',
            'description' => 'string',
            'video_link' => '',
            'file' => '',
        ];
    }
}
