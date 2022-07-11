<?php

namespace App\Controller;


use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleType;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController

{
    /**
     * @Route("/admin/insert_category", name="admin_insert_category")
     */
    //L'entity manager traduit en requete SQL
    public function insertCategory(EntityManagerInterface $entityManager, Request $request)
    {

        //je créé une instance de la classe article (classe d'entité (celle qui as permis de crée la table))
//        dans le but de créer un nouvel article de la BDD (table article)

//    Pour créer cette categorie j'utilise la formule PHP BIN/CONSOLE MAKE:FORM  sur mon commander
        $category = new Category();

//        j'ai utilisé la ligne de cmd php bin/console make:form pour créer une classe symfony qui va contenir le "plan" de formulaire afin de créer les articles. C'est la classe ArticleType

        $form = $this->createForm(CategoryType::class, $category);

        //On donne à la variable qui contient le formulaire une instance de la classe Request pour que le formulaire puisse récuperer tout les données des inputs et faire les setters sur $article automatiquement.
        //Mon formulaire est maintenant capable de recuperer et stocker les infos
        $form->handleRequest($request);

        //Si le formulaire à été posté et que les données sont valide
        if($form->isSubmitted() && $form->isValid()){
            //On enregistre l'article dans la BDD
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', 'La catégorie est bien enregistrée!');
        }

        //j'affiche mon twig en lui passant une variable form qui contient la view du formulaire
        //J'en profites pour créer la view, qui sera visible par la personne sur le site

        return $this->render("admin/insert_category.html.twig", [
            'form' => $form->createView()
        ]);
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

            $this->addFlash('success', 'Vous avez bien supprimé la categorie !');


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