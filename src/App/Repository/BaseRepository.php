<?php

namespace App\Repository;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class BaseRepository implements InterfaceRepository
{
    /**
     * @var array<Mixed>
     */
    protected $data;

    /**
     * @param string $path
     */
    public function readJsonFile($path): object
    {
        if (!file_exists($path)) {
            throw new FileNotFoundException($path);
        }

        $json_string = file_get_contents($path);
        $json_result = json_decode($json_string);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \Exception(json_last_error_msg());
        }

        return $json_result;
    }
}
