<?php


namespace App\Controller\Api;


use App\Entity\Training;
use App\Repository\ExerciseRepository;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/trainings", name="trainings_")
 */
class TrainingController extends AbstractFOSRestController
{
    /**
     * @Route("/{training}/exercises", name="exercises")
     */
    public function exerciseList(Training $training, ExerciseRepository $exerciseRepository)
    {
        $exercises = $exerciseRepository->findExercisesByTraining($training);

        $view = $this->view($exercises, Response::HTTP_OK);
        $view->setContext((new Context())->addGroup('training_edit'))
            ->setFormat('json');
        return $this->handleView($view);
    }
}




//public function exerciseList(Training $training, ExerciseRepository $exerciseRepository)
//{
//    $exerciseResult = [];
//    $exercises = $exerciseRepository->findExercisesByTraining($training);
//
//    /** @var Exercise $exercise */
//    foreach ($exercises as $exercise) {
//        $exerciseData = [];
//        $exerciseData ['id'] = $exercise->getId();
//        $exerciseData ['name'] = $exercise->getExerciseType()->getName();
//        $exerciseData ['parameters'] = [];
//        foreach ($exercise->getExerciseParameters() as $parameter) {
//            $parameterData = [];
//            $parameterData ['id'] = $parameter->getId();
//            $parameterData ['name'] = $parameter->getType()->getName();
//            $parameterData ['value'] = $parameter->getValue();
//            $exerciseData ['parameters'] [] = $parameterData;
//        }
//        $exerciseResult[] = $exerciseData;
//    }
//    return new JsonResponse($exerciseResult);
//}