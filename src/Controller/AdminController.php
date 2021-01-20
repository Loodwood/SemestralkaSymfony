<?php



namespace App\Controller;


use App\Entity\Product;
use App\Entity\User;
use App\Entity\TrainingProgram;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{




    /**
     * @Route("/admin", name="admin")
     */
    public function ukazAdmin(Request $request): Response
    {

        return $this->render('admin/admin.html.twig', [

        ]);
    }

    /**
     * @Route("/admin/produkty", name="ukaz_produkty")
     */
    public function ukazProdukty(Request $request): Response
    {
        $repository = $this->getDoctrine()
            ->getRepository(Product::class);
        $produkty = $repository->findAll();
        $html = $this->renderView('admin/ukazProdukty.html.twig', ['produkty' => $produkty]);
        return $this->json([
            "message"=>"$html"
        ]);
    }

    /**
     * @Route("/admin/produkty/edit/{id}", name="edituj_produkt")
     */
    public function editujProdukt(Request $request,$id): Response
    {
       $produkt = $this->getDoctrine()
        ->getRepository(Product::class)->find($id);
       $udaje=$request->get("inputs");
        if (!empty($udaje["nameproduct"]) ){
            $produkt->setName($udaje["nameproduct"]);

        }
        if (!empty($udaje["description"]) ){
            $produkt->setDescription($udaje["description"]);

        }
        if (!empty($udaje["price"]) ){
            $produkt->setPrice($udaje["price"]);

        }
        if (!empty($udaje["quantity"]) ){
            $produkt->setQuantity($udaje["quantity"]);

        }
        $this->getDoctrine()->getManager()->persist($produkt);
        $this->getDoctrine()->getManager()->flush();
        return $this->json([
            "message"=>"Editoval si produkt."
        ]);
    }

    /**
     * @Route("/admin/pouzivatelia", name="ukaz_pouzivatelia")
     */
    public function ukazpouzivatelov(Request $request): Response
    {
        $repository = $this->getDoctrine()
            ->getRepository(User::class);
        $pouzivatelia = $repository->findAll();

        $html = $this->renderView('admin/ukazPouzivatelov.html.twig', ['pouzivatelia' => $pouzivatelia]);

        return $this->json([
            "message"=>"$html",

        ]);

    }
    /**
     * @Route("/admin/pouzivatelia/edit/{id}", name="editujPouzivatela")
     */
    public function editujPouzivatela(Request $request,$id,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)->find($id);

    $udaje = $request->get("inputs");

       if (!empty($udaje["userName"]) ){
           $user->setUserName($udaje["userName"]);

       }
        if (!empty($udaje["password"]) ){
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $udaje["password"]
                )
            );


        }
        if (!empty($udaje["name"]) ){
            $user->setName($udaje["name"]);

        }
        if (!empty($udaje["surname"]) ){
            $user->setSurname($udaje["surname"]);

        }
    $this->getDoctrine()->getManager()->persist($user);
    $this->getDoctrine()->getManager()->flush();
        return $this->json([
            "message"=>"Uložený používateľ.",

        ]);

    }

    /**
     * @Route("/admin/pouzivatelia/remove/{id}", name="vymazPouzivatela")
     */
    public function vymazPouzivatela(Request $request,$id): Response
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)->find($id);




        $this->getDoctrine()->getManager()->remove($user);
        $this->getDoctrine()->getManager()->flush();
        return $this->json([
            "message"=>"Vymazaný užívateľ.",

        ]);

    }

    /**
     * @Route("/admin/treningy", name="ukaz_treningy")
     */
    public function ukazTrening(Request $request): Response
    {
        $repository = $this->getDoctrine()
            ->getRepository(TrainingProgram::class);
        $treningy = $repository->findAll();

        $html = $this->renderView('admin/ukazTreningy.html.twig', ['treningy' => $treningy]);

        return $this->json([
            "message"=>"$html",

        ]);

    }

    /**
     * @Route("/admin/treningy/edit/{id}", name="edituj_trening")
     */
    public function editujTrening(Request $request,$id): Response
    {
        $trening = $this->getDoctrine()
            ->getRepository(TrainingProgram::class)->find($id);
        $udaje = $request->get("inputs");
        if (!empty($udaje["nametrening"]) ){
            $trening->setName($udaje["nametrening"]);

        }
        if (!empty($udaje["pricetrening"]) ){
            $trening->setPrice($udaje["pricetrening"]);

        }
        if (!empty($udaje["descriptiontrening"]) ){
            $trening->setDescription($udaje["descriptiontrening"]);

        }
        $this->getDoctrine()->getManager()->persist($trening);
        $this->getDoctrine()->getManager()->flush();
        return $this->json([
            "message"=>"editoval si trening",

        ]);

    }
}

