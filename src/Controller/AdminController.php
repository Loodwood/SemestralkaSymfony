<?php


namespace App\Controller;


use App\Entity\Product;
use App\Entity\User;
use App\Entity\TrainingProgram;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AdminController extends AbstractController
{


    /**
     * @Route("/admin", name="admin")
     */
    public function ukazAdmin(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin/admin.html.twig', [

        ]);
    }

    /**
     * @Route("/admin/produkty", name="ukaz_produkty")
     */
    public function ukazProdukty(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $repository = $this->getDoctrine()
            ->getRepository(Product::class);
        $produkty = $repository->findAll();
        $html = $this->renderView('admin/ukazProdukty.html.twig', ['produkty' => $produkty]);
        return $this->json([
            "message" => "$html"
        ]);
    }

    /**
     * @Route("/admin/produkty/edit/{id}", name="edituj_produkt")
     */
    public function editujProdukt(Request $request, $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $produkt = $this->getDoctrine()
            ->getRepository(Product::class)->find($id);
        $udaje = $request->get("inputs");
        if (empty($udaje["nameproduct"]) || empty($udaje["description"]) || empty($udaje["quantity"])) {
            return $this->json([
                "message" => "Zadal si prázdne imputy.",

            ]);

        }

        if (!is_numeric($udaje["price"])) {
            return $this->json([
                "message" => "Zadal si text do čísel.",

            ]);
        }

        $this->getDoctrine()->getManager()->persist($produkt);
        $this->getDoctrine()->getManager()->flush();
        return $this->json([
            "message" => "Editoval si produkt."
        ]);
    }

    /**
     * @Route("/admin/pouzivatelia", name="ukaz_pouzivatelia")
     */
    public function ukazpouzivatelov(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $repository = $this->getDoctrine()
            ->getRepository(User::class);
        $pouzivatelia = $repository->findAll();

        $html = $this->renderView('admin/ukazPouzivatelov.html.twig', ['pouzivatelia' => $pouzivatelia]);

        return $this->json([
            "message" => "$html",

        ]);

    }

    /**
     * @Route("/admin/pouzivatelia/edit/{id}", name="editujPouzivatela")
     */
    public function editujPouzivatela(Request $request, $id, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $user = $this->getDoctrine()
            ->getRepository(User::class)->find($id);

        $udaje = $request->get("inputs");
        if (empty($udaje["userName"]) || empty($udaje["name"]) || empty($udaje["surname"])) {
            return $this->json([
                "message" => "Zadal si prázdne imputy.",

            ]);

        }


        if (!empty($udaje["password"])) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $udaje["password"]
                )
            );


        }


        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();
        return $this->json([
            "message" => "Uložený používateľ.",

        ]);

    }

    /**
     * @Route("/admin/pouzivatelia/remove/{id}", name="vymazPouzivatela")
     */
    public function vymazPouzivatela(Request $request, $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $user = $this->getDoctrine()
            ->getRepository(User::class)->find($id);


        $this->getDoctrine()->getManager()->remove($user);
        $this->getDoctrine()->getManager()->flush();
        return $this->json([
            "message" => "Vymazaný užívateľ.",

        ]);

    }

    /**
     * @Route("/admin/treningy", name="ukaz_treningy")
     */
    public function ukazTrening(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $repository = $this->getDoctrine()
            ->getRepository(TrainingProgram::class);
        $treningy = $repository->findAll();

        $html = $this->renderView('admin/ukazTreningy.html.twig', ['treningy' => $treningy]);

        return $this->json([
            "message" => "$html",

        ]);

    }

    /**
     * @Route("/admin/treningy/edit/{id}", name="edituj_trening")
     */
    public function editujTrening(Request $request, $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $trening = $this->getDoctrine()
            ->getRepository(TrainingProgram::class)->find($id);
        $udaje = $request->get("inputs");

        if (empty($udaje["nametrening"]) || empty($udaje["pricetrening"]) || empty($udaje["descriptiontrening"])) {
            return $this->json([
                "message" => "Zadal si prázdne imputy.",

            ]);

        }
        if (!is_numeric($udaje["pricetrening"])) {
            return $this->json([
                "message" => "Zadal si text do čísel.",

            ]);

        }

        $trening->setName($udaje["nametrening"]);
        $trening->setPrice($udaje["pricetrening"]);
        $trening->setDescription($udaje["descriptiontrening"]);


        $this->getDoctrine()->getManager()->persist($trening);
        $this->getDoctrine()->getManager()->flush();
        return $this->json([
            "message" => "editoval si trening",

        ]);

    }
}

