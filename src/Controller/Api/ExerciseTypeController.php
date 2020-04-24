<?php


namespace App\Controller\Api;


use App\Entity\ExerciseType;
use App\Repository\ExerciseTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/exercise-type", methods={"POST"}, name="exercise_type_")
 */
class ExerciseTypeController extends AbstractFOSRestController
{
    /**
     * @Route("/search", methods={"POST"}, name="search")
     */
    public function search(Request $request, ExerciseTypeRepository $exerciseTypeRepository)
    {
        $query = $request->get('query');
        $exerciseTypes = $exerciseTypeRepository->findExerciseTypesByQuery($query);
        $view = $this->view($exerciseTypes, Response::HTTP_OK);
        $view->setContext((new Context())->addGroup('search'))
            ->setFormat('json');
        return $this->handleView($view);
    }

    /**
     * @Route("", methods={"POST"}, name="create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager)
    {
        $typeName = $request->get('typeName');

        $exerciseType = new ExerciseType();
        $exerciseType->setTrainer($this->getUser())
            ->setName($typeName);

        $entityManager->persist($exerciseType);
        $entityManager->flush();

        $view = $this->view($exerciseType, Response::HTTP_OK);
        $view->setContext(
            (new Context())
                ->addGroup('id')
                ->addGroup('create')
        )
            ->setFormat('json');
        return $this->handleView($view);
    }
}