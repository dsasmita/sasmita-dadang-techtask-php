<?php

namespace App\Entity;

class Ingredient{

    private $title;

    /**
     * @var string
     */
    private $bestBefore;

    /**
     * @var string
     */
    private $useBy;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getBestBefore(): ?string
    {
        return $this->bestBefore;
    }

    public function getUseBy(): ?string
    {
        return $this->useBy;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setBestBefore(string $bestBefore): self
    {
        $this->bestBefore = $bestBefore;

        return $this;
    }

    public function setUseBy(string $useBy): self
    {
        $this->useBy = $useBy;

        return $this;
    }
}