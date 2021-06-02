<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager,  UserPasswordEncoderInterface $encoder, SluggerInterface $slugger): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $image = $form->get('abonne_image')->getData();
            dump($image);

            if($image)
            {
                
                $nomOrigineFichier = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // dump($nomOrigineFichier);

                $secureNomFichier = $slugger->slug($nomOrigineFichier);
                // dump($secureNomFichier);

                $nouveauNomFichier = $secureNomFichier . '-' . uniqid() . '.' . $image->guessExtension();
                dump($nouveauNomFichier);

                try
                {
                    $image->move(
                        $this->getParameter('images_directory'),
                        $nouveauNomFichier
                    );
                }
                catch(FileException $e)
                {

                }

                $user->setAbonneImage($nouveauNomFichier);
            }

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre compte a bien été créé ! Vous pouvez maintenant vous connecter'
            );

            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig', [
            'form'        => $form->createView(),
            'imageProfil' => $user->getAbonneImage()
        ]);
    }

    /**
    * @Route("/connexion", name="security_login")
    */
    public function login(AuthenticationUtils $authenticationUtils, UserRepository $repo): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastEmail = $authenticationUtils->getLastUsername();
        $util = $repo->findAll();
        // return $this->redirectToRoute('blog');

        return $this->render('security/login.html.twig', [
            'error' => $error,
            'lastEmail' => $lastEmail
        ]);
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout()
    {
    
    }

}
