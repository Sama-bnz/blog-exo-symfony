<?php


namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class ArticleController extends AbstractController
{


    /**
     * @Route("article", name="article")
     */
        public function showArticle(ArticleRepository $articleRepository)
        {
            //recuperer depuis la bdd un article
            //en fonction d'un ID
            //donc SELECT * FROM article where id = xxx

            $article = $articleRepository -> find(1);

            return $this->render('show_article.html.twig',[
                'article' => $article
            ]);

        }
    /**
     * @Route("/articles", name="articles")
     */
        public function listArticles(ArticleRepository $articleRepository)
        {
            $articles = $articleRepository -> findAll();

            return $this ->render('list_articles.html.twig',[
                'articles' => $articles
            ]);
        }







    /**
     * @Route("insert-article", name="insert_article")
     */
    //L'entity manager traduit en requete SQL
    public function insertArticle(EntityManagerInterface $entityManager)
    {
        //creer un nouvel enregistrement dans la table article
        //avec des donnés title, content etc


        //je créé une instance de la classs article (classe d'entité (celle qui as permis de crée la table))
//        dans le but de créer un nouvel article de la BDD (table article)

        $article = new Article();

//        j'utilise les setters du titre, du contenu etc
//        pour lettre les données voulues pour le titre , le contenu etc
        $article ->setTitle('Chat mignon');
        $article ->setContent("Oh qu'il es cute ce con de chat");
        $article->setAuthor('Mbala');
        $article->setIsPublished(true);

        //J'utilise la classe EntityManagerInterface de Doctrine pour enregistre mon entité
//        dans la bdd dans la table article (en deux étapes avec le persist puis le flush)

        $entityManager->persist($article);

        //Je pousse vers la BDD la totalité avec la fonction flush
        $entityManager->flush();




    }
}