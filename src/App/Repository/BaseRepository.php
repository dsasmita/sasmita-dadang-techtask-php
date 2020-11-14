<?php

namespace App\Repository;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class BaseRepository implements InterfaceRepository
{
    protected $data;

    public function readJsonFile($path): object
    {
        if (!file_exists($path)){
            throw new FileNotFoundException($path);
        }

        $json_string = file_get_contents($path);
        $json_result = json_decode($json_string);
        if(json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception(json_last_error_msg());
        }

        return $json_result;
    }
}
