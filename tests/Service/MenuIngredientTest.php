<?php

namespace App\Tests\Service;

use App\Repository\IngredientRepository;
use App\Repository\RecipeRepository;
use App\Service\MenuIngredient;
use PHPUnit\Framework\TestCase;

class PayslipComputationTest extends TestCase
{
    private $mockPayslipPayItemRepository;
    private $mockPayslip;
    private $mockArrayCollection;

    protected function setUp()
    {
        $this->mockIngredientRepository = $this->getMockBuilder(IngredientRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockRecipeRepository = $this->getMockBuilder(RecipeRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @dataProvider getTestDataIngredients
     */
    public function testGetAvailableIngredientsHappyCase($ingredients, $date, $expected)
    {
        $menuIngredient = new MenuIngredient(
            $this->mockIngredientRepository,
            $this->mockRecipeRepository
        );

        $result = $menuIngredient->getAvailableIngredients($ingredients, $date);
        // check is array
        $this->assertIsArray($result);
        // check return
        $this->assertEquals($result, $expected);
    }

    /**
     * @dataProvider getTestDataRecipes
     */
    public function testGetAvailableRecipes($recipes, $availableIngredients, $date, $expected)
    {
        $menuIngredient = new MenuIngredient(
            $this->mockIngredientRepository,
            $this->mockRecipeRepository
        );

        $result = $menuIngredient->getAvailableRecipes($recipes, $availableIngredients, $date);
        // check is array
        $this->assertIsArray($result);
        // check return
        $this->assertEquals($result, $expected);
    }

    /**
     * @dataProvider getTedDataMenus
     */
    public function testGetMenu($ingredients, $recipes, $date, $expected)
    {
        $this->mockIngredientRepository
            ->expects($this->once())
            ->method('getIngredients')
            ->willReturn($ingredients);

        $this->mockRecipeRepository
            ->expects($this->once())
            ->method('getRecipes')
            ->willReturn($recipes);

        $menuIngredient = new MenuIngredient(
            $this->mockIngredientRepository,
            $this->mockRecipeRepository
        );

        $result = $menuIngredient->getMenu($date);
        // check is array
        $this->assertIsArray($result);
        // check return
        $this->assertEquals($result, $expected);
    }

    public function getTestDataIngredients()
    {
        return [
            'List ingredients and all available' => [
                'ingredients' => [
                    (object) [
                        'title' => 'Ham',
                        'bestBefore' => '2019-03-25',
                        'useBy' => '2019-03-27',
                    ],
                    (object) [
                        'title' => 'Cheese',
                        'bestBefore' => '2019-03-08',
                        'useBy' => '2019-03-13',
                    ],
                ],
                'date' => '2019-03-07',
                'expected' => [
                    'Ham' => (object) [
                            'title' => 'Ham',
                            'bestBefore' => '2019-03-25',
                            'useBy' => '2019-03-27',
                        ],
                    'Cheese' => (object) [
                            'title' => 'Cheese',
                            'bestBefore' => '2019-03-08',
                            'useBy' => '2019-03-13',
                        ],
                ],
            ],
            'List ingredients and some are available' => [
                'ingredients' => [
                    (object) [
                        'title' => 'Ham',
                        'bestBefore' => '2019-03-25',
                        'useBy' => '2019-03-27',
                    ],
                    (object) [
                        'title' => 'Cheese',
                        'bestBefore' => '2019-03-08',
                        'useBy' => '2019-03-13',
                    ],
                ],
                'date' => '2019-03-14',
                'expected' => [
                    'Ham' => (object) [
                            'title' => 'Ham',
                            'bestBefore' => '2019-03-25',
                            'useBy' => '2019-03-27',
                        ],
                ],
            ],
            'List ingredients and all not available' => [
                'ingredients' => [
                    (object) [
                        'title' => 'Ham',
                        'bestBefore' => '2019-03-25',
                        'useBy' => '2019-03-27',
                    ],
                    (object) [
                        'title' => 'Cheese',
                        'bestBefore' => '2019-03-08',
                        'useBy' => '2019-03-13',
                    ],
                ],
                'date' => '2019-03-28',
                'expected' => [],
            ],
        ];
    }

    public function getTestDataRecipes()
    {
        return [
            'List ingredients, recipes all empty' => [
                'recipes' => [],
                'availableIngredients' => [],
                'date' => '2019-03-07',
                'expected' => [],
            ],
            'List ingredients, recipes all available' => [
                'recipes' => [
                    (object) [
                        'title' => 'Ham and Cheese Toastie',
                        'ingredients' => [
                            'Ham',
                            'Cheese',
                            'Bread',
                            'Butter',
                        ],
                    ],
                    (object) [
                        'title' => 'Ham and Cheese Toastie 2',
                        'ingredients' => [
                            'Ham',
                            'Butter',
                            'Bread',
                        ],
                    ],
                ],
                'availableIngredients' => [
                    'Ham' => (object) [
                        'title' => 'Ham',
                        'bestBefore' => '2019-03-25',
                        'useBy' => '2019-03-27',
                    ],
                    'Cheese' => (object) [
                        'title' => 'Cheese',
                        'bestBefore' => '2019-03-08',
                        'useBy' => '2019-03-13',
                    ],
                    'Bread' => (object) [
                        'title' => 'Bread',
                        'bestBefore' => '2019-03-08',
                        'useBy' => '2019-03-13',
                    ],
                    'Butter' => (object) [
                        'title' => 'Butter',
                        'bestBefore' => '2019-03-09',
                        'useBy' => '2019-03-13',
                    ],
                ],
                'date' => '2019-03-07',
                'expected' => [
                    (object) [
                        'title' => 'Ham and Cheese Toastie',
                        'ingredients' => [
                            'Ham',
                            'Cheese',
                            'Bread',
                            'Butter',
                        ],
                        'bestBefore' => '2019-03-08',
                    ],
                    (object) [
                        'title' => 'Ham and Cheese Toastie 2',
                        'ingredients' => [
                            'Ham',
                            'Butter',
                            'Bread',
                        ],
                        'bestBefore' => '2019-03-08',
                    ],
                ],
            ],
            'List ingredients, recipes, recipe not found' => [
                'recipes' => [
                    (object) [
                        'title' => 'Ham and Cheese Toastie',
                        'ingredients' => [
                            'Tenderloin',
                            'Cheese',
                            'Bread',
                            'Butter',
                        ],
                    ],
                ],
                'availableIngredients' => [
                    'Cheese' => (object) [
                        'title' => 'Cheese',
                        'bestBefore' => '2019-03-08',
                        'useBy' => '2019-03-13',
                    ],
                    'Bread' => (object) [
                        'title' => 'Bread',
                        'bestBefore' => '2019-03-08',
                        'useBy' => '2019-03-13',
                    ],
                    'Butter' => (object) [
                        'title' => 'Butter',
                        'bestBefore' => '2019-03-08',
                        'useBy' => '2019-03-13',
                    ],
                ],
                'date' => '2019-03-15',
                'expected' => [],
            ],
        ];
    }

    public function getTedDataMenus()
    {
        return [
            'List ingredients, recipes all empty' => [
                'ingredients' => [],
                'recipes' => [],
                'date' => '2019-03-07',
                'expected' => [
                    'date' => '2019-03-07',
                    'availableRecipes' => []
                ],
            ],
        ];
    }
}
