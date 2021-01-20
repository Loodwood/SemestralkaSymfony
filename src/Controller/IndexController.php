<?php



namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{




    /**
     * @Route("/index", name="index")
     */
    public function index(Request $request): Response
    {

        return $this->render('somfit/index.html', [

        ]);
    }

    /**
     * @Route("/ponuka", name="ponuka")
     */
    public function ponuka(Request $request): Response
    {

        return $this->render('somfit/ponuka.html', [

        ]);
    }

    /**
     * @Route("/informacie", name="informacie")
     */
    public function informacie(Request $request): Response
    {

        return $this->render('somfit/informacie.html', [

        ]);
    }


}
