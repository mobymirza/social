<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageStorage
{
    public function uploadImage(UploadedFile $file): string
    {
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();
        $file->move('public/uploads', $fileName);
        return $fileName;
    }
}