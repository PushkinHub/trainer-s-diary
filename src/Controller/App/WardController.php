<?php

namespace App\Controller\App;

use App\Entity\Training;
use App\Entity\User;
use App\Form\Type\WardType;
use App\Repository\ExerciseRepository;
use App\Repository\TrainingRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ward", name="app_ward_")
 */
class WardController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     */
    public function list(UserRepository $userRepository)
    {
        $trainer = $this->getUser();

        return $this->render('ward/list.html.twig', [
            'wards' => $userRepository->findBy(['trainer' => $trainer])
        ]);
    }

    /**
     * @Route("/training/{training}", name="exercise_list")
     */
    public function exerciseList(Training $training, ExerciseRepository $exerciseRepository)
    {
        $exercises = $exerciseRepository->findExercisesByTraining($training);

        return $this->render('training/exercise_list.html.twig', [
            'exercises' => $exercises
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {
        $ward = new User();

        $form = $this->createForm(WardType::class, $ward);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ward = $form->getData();
            $ward->addRole(User::ROLE_WARD);
            $ward->setTrainer($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ward);
            $entityManager->flush();

            return $this->redirectToRoute('app_training_create', ['ward' => $ward->getId()]);
        }

        return $this->render('ward/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
