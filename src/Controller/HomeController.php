<?php

namespace App\Controller;

use App\Entity\FacebookPage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(FacebookPage::class);
        $facebookpages = $repository->findAll();
        
        return $this->render('/home/home.html.twig', array(
            "facebook_pages" => $facebookpages
        ));
    }
    

}
