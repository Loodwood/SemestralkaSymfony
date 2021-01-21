<?php


namespace App\Controller;

use App\Entity\TrainingProgram;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class TreningController extends AbstractController
{


    /**
     * @Route("/treningy", name="treningy")
     */
    public function ukazTreningy(Request $request): Response
    {
        $repository = $this->getDoctrine()
            ->getRepository(TrainingProgram::class);
        $treningy = $repository->findAll();
        return $this->render('somfit/treningy.html', ['treningy' => $treningy]);
    }

    /**
     * @Route("/treningy/daj/{id}", name="ukaz_trening")
     */
    public function ukazTrening(int $id): Response
    {
        $trening = $this->getDoctrine()
            ->getRepository(TrainingProgram::class)
            ->find($id);
        if (!$trening) {
            throw $this->createNotFoundException(
                'No trening found for id ' . $id
            );
        }
        return $this->render('Somfit/trening.html', ['trening' => $trening]);

    }

    /**
     * @Route("/treningy/pridaj", name="pridaj_trening")
     */
    public function pridajTrening(Request $request, UserInterface $user): Response
    {
        $id = $request->get("treningId");
        $trening = $this->getDoctrine()
            ->getRepository(TrainingProgram::class)
            ->find($id);
        if (!$trening) {
            throw $this->createNotFoundException(
                'No trening found for id ' . $id
            );
        }
        $userTrening = $user->getTrainingProgram();

        if ($userTrening) {
            return $this->json([
                "message" => "Už si zapísaný v treningovom pláne. Ak si ho chceš zmeniť priď osobne alebo zavolaj na : 09845481."
            ]);
        }
        $user->setTrainingProgram($trening);
        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();
        return $this->json([
            "message" => "Zapísal si sa na tréning."
        ]);
    }


}
