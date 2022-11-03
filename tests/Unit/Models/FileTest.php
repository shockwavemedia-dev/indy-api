<?php

declare(strict_types=1);

 namespace Tests\Unit\Models;

 use App\Models\File;
 use Carbon\Carbon;
 use PHPUnit\Framework\TestCase;

 /**
  * @covers \App\Models\File
  */
 final class FileTest extends TestCase
 {
     public function testGetterAndSetters(): void
     {

        $expected = [
            'id' => 1,
            'original_filename' => 'logo.png',
            'file_name' => '96365efc65a27cac2e477c809f19f2def6bc298f-logo.png',
            'file_size' => 29698,
            'file_path' => 'december/poster',
            'file_type' => 'image/png',
            'uploaded_by' => 1,
            'disk' => 'gcs',
            'version' => 1,
            'url' => 'https://storage.googleapis.com/aap1-client/december/poster/96365efc65a27cac2e477c809f19f2def6bc298f-feedback.PNG?GoogleAccessId=test2-707%40loyal-burner-340623.iam.gserviceaccount.com&Expires=1676699829&Signature=BM%2ByV1RKjI8HWkJdcvRmyPVcHwNIFx6TWHiEwhf00v35gzBuVbq5TpPq62xC%2BCPDNsVPjh8ez75n%2F1c9ts0ZGwPawV29oIkhBAnXdNSihvpQ2EqsUPCEEzyEKDhHgaLg4BKNNi6dmehcvybN%2BV2hKJceDTkcetWiRj48iF2wBFh%2B7%2BdExMJ%2B2mlc8FJ9pHnEfF9GQGzQEA3h%2BuPzpxGnYKXj1GGzn%2Bsljk43AgAB9cOUw8ku4nNkeACOzR5UybY8UB2UVTRuu40O8JZG48oGx9o3nKN8ZWQilvoTzqhXdg4gqFevtd0iAUBH80yl48%2B%2BnRzbnSTDLyE7cwbuGXzyTA%3D%3D',

        ];

        $file = new File();
        $file->setAttribute('id', 1);
        $file->setOriginalFileName('logo.png');
        $file->setFileName('96365efc65a27cac2e477c809f19f2def6bc298f-logo.png');
        $file->setFileSize(29698);
        $file->setFilePath('december/poster');
        $file->setFileType('image/png');
        $file->setAttribute('uploaded_by', 1);
        $file->setAttribute('disk', 'gcs');
        $file->setVersion(1);
        $file->setUrl('https://storage.googleapis.com/aap1-client/december/poster/96365efc65a27cac2e477c809f19f2def6bc298f-feedback.PNG?GoogleAccessId=test2-707%40loyal-burner-340623.iam.gserviceaccount.com&Expires=1676699829&Signature=BM%2ByV1RKjI8HWkJdcvRmyPVcHwNIFx6TWHiEwhf00v35gzBuVbq5TpPq62xC%2BCPDNsVPjh8ez75n%2F1c9ts0ZGwPawV29oIkhBAnXdNSihvpQ2EqsUPCEEzyEKDhHgaLg4BKNNi6dmehcvybN%2BV2hKJceDTkcetWiRj48iF2wBFh%2B7%2BdExMJ%2B2mlc8FJ9pHnEfF9GQGzQEA3h%2BuPzpxGnYKXj1GGzn%2Bsljk43AgAB9cOUw8ku4nNkeACOzR5UybY8UB2UVTRuu40O8JZG48oGx9o3nKN8ZWQilvoTzqhXdg4gqFevtd0iAUBH80yl48%2B%2BnRzbnSTDLyE7cwbuGXzyTA%3D%3D');

        $actual = [
            'id' => $file->getId(),
            'original_filename' => $file->getOriginalFileName(),
            'file_name' => $file->getFileName(),
            'file_size' => $file->getFileSize(),
            'file_path' => $file->getFilePath(),
            'file_type' => $file->getFileType(),
            'uploaded_by' => $file->getUploadedById(),
            'disk' => $file->getFileDisk(),
            'version' => $file->getVersion(),
            'url' => $file->getUrl(),
        ];

        self::assertEquals($expected, $actual);
    }
 }
