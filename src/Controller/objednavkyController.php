<?php



namespace App\Controller;


use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class objednavkyController extends AbstractController
{




    /**
     * @Route("/objednavky", name="objednavky")
     */
    public function index(Request $request,UserInterface $user): Response
    {

        $objednavky = $this->getDoctrine()
            ->getRepository(Order::class)->findBy(['user'=>$user->getId()]);
        $producty = $this->getDoctrine()
            ->getRepository(Product::class)->findAll();
        $orderItem = $this->getDoctrine()
            ->getRepository(OrderItem::class)->findAll();


        return $this->render('somfit/objednavky.html.twig', [
            'producty' => $producty,
            'objednavky' => $objednavky,
            'orderItem' => $orderItem
        ]);
    }




}
