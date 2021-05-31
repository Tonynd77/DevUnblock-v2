<?php

namespace App\DataFixtures;


use Faker\Factory;
use App\Entity\Avis;
use App\Entity\User;
use App\Entity\Article;
use App\Entity\Competence;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        $abonnes = [];

        for ($i = 0; $i < 10; $i++)  {
        //Ajout Users

            $abonne  = new User;
            
            $nom     = $faker->lastName;
            $prenom  = $faker->firstName; 

            $abonne->setRoles(['ROLE_USER']);
            $abonne->setAbonneNom($nom);
            $abonne->setAbonnePrenom($prenom);
            $abonne->setAbonneImage("assets/avatar.png"); // Exemple
            $abonne->setAbonneTel($faker->phoneNumber);
            $abonne->setAbonneRegion($faker->region);
            $abonne->setAbonneDescription($faker->text);
            //$abonne->setEmail($faker->email);
            $abonne->setAbonneEmail($prenom.$nom."@".$faker->freeEmailDomain);
            $abonne->setAbonneUserName($prenom.$nom);
            $abonne->setPassword($this->passwordEncoder->encodePassword(
                $abonne,
                'pass'
            ));           
            $manager->persist($abonne);

            //Ajout Avis
            
            //Les 20 derniers user créés ont donné un avis
            if ($i > 31) {

                $avis = new Avis;
                $avis->setAbonne($abonne);
                $avis->setAvisTitre("Titre Avis n°".$i);
                $avis->setAvisContenu($faker->text);
                $avis->setAvisImage("assets/img/..."); //Exemple
                //$avis->setAvisImage($abonne->getImage());
                $avis->setAvisDate(new \Datetime);
                
                $manager->persist($avis);
            }

            //Ajout Article

            //Les 15 derniers user créés ont écrit un article
            if ($i > 36) {
                $article = new Article;
                $article->setAbonne($abonne);
                $article->setArticleContenu($faker->text);
                $article->setArticleDate(new \Datetime);
                $article->setArticleImage("https://picsum.photos/id/23$i/300/300"); //Exemple
                $article->setArticleTitre("Titre Article n°".$i);
                $article->setArticleValide(false);
                //$avis->setAvisImage($abonne->getImage());

                $manager->persist($article);
            }
            $abonnes[$i] = $abonne;
        }

        //Ajout Compétences

        $competence = new Competence();
        $competence->setCompetenceNom("PHP");
        $competence->addAbonne($abonnes[30]);
        $competence->addAbonne($abonnes[10]);
        $competence->addAbonne($abonnes[16]);
        $manager->persist($competence);

        $competence = new Competence();
        $competence->setCompetenceNom("JavaScript");
        $competence->addAbonne($abonnes[30]);
        $competence->addAbonne($abonnes[10]);
        $competence->addAbonne($abonnes[40]);
        $manager->persist($competence);

        $competence = new Competence();
        $competence->setCompetenceNom("Java");
        $competence->addAbonne($abonnes[5]);
        $competence->addAbonne($abonnes[21]);
        $competence->addAbonne($abonnes[35]);
        $competence->addAbonne($abonnes[30]);
        $competence->addAbonne($abonnes[10]);
        $manager->persist($competence);

        $competence = new Competence();
        $competence->setCompetenceNom("HTML/CSS");
        for ($i = 0; $i < count($abonnes); $i++) {
            $competence->addAbonne($abonnes[$i]);
        }
        $manager->persist($competence);

        $manager->flush();
    }
}
