<?php

namespace App\Controller;

use App\Entity\Pack;
use App\Form\ChangePasswordFormType;
use App\Form\ProfileFormType;
use App\Form\RegistrationType;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DefaultController extends AbstractController
{
    /**
     * @Route("/default", name="default")
     */
    public function index()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/create_compte_pack", name="create_compte_pack")
     */
    public function registerAction(Request $request)
    {
        $pack = new Pack();
        $form = $this->createForm(RegistrationType::class, $pack);//create form
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $pack->setEnabled(true);

                $role = $pack->getRoles();
                array_push($role, "ROLE_PACK"); // push role

                $pack->setRoles($role);
                $em->persist($pack);//add pack to db
                $em->flush();
                $this->addFlash("success", "Pack MAN created successfully  Use Your Login and Your Password To Log In to be sure you're not a robot
 ");

                return $this->redirectToRoute('fos_user_security_login');

            } else return $this->render('views/Registration/register.html.twig', array('form' => $form->createView()));

        } else return $this->render('views/Registration/register.html.twig', array('form' => $form->createView()));
    }
// action d'affichage des information

    /**
     * @Route("/show", name="show")
     */
    public function showAction(Request $request)
    {


        $em1 = $this->getDoctrine()->getManager();
        $id = $this->getUser()->getId();

        $modeles = $em1->getRepository(Pack::class)->find($id);
        $datetime1 = new \DateTime(); // date actuelle
        $age = $datetime1->diff($modeles->getDate(), true)->y;
        return $this->render('default/profil_pack.html.twig', array('modeles' => $modeles, 'age' => $age));

    }

    /**
     * @Route("/updateuser", name="updateuser")
     */
    public function updateuserAction(Request $request)

    {


// chargement de fomr creer selon le service puis valider l update


        $em1 = $this->getDoctrine()->getManager();

        $modeles = $em1->getRepository(Pack::class)->find($this->getUser()->getId());
        $form = $this->createForm(ProfileFormType::class, $modeles);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($modeles);
                $em->flush();

                $this->addFlash("success", "Pack MAN Updated successfully !!
");


                return $this->redirectToRoute('show');


            } else return $this->render('views/Registration/updateuser.html.twig', array('form' => $form->createView()));
        } else return $this->render('views/Registration/updateuser.html.twig', array('form' => $form->createView()));
    }

// affichage des liste des pack non amis pour ajouter

    /**
     * @Route("/showPack", name="showPack")
     */
    public function show_pack_man_Action(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $us = $em->getRepository(Pack::class)->find($this->getUser()->getId());
        $listeamis = $us->getAmis();
// liste de touts les pack sauf moi
        $us = $this->getUser();
        $id = $us->getId();
        $liste_principale = [];
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT u FROM App:Pack u WHERE u.id <>:rol  ")
            ->setParameter('rol', $id);;
        $liste_principale = $query->getResult();

// effacer les amis deja ajouter de la liste principale des amis pour que le pack man puisse ajouter

        foreach ($liste_principale as $pack_non_moi) {
            foreach ($listeamis as $pack_amis) {
                if ($pack_non_moi->getId() == $pack_amis->getId()) {
                    unset($liste_principale[array_search($pack_amis, $liste_principale)]);

                }
            }

        }

// render liste des pack a jouter
//

        return $this->render('default/liste_pack.html.twig', array('modeles' => $liste_principale));

    }

// action pour ajouter un pack man a sa liste d'amis

    /**
     * @Route("/Add_Pack_Liste_Amis/{id}", name="Add_Pack_Liste_Amis")
     */
    public function AddPackAmisAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $modeles = $em->getRepository(Pack::class)->find($id);

        $this->getUser()->addAmis($modeles);


        $em->persist($this->getUser());
        $em->persist($this->getUser());
        $em->flush();
        $this->addFlash("success", "friend added successfully added");

        return $this->redirectToRoute('showPack');


    }
    // action pour afficher ma liste d'amis

    /**
     * @Route("/listamis/", name="listamis")
     */
    public function Pack_FreindsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $us = $em->getRepository(Pack::class)->find($this->getUser()->getId());
        $listeamis = $us->getAmis();
        return $this->render('default/liste_pack_amis.html.twig', array('modeles' => $listeamis));


    }

// effacer user de ma liste d'amis

    /**
     * @Route("/delete_amis/{id}", name="delete_amis")
     */
    public function deleteAmisAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $modeles = $em->getRepository(Pack::class)->find($id);

        $this->getUser()->removeAmis($modeles);


        $em->persist($this->getUser());
        $em->flush();
        $this->addFlash("success", "friend Removed successfully ");

        return $this->redirectToRoute('listamis');


    }

}
