<?php

namespace App\Repository;

use App\Entity\Recipe;

class RecipeRepository extends BaseRepository
{
    /**
     * @var string
     */
    private $filename = __DIR__.'/../Data/Recipe.json';

    public function __construct()
    {
        $jsonContent = $this->readJsonFile($this->filename);
        $this->data = $this->loadData($jsonContent);
    }

    /**
     * @return array<Mixed>
     */
    private function loadData(object $jsonContent): array
    {
        $data = [];

        foreach ($jsonContent->recipes as $recipeObj) {
            $recipe = new Recipe();
            $recipe->setTitle($recipeObj->title);
            $recipe->setIngredients($recipeObj->ingredients);

            $data[] = $recipe;
        }

        return $data;
    }

    /**
     * @return array<Mixed>
     */
    public function getRecipes()
    {
        $data_collection = [];
        foreach ($this->data as $recipe) {
            $data = (object) [];
            $data->title = $recipe->getTitle();
            $data->useBy = $recipe->getIngredients();

            $data_collection[] = $data;
        }

        return $data_collection;
    }
}
