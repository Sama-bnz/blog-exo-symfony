<?php

namespace App\Controller;


use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController

{
    /**
     * @Route("/admin/insert_category", name="admin_insert_category")
     */
    //L'entity manager traduit en requete SQL
    public function insertCategory(EntityManagerInterface $entityManager)
    {
        //creer un nouvel enregistrement dans la table article
        //avec des donnés title, content etc


        //je créé une instance de la classs article (classe d'entité (celle qui as permis de crée la table))
//        dans le but de créer un nouvel article de la BDD (table article)

        $category = new Category();

//        j'utilise les setters du titre, du contenu etc
//        pour lettre les données voulues pour le titre , le contenu etc
        $category ->setTitle('Chat mignon');
        $category ->setColor("entre le rouge et le mauve saupoudré de vert-pomme-cassis-framboise");
        $category->setDescription('Oui alors les couleurs c\'est cool quand c\'est pas compliqué');
        $category->setIsPublished(true);

        //J'utilise la classe EntityManagerInterface de Doctrine pour enregistre mon entité
//        dans la bdd dans la table article (en deux étapes avec le persist puis le flush)

        $entityManager->persist($category);

        //Je pousse vers la BDD la totalité avec la fonction flush
        $entityManager->flush();

        return $this->redirectToRoute('admin_categories');

    }





    /**
     * @Route("/admin/categories/{id}", name="admin_show_category")
     */
        public function showCategory($id,CategoryRepository $categoryRepository)
        {
            //recuperer depuis la bdd un article
            //en fonction d'un ID
            //donc SELECT * FROM article where id = xxx
            $category = $categoryRepository -> find($id);
            //Je lie ma route à mon fichier twig
            return $this ->render('admin/show_category.html.twig',[
                'category' => $category
            ]);

        }
    /**
     * @Route("/admin/categories", name="admin_categories")
     */
    public function listCategories(CategoryRepository $categoryRepository)
    {
        //dans ma variable $categories je dois avoir toutes les valeurs de mon tableau
        $categories = $categoryRepository -> findAll();

        //Je lie ma route à mon fichier twig
        return $this->render('admin/list_categories.html.twig',[
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/admin/categories/delete/{id}", name="admin_delete_category")
     */
    public function deleteCategory($id, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager)
    {
        //J'utilise la méthode find pour trouver l'id
        $category = $categoryRepository ->find($id);

        if(!is_null($category)){
            //Je supprimé l'article avec la fonction entityManager
            $entityManager ->remove($category);
            $entityManager ->flush();

            return $this->redirectToRoute('admin_categories');
        }else{
            return new Response('The article is already deleted');
        }
    }


    /*
     * @Route("/admin/categories/update/{id}", name: "admin-categories-update")]
     */
    public function updateCategory($id, ArticleCategoryRepository $articleCategoryRepository, EntityManagerInterface $entityManager){
        $category = $articleCategoryRepository->find($id);

        $category->setTitle("Title");

        $entityManager->persist($category);
        $entityManager->flush();

    }







}