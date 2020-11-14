<?php

namespace App\Service;

use App\Entity\Ingredient;
use App\Repository\IngredientRepository;

class MenuIngredient
{
    /** @var IngredientRepository */
    private $ingredientRepository;

    public function __construct(IngredientRepository $ingredientRepository)
    {
        $this->ingredientRepository = $ingredientRepository;
    }

    public function getMenu($date)
    {
        return $this->ingredientRepository->getIngredients();
    }
}
