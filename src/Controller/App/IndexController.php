<?php


namespace App\Controller\App;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    /**
     * @Route("/")
     */
    public function homepage(): RedirectResponse
    {
        return new RedirectResponse($this->generateUrl('app_ward_list'));
    }

}