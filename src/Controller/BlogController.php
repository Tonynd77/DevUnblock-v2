<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function accueil(): Response
    {
        return $this->render('accueil.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function blog(ArticleRepository $repoArticle): Response
    {
        $articles = new Article;
        $articles = $repoArticle->findAll();
        dump($articles);
        
        return $this->render('blog/blog.html.twig', [
            'articles'  => $articles,
        ]);
    }

    /**
     * @Route("/blog/new" , name="blog_create")
     * @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function create(Request $request, EntityManagerInterface $manager, Article $article = null): Response
    {
        
        if(!$article)
        {
            $article = new Article();
        }
                
        $form = $this->createForm(ArticleType::class, $article);
        
        $form->handleRequest($request);
        dump($article);

                if($form->isSubmitted() && $form->isValid())
                {
                    if(!$article->getId())
                    {
                        $article->setArticleDate(new \DateTime());
                    }

                    

                    $manager->persist($article);
                    $manager->flush();

                    return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
                }
        
        return $this->render('blog/create.html.twig', [
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !== null
        ]);

    }

    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show(Article $article): Response
    {   
        return $this->render('blog/blog_show.html.twig', [
            'article' => $article,
        ]);
    }

}
