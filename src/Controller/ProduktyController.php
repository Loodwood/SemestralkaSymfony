<?php


namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;

class ProduktyController extends AbstractController
{


    /**
     * @Route("/produkty", name="produkty")
     */
    public function index(Request $request): Response
    {
        $repository = $this->getDoctrine()
            ->getRepository(Product::class);
        $produkty = $repository->findAll();
        return $this->render('somfit/produkty.html', ['produkty' => $produkty]);
    }

    /**
     * @Route("/produkty/daj/{id}", name="ukaz_produkt")
     */
    public function ukazprodukt(int $id): Response
    {

        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);
        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }
        return $this->render('Somfit/produkt.html', ['product' => $product]);

    }

    /**
     * @Route("/produkty/objednaj", name="objednaj")
     */
    public function objednajProdukt(Request $request, UserInterface $user): Response
    {
        $productID = $request->get("productId");
        $quantity = $request->get("quantity");
        $product = $this->getDoctrine()->getRepository(Product::class)->find($productID);
        $order = new Order();
        $order->setUser($user);
        $this->getDoctrine()->getManager()->persist($order);
        $this->getDoctrine()->getManager()->flush();

        $orderItem = new OrderItem();
        $orderItem->setQuantity($quantity);
        $orderItem->setProductID($product); //tu ide product
        $orderItem->setOrderID($order);

        $this->getDoctrine()->getManager()->persist($orderItem);
        $this->getDoctrine()->getManager()->flush();

        $order->addOrderItem($orderItem);

        $this->getDoctrine()->getManager()->persist($order);
        $this->getDoctrine()->getManager()->flush();


        return $this->render('Somfit/ponuka.html');

    }


}
