<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeScreenController extends AbstractController
{

    /**
     * @Route ("/home")
     */
    public function home()
    {
//        return new Response('<h1>Hello world</h1>');
        return $this->json(['message'=> 'hello world']);
    }
}

