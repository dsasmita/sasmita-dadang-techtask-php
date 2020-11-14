<?php

namespace App\Repository;

use App\Entity\Ingredient;

class IngredientRepository extends BaseRepository
{
    protected $ingredient;

    private $filename = __DIR__ . "/../Data/Ingredient.json";

    public function __construct()
    {
        $jsonContent = $this->readJsonFile($this->filename);
        $this->data = $this->loadData($jsonContent);
    }

    private function loadData($jsonContent)
    {
        $data = [];

        foreach($jsonContent->ingredients as $ingredientObj){
            $ingredient = new Ingredient();
            $ingredient->setTitle($ingredientObj->title);
            $ingredient->setBestBefore($ingredientObj->{"best-before"});
            $ingredient->setUseBy($ingredientObj->{"use-by"});

            $data[] = $ingredient;
        }

        return $data;
    }

    public function getIngredients()
    {
        $data_collection = [];
        foreach($this->data as $ingredient){
            $data = (object)[];
            $data->title = $ingredient->getTitle();
            $data->useBy = $ingredient->getUseBy();
            $data->bestBefore = $ingredient->getUseBy();

            $data_collection[] = $data;
        }
        return $data_collection;
    }
}
