<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeScreen2Controller extends AbstractController
{
    #[Route('/home/screen', name: 'home_screen', methods: ['GET'])]
    public function index(Request $request): Response
    {
        return $this->json([
            'message' => $request->query->get('page'),
//            'path' => 'src/Controller/HomeScreen2Controller.php',
        ]);
    }

    #[Route('/recipe/{id}', name: 'get_recipe', methods: ['GET'])]
    public function recipe($id, Request $request) {
        return $this->json([
            'message' => 'Requesting recipe with id' . $id,
            'page' => $request->query->get('page'),
//            'path' => 'src/Controller/HomeScreen2Controller.php',
        ]);
    }

    #[Route('/recipes', name: 'get_all_recipes', methods: ['GET'])]
    public function getAllRecipes() {
        $rootPath = $this->getParameter('kernel.project_dir');
        $recipes = file_get_contents($rootPath.'/resources/recipes.json');
        $decodedRecipes = json_decode($recipes, true);
        return $this->json($decodedRecipes);
    }

    public function other() {
        return $this->redirectToRoute('home_screen');
    }
}
