<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function index(Request $request) // sf < 4 => indexAction
    {
        // return new Response("Cool ca Marche !");
        return $this->render('index.html.twig', array(
            'name' => 'Norbert',
        ));
    }
}