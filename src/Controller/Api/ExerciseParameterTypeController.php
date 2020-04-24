<?php


namespace App\Controller\Api;


use App\Repository\ExerciseParameterTypeRepository;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/exercise-parameter-type", methods={"POST"}, name="exercise_parameter_type_")
 */
class ExerciseParameterTypeController extends AbstractFOSRestController
{
    /**
     * @Route("/search", methods={"POST"}, name="search")
     */
    public function search(Request $request, ExerciseParameterTypeRepository $exerciseParameterTypeRepository)
    {
        $query = $request->request->get('query');
        $exerciseParameterTypes = $exerciseParameterTypeRepository->findExerciseParameterTypesByQuery($query);
        $view = $this->view($exerciseParameterTypes, Response::HTTP_OK);
        $view->setContext((new Context())->addGroup('search'))
            ->setFormat('json');
        return $this->handleView($view);
    }
}