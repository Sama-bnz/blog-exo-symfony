<?php


namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminArticleController extends AbstractController
{


    /**
     * @Route("/admin/article", name="admin_article")
     */
        public function showArticle(ArticleRepository $articleRepository, $id)
        {
            //recuperer depuis la bdd un article
            //en fonction d'un ID
            //donc SELECT * FROM article where id = xxx

            $article = $articleRepository -> find($id);

            return $this->render('admin/show_article.html.twig',[
                'article' => $article
            ]);

        }
    /**
     * @Route("/admin/articles", name="admin_articles")
     */
        public function listArticles(ArticleRepository $articleRepository)
        {
            $articles = $articleRepository -> findAll();

            return $this ->render('admin/list_articles.html.twig',[
                'articles' => $articles
            ]);
        }







    /**
     * @Route("/admin/insert-article", name="admin_insert_article")
     */
    //L'entity manager traduit en requete SQL
    public function insertArticle(EntityManagerInterface $entityManager, Request $request)
    {
        //creer un nouvel enregistrement dans la table article
        //avec des donnés title, content etc
        $title = $request->query->get('title');
        $content = $request->query->get('content');

        if (!empty($title) &&
            !empty($content)
        ){
            //je créé une instance de la classs article (classe d'entité (celle qui as permis de crée la table))
//        dans le but de créer un nouvel article de la BDD (table article)

            $article = new Article();

//        j'utilise les setters du titre, du contenu etc
//        pour lettre les données voulues pour le titre , le contenu etc
        $article ->setTitle($title);
        $article ->setContent($content);
        $article->setAuthor('Mbala');
        $article->setIsPublished(true);

            //J'utilise la classe EntityManagerInterface de Doctrine pour enregistre mon entité
//        dans la bdd dans la table article (en deux étapes avec le persist puis le flush)

            $entityManager->persist($article);

            //Je pousse vers la BDD la totalité avec la fonction flush
            $entityManager->flush();
            $this->addFlash('succes', 'Vous avez créer l\'article');
            return $this->redirectToRoute('admin_articles');

        }
        $this->addFlash('error', 'Veuillez remplir le contenu de l\'article !');
        return $this->render('admin/insert_article.html.twig');


    }


    //Je creéer ma Route
    /**
     * @Route("/admin/articles/delete/{id}", name="admin_delete_article")
     */
    //Je créer ma méthode en récuperant l'id de LURL
    public function deleteArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        //J'utilise la méthode find pour trouver l'id
        $article = $articleRepository->find($id);

        if (!is_null($article)) {
            //Je supprimé l'article avec la fonction entityManager
            $entityManager->remove($article);
            $entityManager->flush();

            $this->addFlash('success', 'Vous avez bien supprimé l\'article !');
        } else {
            $this->addFlash('error', 'Article introuvable ! ');
        }
        return $this->redirectToRoute('admin_articles');

    }

    /**
     * @Route("/admin/articles/update/{id}", name="admin_update_article")
     */
    public function updateArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        //Avec le repository je selectionne un article en fonction de l'ID
        $article = $articleRepository->find($id);

        //Mise à jour du titre de l'article
        $article->setTitle("This title has been updated");

        //On fais la modification de la variable article avec persist
        $entityManager->persist($article);

        //On déploie la modification grace au flush
        $entityManager->flush();


    }

}