<?php

namespace App\Service;

use App\Repository\IngredientRepository;
use App\Repository\RecipeRepository;

class MenuIngredient
{
    /** @var IngredientRepository */
    private $ingredientRepository;

    /** @var RecipeRepository */
    private $recipeRepository;

    public function __construct(
        IngredientRepository $ingredientRepository,
        RecipeRepository $recipeRepository
    ) {
        $this->ingredientRepository = $ingredientRepository;
        $this->recipeRepository = $recipeRepository;
    }

    /**
     * @param string $date
     *
     * @return array<Mixed>
     */
    public function getMenu($date): array
    {
        $ingredients = $this->ingredientRepository->getIngredients();
        $availableIngredients = $this->getAvailableIngredients($ingredients, $date);

        $recipes = $this->recipeRepository->getRecipes();
        $availableRecipes = $this->getAvailableRecipes($recipes, $availableIngredients, $date);

        return [
            'date' => $date,
            'availableRecipes' => $availableRecipes,
        ];
    }

    /**
     * @param array <Mixed> $ingredients
     * @param string        $date
     *
     * @return array<Mixed>
     */
    public function getAvailableIngredients($ingredients, $date): array
    {
        $availableIngredients = [];
        foreach ($ingredients as $ingredient) {
            if ($date <= $ingredient->useBy) {
                $availableIngredients[$ingredient->title] = $ingredient;
            }
        }

        return $availableIngredients;
    }

    /**
     * @param array <Mixed> $recipes
     * @param array <Mixed> $availableIngredients
     * @param string        $date
     *
     * @return array<Mixed>
     */
    public function getAvailableRecipes($recipes, $availableIngredients, $date): array
    {
        $availableRecipes = [];
        foreach ($recipes as $recipe) {
            $bestBefore = null;
            $isRecipeAvailable = true;
            foreach ($recipe->ingredients as $useByRecipeIngredient) {
                if (!array_key_exists($useByRecipeIngredient, $availableIngredients)) {
                    $isRecipeAvailable = false;
                    break;
                }
                if (is_null($bestBefore) || $bestBefore >= $availableIngredients[$useByRecipeIngredient]->bestBefore) {
                    $bestBefore = $availableIngredients[$useByRecipeIngredient]->bestBefore;
                }
            }
            if ($isRecipeAvailable) {
                $recipe->bestBefore = $bestBefore;
                $availableRecipes[] = (object) $recipe;
            }
        }

        usort($availableRecipes, function ($a, $b) {
            return $a->bestBefore < $b->bestBefore;
        });

        return $availableRecipes;
    }
}
