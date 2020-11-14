<?php

namespace App\Controller;

use App\Service\PayslipComputation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MenuIngredient;

/**
 * @Route("/lunch")
 */
class LunchController extends AbstractController
{
    /**
     * @Route("/", name="lunch")
     */
    public function index(MenuIngredient $menuIngredient): JsonResponse
    {
        return $this->json($menuIngredient->getMenu('date'));
    }
}
