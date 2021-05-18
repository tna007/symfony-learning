<?php

namespace App\Controller;



use App\Entity\Ingredient;
use App\Entity\Recipe;
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

    #[Route('/recipes', name: 'all_recipes', methods: ['GET'])]
    public function getAllRecipes() {
        $rootPath = $this->getParameter('kernel.project_dir');
        $recipes = file_get_contents($rootPath.'/resources/recipes.json');
        $decodedRecipes = json_decode($recipes, true);
        return $this->json($decodedRecipes);
    }

    public function other() {
        return $this->redirectToRoute("homepage");
    }

    #[Route('/recipes/add', name: 'add_new_recipe', methods: ['POST'])]
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
        $entityManager->persist($newRecipe);
        $entityManager->flush();

        return new Response("trying to add new recipe with id " . $newRecipe->getId() ." and new ingredient with id " . "and " . $ingredient->getId());
    }

    #[Route('/recipes/test', name: 'test_new_recipe', methods: ['GET'])]
    public function testRecipe(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $recipe = new Recipe();
        $recipe-> setName($request->query->get('name'));
        $recipe-> setDifficulty($request->query->get('difficulty'));
        $recipe-> setImage($request->query->get('image'));

        $ingredient = new Ingredient();
        $ingredient->setName($request->query->get('ingre-name'));
        $ingredient->setAmount($request->query->get('amount'));

//        $ingredient2 = new Ingredient();
//        $ingredient2->setName('some ingredient 2');
//        $ingredient2->setAmount('some amount 2');

        $ingredient->setRecipe($recipe);
//        $ingredient2->setRecipe($recipe);

        $entityManager->persist($ingredient);
//        $entityManager->persist($ingredient2);
        $entityManager->persist($recipe);
        $entityManager->flush();

        return new Response("trying to add new recipe with id " . $recipe->getId() . " and new ingredient with id " . $ingredient->getId());
    }

    #[Route('/test', name: 'test')]
    public function testAdd(Request $request) {
        $data = json_decode($request->getContent(), true);

        $recipe = new Recipe();
        $recipe->setName($data['name']);
        $recipe->setImage($data['image']);
        $recipe->setDifficulty($data['difficulty']);
        $recipe->setIngredients($data['ingredients']);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($recipe);
        $manager->flush();

        return new Response("trying to add new recipe with id " . $recipe->getId());
    }

    #[Route('/recipes/all', name: 'get_all_recipes')]
    public function getAllRecipe() {
        $recipes = $this->getDoctrine()->getRepository(Recipe::class)->findAll();
//        $ingredients = $this->getDoctrine()->getRepository(Ingredient::class)->findAll();
//
//        $list = [];
//        foreach ($ingredients as $ingredient) {
//            $list[] = array(
//                'name' => $ingredient->getName(),
//                'amount' => $ingredient->getAmount()
//            );
//        }

        $resp = [];
        foreach ($recipes as $recipe) {
            $resp[] = array(
                'id' => $recipe->getId(),
                'name' => $recipe->getName(),
                'ingredients' => $recipe->getIngredients(),
                'difficulty' => $recipe->getDifficulty(),
                'image' => $recipe->getImage()
            );
        }
        return $this->json($resp);
    }

    #[Route('/recipe/find/{id}', name: 'find_recipe')]
    public function findRecipe($id) {
        $recipe = $this->getDoctrine()->getRepository(Recipe::class)->find($id);

        if (!$recipe) {
            throw $this->createNotFoundException(
                "No recipe found with the id $id."
            );
        } else {
            return $this->json([
                'id' => $recipe->getId(),
                'name' => $recipe->getName(),
                'ingredients' => $recipe->getIngredients(),
                'difficulty' => $recipe->getDifficulty(),
                'image' => $recipe->getImage()
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


