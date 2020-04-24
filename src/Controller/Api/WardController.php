<?php


namespace App\Controller\Api;


use App\Repository\UserRepository;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Route("/wards", name="wards_")
 */
class WardController extends AbstractFOSRestController
{
    /**
     * @Route("/search", methods={"POST"}, name="search")
     * @Rest\View(serializerGroups={"search"})
     */
    public function search(Request $request, UserRepository $userRepository)
    {
        $query = $request->request->get('query');
        $wards = $userRepository->findWardsByTrainerAndQuery($this->getUser(), $query);
//        Возвращаюся все ward по запросу, и попадают в аргумент функции коллбека data в search_ward.js
        $view = $this->view($wards, Response::HTTP_OK);
        $view->setContext((new Context())->addGroup('search'))
            ->setFormat('json');
        return $this->handleView($view);
    }
}







//public function search(Request $request, UserRepository $userRepository)
//{
//    $wardsResult = [];
//    $query = $request->request->get('query');
//    $wards = $userRepository->findWardsByTrainerAndQuery($this->getUser(), $query);
//    /** @var User $ward */
//    foreach ($wards as $ward) {
//        $wardData = [];
//        $wardData ['firstName'] = $ward->getFirstName();
//        $wardData ['email'] = $ward->getEmail();
//        $wardData ['id'] = $ward->getId();
//
//        $wardsResult[] = $wardData;
//    }
////        Возвращаюся все ward по запросу, и попадают в аргумент функции коллбека data в search_ward.js
//    return new JsonResponse($wardsResult);
//}