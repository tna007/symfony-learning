<?php

namespace App\Controller;


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

    #[Route('/recipes/add', name: 'add_new_recipe', methods: ['GET'])]
    public function addRecipe(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();

        $newRecipe = new Recipe();
        $newRecipe-> setName($request->query->get('name'));
        $newRecipe-> setIngredients($request->query->get('ingredients'));
        $newRecipe-> setDifficulty($request->query->get('difficulty'));

        $entityManager->persist($newRecipe);
        $entityManager->flush();

        return new Response("trying to add new recipe" . $newRecipe->getId());
    }

    #[Route('/recipes/all', name: 'get_all_recipes')]
    public function getAllRecipe() {
        $recipes = $this->getDoctrine()->getRepository(Recipe::class)->findAll();

        $resp = [];
        foreach ($recipes as $recipe) {
            $resp[] = array(
                'name' => $recipe->getName(),
                'ingredients' => $recipe->getIngredients(),
                'difficulty' => $recipe->getDifficulty()
            );
        }
        return $this->json($resp);
    }

}


