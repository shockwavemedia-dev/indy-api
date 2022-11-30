<?php

declare(strict_types=1);

namespace App\Services\ClientTicketFiles;

use App\Models\Tickets\ClientTicketFile;
use App\Models\User;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Services\ClientTicketFiles\Exceptions\ReplaceFileNotAllowedException;
use App\Services\ClientTicketFiles\Interfaces\ProcessTicketFileReplaceInterface;
use App\Services\FileManager\Interfaces\FileRemoverInterface;
use App\Services\FileManager\Interfaces\FileUploaderInterface;
use App\Services\FileManager\Resources\UploadFileResource;
use App\Services\Files\Resources\CreateFileResource;
use Illuminate\Http\UploadedFile;

final class ProcessTicketFileReplace implements ProcessTicketFileReplaceInterface
{
    private FileRepositoryInterface $fileRepository;

    private FileRemoverInterface $fileRemover;

    private FileUploaderInterface $fileUploader;

    public function __construct(
        FileRepositoryInterface $fileRepository,
        FileRemoverInterface $fileRemover,
        FileUploaderInterface $fileUploader
    ) {
        $this->fileRemover = $fileRemover;
        $this->fileRepository = $fileRepository;
        $this->fileUploader = $fileUploader;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws \App\Services\ClientTicketFiles\Exceptions\ReplaceFileNotAllowedException
     * @throws \App\Services\ClientTicketFiles\Exceptions\FileNotExistException
     */
    public function replace(
        User $user,
        ClientTicketFile $clientTicketFile,
        UploadedFile $uploadedFile,
        string $filepath
    ): ClientTicketFile {
        if ($clientTicketFile->isApproved() === true) {
            throw new ReplaceFileNotAllowedException('File is already approved.');
        }

        /** @var \App\Models\File $fileExist */
        $fileExist = $clientTicketFile->getFile();

        $filename = \pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);

        $generatedFilename = \sprintf(
            '%s/%s-%s',
            $clientTicketFile->getClient()->getClientCode(),
            \sha1(\sprintf('%s%s', $filename, time())),
            $uploadedFile->getClientOriginalName()
        );

        $this->fileRemover->delete($fileExist, $user);

        $fileExist = $this->fileRepository->updateFile(
            $fileExist,
            new CreateFileResource([
                'disk' => $fileExist->getBucket(),
                'uploadedFile' => $uploadedFile,
                'fileName' => $generatedFilename,
                'filePath' => $filepath,
                'uploadedBy' => $user,
            ])
        );

        $this->fileUploader->upload(new UploadFileResource([
            'fileModel' => $fileExist,
            'fileObject' => $uploadedFile,
        ]));

        return $clientTicketFile;
    }
}
