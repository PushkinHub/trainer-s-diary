<?php


namespace App\Controller\Api;


use App\Entity\Exercise;
use App\Entity\ExerciseParameter;
use App\Entity\ExerciseParameterType;
use App\Entity\ExerciseType;
use App\Entity\Training;
use App\Repository\ExerciseParameterRepository;
use App\Repository\ExerciseRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/exercises", name="exercises_")
 */
class ExerciseController extends AbstractFOSRestController
{

    /**
     * @Route("", name="save", methods={"POST"})
     */
    public function save(Request $request, ExerciseRepository $exerciseRepository, EntityManagerInterface $entityManager)
    {
//        $exerciseTypeId новый тип который введен в input
        $exerciseTypeId = $request->get('exerciseTypeId');
        $trainingId = $request->get('trainingId');
        $exerciseId = $request->get('exerciseId');

        if ($exerciseId) {
            $exercise = $exerciseRepository->find($exerciseId);
        } else {
            $exercise = new Exercise();
            $training = $entityManager->getReference(Training::class, $trainingId);
            $exercise->setTraining($training);
            $entityManager->persist($exercise);
        }

        $exercise->setExerciseType($entityManager->getReference(ExerciseType::class, $exerciseTypeId));
        $entityManager->flush();

        $view = $this->view($exercise, Response::HTTP_OK);
        $view->setContext((new Context())->addGroup('id'))
            ->setFormat('json');
        return $this->handleView($view);
    }

    /**
     * @Route("/{exercise}", name="delete", methods={"DELETE"})
     */
    public function delete(Exercise $exercise, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($exercise);
        $entityManager->flush();
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/{exercise}/parameters", name="parameter_save", methods={"POST"})
     */
    public function parameterSave(Request $request, Exercise $exercise, ExerciseParameterRepository $exerciseParameterRepository, EntityManagerInterface $entityManager)
    {
//        Проверяет есть ли в базе параметр с такими свойствами
        $parameterTypeId = $request->get('parameterTypeId');
        $parameterValue = $request->get('parameterValue');
        $previousParameterId = $request->get('previousParameterId');

        $exerciseParameter = $exerciseParameterRepository->findOneBy([
            'type' => $parameterTypeId,
            'value' => $parameterValue
        ]);
//         Если параметра с такими свойствами в базе нет, создает новый
        if (!$exerciseParameter) {
//            Получаем объект ExerciseParameterType по ссылке на $parameterTypeId(без запроса в базу)
            $type = $entityManager->getReference(ExerciseParameterType::class, $parameterTypeId);
            $exerciseParameter = new ExerciseParameter();
            $exerciseParameter->setType($type);
            $exerciseParameter->setValue($parameterValue);
            $entityManager->persist($exerciseParameter);
        }
//        Если вводится другой параметр то предыдущая связь удаляется. Разница параметров определяется по id
        if ($exerciseParameter->getId() !== (int)$previousParameterId) {
            $exercise->removeExerciseParameter($entityManager->getReference(ExerciseParameter::class, $previousParameterId));
        }
//        Связывает exercise переданный в url и параметры
        $exercise->addExerciseParameter($exerciseParameter);
        $entityManager->flush();

        $view = $this->view($exerciseParameter, Response::HTTP_OK);
        $view->setContext((new Context())->addGroup('id'))
            ->setFormat('json');
        return $this->handleView($view);
    }

    /**
     * @Route("/{exercise}/parameters/{parameter}", name="parameter_delete", methods={"DELETE"})
     */
    public function parameterDelete(Exercise $exercise, ExerciseParameter $parameter, EntityManagerInterface $entityManager)
    {
        $exercise->removeExerciseParameter($parameter);
        $entityManager->flush();
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}