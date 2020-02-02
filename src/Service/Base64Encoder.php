<?php
/**
 * Created by PhpStorm.
 * User: zoe
 * Date: 05/03/19
 * Time: 16:56
 */

namespace App\Service;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class Base64Encoder
{
    /**
     * Encoder for a path of image
     *
     * @param $uploadedFile
     *
     * @return string
     */
    public function encode(UploadedFile $uploadedFile)
    {
        $type = $uploadedFile->guessExtension();
        $data = file_get_contents($uploadedFile);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        return $base64;
    }
}