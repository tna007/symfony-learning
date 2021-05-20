<?php

namespace App\Controller;


use App\Entity\Direction;
use App\Entity\Ingredient;
use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use PhpParser\Node\Scalar\MagicConst\Dir;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeScreen2Controller extends AbstractController
{
    #[Route('/homepage', name: 'homepage', methods: ['GET'])]
    public function index(Request $request): Response
    {
        return $this->json([
            'message' => $request->query->get('page')
        ]);
    }

    #[Route('/recipe/{id}', name: 'get_recipe', methods: ['GET'])]
    public function recipe($id, Request $request) {
        return $this->json([
            'message' => 'Requesting recipe with id' . $id,
            'page' => $request->query->get('page')
        ]);
    }

    #[Route('/recipes/all', name: 'all_recipes', methods: ['GET'])]
    public function getAllRecipes() {
        $rootPath = $this->getParameter('kernel.project_dir');
        $recipes = file_get_contents($rootPath.'/resources/recipes.json');
        $decodedRecipes = json_decode($recipes, true);
        return $this->json($decodedRecipes);
    }

    public function other() {
        return $this->redirectToRoute("homepage");
    }

    #[Route('/recipes/add', name: 'add_new_recipe', methods: ['GET'])]
    public function addRecipe(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $newRecipe = new Recipe();
        $newRecipe-> setName($request->query->get('name'));
        $newRecipe-> setDifficulty($request->query->get('difficulty'));
        $newRecipe-> setImage($request->query->get('image'));

        $ingredient = new Ingredient();
        $ingredient->setName('some ingredient');
        $ingredient->setAmount('some amount');
        $ingredient->setRecipe($newRecipe);

        $ingredient2 = new Ingredient();
        $ingredient2->setName('some ingredient 2');
        $ingredient2->setAmount('some amount 2');
        $ingredient2->setRecipe($newRecipe);

        $entityManager->persist($ingredient);
        $entityManager->persist($ingredient2);
        $entityManager->persist($newRecipe);
        $entityManager->flush();

        return new Response("trying to add new recipe with id " . $newRecipe->getId() ." and new ingredient with id " . "and " . $ingredient->getId());
    }

    #[Route('/add', name: 'add_new_recipe', methods: ['POST'])]
    public function addNewRecipe(Request $request) {
        $manager = $this->getDoctrine()->getManager();
        $data = json_decode($request->getContent(), true);

        $recipe = new Recipe();
        $recipe->setName($data['name']);
        $recipe->setImage($data['image']);
        $recipe->setDifficulty($data['difficulty']);

        for ($i=0; $i < count($data['ingredients']); $i++) {
            $ingredient = new Ingredient();
            $ingredient->setIngredientName($data['ingredients'][$i]['name']);
            $ingredient->setAmount($data['ingredients'][$i]['amount']);
            $ingredient->setRecipe($recipe);
            $manager->persist($ingredient);
        }

        for ($i = 0; $i < count($data['direction']); $i++) {
            $direction = new Direction();
            $direction->setText($data['direction'][$i]['text']);
            $direction->setRecipe($recipe);
            $manager->persist($direction);
        }

        $manager->persist($recipe);
        $manager->flush();
        return new Response ("trying to add new recipe with id " .$recipe->getId());
//        return $this->json($data);
    }

    #[Route('/recipes', name: 'get_all_recipes')]
    public function getAllRecipe() {
        $recipes = $this->getDoctrine()->getRepository(Recipe::class)->findAll();
        $resp = [];

        foreach ($recipes as $recipe) {
            $ingredients = $this->getDoctrine()->getRepository(Ingredient::class)->findBy(['recipe'=>$recipe]);
            $directions = $this->getDoctrine()->getRepository(Direction::class)->findBy(['recipe'=>$recipe]);
            $list = [];
            $instruction = [];

            foreach ($ingredients as $ingredient) {
                $list[] = array(
                    'ingredientName' => $ingredient->getIngredientName(),
                    'amount' => $ingredient->getAmount()
                );
            }
            foreach ($directions as $direction) {
                $instruction[] = array(
                    'step' => $direction->getId(),
                    'text' => $direction->getText()
                );
            }
            $resp[] = array(
                'id' => $recipe->getId(),
                'name' => $recipe->getName(),
                'ingredients' => $list,
                'difficulty' => $recipe->getDifficulty(),
                'image' => $recipe->getImage(),
                'direction' => $instruction
            );
        }
        return $this->json($resp);
    }

    #[Route('/recipes/{id}', name: 'find_recipe')]
    public function findRecipe($id) {
        $recipe = $this->getDoctrine()->getRepository(Recipe::class)->find($id);
        $ingredients = $this->getDoctrine()->getRepository(Ingredient::class)->findBy(['recipe'=>$recipe]);
        $directions = $this->getDoctrine()->getRepository(Direction::class)->findBy(['recipe'=>$recipe]);
        $list = [];
        $instruction = [];
        foreach ($ingredients as $ingredient) {
            $list[] = array(
                'ingredientName' => $ingredient->getIngredientName(),
                'amount' => $ingredient->getAmount()
            );
        }
        foreach ($directions as $direction) {
            $instruction[] = array(
                'step' => $direction->getId(),
                'text' => $direction->getText()
            );
        }
        if (!$recipe) {
            throw $this->createNotFoundException(
                "No recipe found with the id $id."
            );
        } else {
            return $this->json([
                'id' => $recipe->getId(),
                'name' => $recipe->getName(),
                'ingredients' => $list,
                'difficulty' => $recipe->getDifficulty(),
                'image' => $recipe->getImage(),
                'direction' => $instruction
            ]);
        }

    }

    #[Route('/recipe/edit/{id}/{name}', name: 'edit_recipe')]
    public  function editRecipe($id, $name) {
        $entityManager = $this->getDoctrine()->getManager();
        $recipe = $this->getDoctrine()->getRepository(Recipe::class)->find($id);

        if (!$recipe) {
            throw $this->createNotFoundException(
                "No recipe found with the id $id."
            );
        } else {
            $recipe->setName($name);
            $entityManager->flush();

            return $this->json([
                'message' => "Recipe id $id edited."
            ]);
        }
    }

    #[Route('/recipe/remove/{id}', name: 'remove_recipe')]
    public function removeRecipe($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $recipe = $this->getDoctrine()->getRepository(Recipe::class)->find($id);


        if (!$recipe) {
            throw $this->createNotFoundException(
                "No recipe found with the id $id."
            );
        } else {
            $entityManager->remove($recipe);

            $entityManager->flush();

            return $this->json([
                'message' => "Recipe id $id removed."
            ]);
        }
    }


}


