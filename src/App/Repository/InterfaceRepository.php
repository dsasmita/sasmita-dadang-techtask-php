<?php

namespace App\Repository;

interface InterfaceRepository
{
    /**
     * @param string $path
     */
    public function readJsonFile($path): object;
}
