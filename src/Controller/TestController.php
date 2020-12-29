<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(): Response
    {

        $today = new DateTime('now');
        $birthday = $today->sub(new \DateInterval('P30Y'))->format('Y-m-d');
        $user = new User(
            'DAHMANE',
            'Wassim',
            'wassimdah@gmail.com',
            'vivelestestsunitaires',
            "$birthday"
        );

        $td = new DateTime();
        $dateChoiceToday = new DateTime('2020-12-25 19:36:00');

        $diffDate = $td->diff($dateChoiceToday);
        $difference = $diffDate->format('%H:%I');

        return $this->render('test/index.html.twig');
    }
}
