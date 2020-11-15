<?php

namespace App\Controller;

use App\Service\MenuIngredient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/lunch")
 */
class LunchController extends AbstractController
{
    /**
     * @Route("/", name="lunch")
     */
    public function index(Request $request, MenuIngredient $menuIngredient): JsonResponse
    {
        $date = $request->query->get('date', date('Y-m-d'));

        return $this->json(
            $menuIngredient->getMenu($date)
        );
    }
}
