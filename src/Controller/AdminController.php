<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Article;
use App\Entity\Competence;
use App\Form\CompetenceType;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use App\Repository\CompetenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function admin(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
    * @Route("/admin/articles", name="admin_articles")
    * @Route("/admin/article/{id}/remove", name="admin_article_remove")
    */
    public function adminArticles(EntityManagerInterface $manager, ArticleRepository $repo, Article $article = null)
    {
        $em = $this->getDoctrine()->getManager();
        $colonnes = $em->getClassMetadata(Article::class)->getFieldNames();
        $articles = $repo->findAll();

        // SUPRESSION ARTICLE EN BDD
        if($article)
        {
            $id = $article->getId();

            $manager->remove($article);
            $manager->flush();

            $this->addFlash('success', "L'article n° $id a été supprimé avec succés !");

            return $this->redirectToRoute('admin_articles');
        }

        return $this->render('admin/admin_articles.html.twig', [
        'articles' => $articles,
        'colonnes' => $colonnes
        ]);
    }

    /**
    * @Route("/admin/membres", name="admin_membres")
    * @Route("/admin/membre/{id}/remove", name="admin_membre_remove")
    */
    public function adminMembre(EntityManagerInterface $manager, UserRepository $repo, User $membre = null)
    {
        $colonnes = $manager->getClassMetadata(User::class)->getFieldNames();
        $membres = $repo->findAll();

        if($membre)
        {

            $manager->remove($membre);
            $manager->flush();

            $this->addFlash('success', "Ce Membre a été supprimé avec succés !");

            return $this->redirectToRoute('admin_membres');
        }

        return $this->render('admin/admin_membre.html.twig', [
            'membre' => $membres,
            'colonnes' => $colonnes
        ]);

    }

    /**
     * @Route("/admin/competences", name="admin_competences")
     */
    public function adminCompetence(EntityManagerInterface $manager, CompetenceRepository $repoCompetence): Response
    {
        $colonnes = $manager->getClassMetadata(Competence::class)->getFieldNames();
        dump($colonnes);

        $competences = $repoCompetence->findAll();
        dump($competences);

        return $this->render('admin/admin_competence.html.twig', [
            'colonnes' => $colonnes,
            'competences' => $competences
        ]);
    }

    /**
     * @Route("/admin/competences/new", name="admin_new_competence")
     * @Route("/admin/competence/{id}/edit", name="admin_edit_competence")
     */
    public function createCompetence(Request $request, EntityManagerInterface $manager, Competence $competence = null)
    {

        if(!$competence)
        {
            $competence = new Competence;
        }

        $formCompetence = $this->createForm(CompetenceType::class, $competence);

        $formCompetence->handleRequest($request);

        dump($competence);

        if($formCompetence->isSubmitted() && $formCompetence->isValid())
        {
            if(!$competence->getId())
            {
                $word = 'enregistrée';
            }
            else{
                $word = 'modifiée';
            }

            $manager->persist($competence);
            $manager->flush();

            $this->addFlash('success', "La compétence à bien été $word avec succés !");
            return $this->redirectToRoute('admin_competences');
        }

        return $this->render('admin/admin_create_competence.html.twig', [
            'formCompetence' => $formCompetence->createView(),
            'editMode'     => $competence->getId()
        ]);
    }

    /**
     * @Route("/admin/competence/{id}/remove", name="admin_remove_competence")
     */
    public function adminRemoveCategory(Competence $competence, EntityManagerInterface $manager)
    {
        dump($competence);
        
            $manager->remove($competence);
            $manager->flush();

            $this->addFlash('success', "La competence a été supprimée avec succés !");

        return $this->redirectToRoute('admin_competences');
    }


}
