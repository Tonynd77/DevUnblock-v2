<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Form\ModifierProfilType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{

    /**
     * @Route("/profil", name="profil")
     */
    public function profil(): Response
    {
        return $this->render('profil/profil.html.twig');
    }

    /**
     * @Route("/profil/edit_profil", name="profil_edit")
     */
    public function profilEdit(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(ModifierProfilType::class, $user);

        $form->handleRequest($request);
        dump($user);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "Profil mis a jour");
            
            return $this->redirectToRoute('profil');
        }

        return $this->render('profil/profil_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profil/{id}", name="profil_user")
     */
    public function profilUser(User $user): Response
    {   
        dump($user);
        // $user = new User();
        // $repoUser = $this->getDoctrine()->getRepository(User::class);
        // $user = $repoUser->find($id);

        return $this->render('profil/profil_user.html.twig', [
            'user' => $user
        ]);
    }

    
}
