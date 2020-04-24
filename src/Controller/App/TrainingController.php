<?php

namespace App\Controller\App;

use App\Entity\Exercise;
use App\Entity\Training;
use App\Entity\User;
use App\Form\Type\ExerciseType;
use App\Repository\ExerciseRepository;
use App\Repository\TrainingRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/training", name="app_training_")
 */
class TrainingController extends AbstractController
{
    /**
     * @Route("/{training}/exercise", name="exercise_add", methods={"GET", "POST"})
     */
    public function exerciseAdd(Request $request, Training $training)
    {
        $exercise = new Exercise();

        $form = $this->createForm(ExerciseType::class, $exercise);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $exercise = $form->getData();
            $exercise->setDescription('Your description');
            $exercise->setTraining($training);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($exercise);
            $entityManager->flush();

            return $this->redirectToRoute('app_ward_list');
        }

        return $this->render('training/exercise_add.html.twig', [
            'form' => $form->createView(),
            'training' => $training,
        ]);
    }

    /**
     * @Route("/{ward}/create", name="create", methods={"GET", "POST"})
     */
    public function create(User $ward)
    {
        $training = new Training();

        $entityManager = $this->getDoctrine()->getManager();
        $training->setTrainer($this->getUser());
        $training->setWard($ward);
        $entityManager->persist($training);
        $entityManager->flush();

        return $this->redirectToRoute('app_training_edit', [
            'training' => $training->getId()
        ]);
    }

    /**
     * @Route("/{ward}/list", name="list")
     */
    public function list(User $ward, TrainingRepository $trainingRepository, UserRepository $userRepository)
    {
        $trainer = $this->getUser();
        $trainings = $trainingRepository->findByWardAndTrainer($trainer, $ward);

        return $this->render('training/list.html.twig', [
            'trainings' => $trainings
        ]);
    }

    /**
     * @Route("/{training}/edit", name="edit")
     */
    public function trainingEdit(Request $request, Training $training)
    {
        return $this->render('training/edit.html.twig', [
            'training' => $training
        ]);
    }

    public function trainingRemove()
    {
        return new JsonResponse([]);
    }
}
