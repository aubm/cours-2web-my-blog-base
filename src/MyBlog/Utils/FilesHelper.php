<?php

namespace MyBlog\Utils;

use MyBlog\Http\RequestFile;

class FilesHelper
{
    public function moveRequestFile(RequestFile $request_file, $destination_folder)
    {
        // Generate a unique name for the file
        $destination_file_name = md5(uniqid());
        $file_extension = $this->getFileExtension($request_file->getName());
        if ($file_extension) {
            $destination_file_name .= '.' . $file_extension;
        }

        move_uploaded_file($request_file->getTmpName(), $destination_folder . '/' . $destination_file_name);
        return $destination_file_name;
    }

    public function getFileExtension($filename)
    {
        $filename_parts = explode('.', $filename);
        if (count($filename_parts) < 2) {
            $file_extension = '';
        } else {
            $file_extension = end($filename_parts);
        }

        return $file_extension;
    }

    public function deleteFile($directory, $filename)
    {
        unlink($directory . '/' . $filename);
    }
}