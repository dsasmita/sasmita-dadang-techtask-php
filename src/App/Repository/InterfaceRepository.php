<?php

namespace App\Repository;

interface InterfaceRepository
{
    public function readJsonFile($path) : object;
}
