<?php

namespace App\DataFixtures;

use App\Entity\Exercise;
use App\Entity\ExerciseParameter;
use App\Entity\ExerciseParameterType;
use App\Entity\ExerciseType;
use App\Entity\Training;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $exerciseTypeSit = (new ExerciseType())
            ->setName('sitting');
        $manager->persist($exerciseTypeSit);
        $exerciseTypeRunning = (new ExerciseType())
            ->setName('running');
        $manager->persist($exerciseTypeRunning);

        $exerciseParameterTypeRepeats = (new ExerciseParameterType())
            ->setName('repeats');
        $manager->persist($exerciseParameterTypeRepeats);
        $exerciseParameterTypeSpeedKmh = (new ExerciseParameterType())
            ->setName('km/h');
        $manager->persist($exerciseParameterTypeSpeedKmh);

        $exerciseParameterRepeats10 = (new ExerciseParameter())
            ->setValue(10)
            ->setType($exerciseParameterTypeRepeats);
        $manager->persist($exerciseParameterRepeats10);
        $exerciseParameterRepeats30 = (new ExerciseParameter())
            ->setValue(30)
            ->setType($exerciseParameterTypeRepeats);
        $manager->persist($exerciseParameterRepeats30);
        $exerciseParameterSpeed30 = (new ExerciseParameter())
            ->setValue(30)
            ->setType($exerciseParameterTypeSpeedKmh);
        $manager->persist($exerciseParameterSpeed30);
        $exerciseParameterSpeed10 = (new ExerciseParameter())
            ->setValue(10)
            ->setType($exerciseParameterTypeSpeedKmh);
        $manager->persist($exerciseParameterSpeed10);

        for ($i = 0; $i < 20; ++$i) {
            $user = new User();
            $user->setFirstName('user ' . $i);
            $user->setMiddleName('name ' . $i);
            $user->setLastName('git ' . $i);
            $user->setEmail('email' . $i . '@email');
            $user->setphoneNumber(mt_rand(89000000000, 899999999999));
            $user->setPassword($this->encoder->encodePassword($user, 'test'));
            if (empty($trainer)) {
                $trainer = $user->setEmail('trainer@email');
            } else {
                $user->setTrainer($trainer);
                for ($it = 0; $it < 20; ++$it) {
                    $training = (new Training())
                        ->setWard($user)
                        ->setTrainer($trainer)
                        ->setNote('bjhgfdsucbjsc' . $it)
                        ->setRepeatsActual(mt_rand(10, 100))
                        ->setRepeatsExpect(mt_rand(10, 100));
                    $manager->persist($training);
                    // exercises
                    $exerciseRunning = (new Exercise())
                        ->setExerciseType($exerciseTypeRunning)
                        ->setTraining($training)
                        ->addExerciseParameter($exerciseParameterSpeed30);
                    $manager->persist($exerciseRunning);
                    $exerciseSitting = (new Exercise())
                        ->setExerciseType($exerciseTypeSit)
                        ->setTraining($training)
                        ->addExerciseParameter($exerciseParameterRepeats10)
                        ->addExerciseParameter($exerciseParameterSpeed30);
                    $manager->persist($exerciseSitting);
                }
            }
            $manager->persist($user);
        }


        $manager->flush();
    }
}
