<?php

namespace App\Entity;

class Recipe
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var array<Mixed>
     */
    private $ingredients;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return array<Mixed>
     */
    public function getIngredients(): ?array
    {
        return $this->ingredients;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param array<Mixed> $ingredient
     */
    public function setIngredients(array $ingredient): self
    {
        $this->ingredients = $ingredient;

        return $this;
    }
}
