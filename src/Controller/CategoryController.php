<?php

namespace App\Controller;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController

{
    /**
     * @Route("insert-category", name="insert_category")
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

    }





    /**
     * @Route("/categories/{id}", name="show_category")
     */
        public function showCategory($id,CategoryRepository $categoryRepository)
        {
            //recuperer depuis la bdd un article
            //en fonction d'un ID
            //donc SELECT * FROM article where id = xxx
            $category = $categoryRepository -> find($id);

            return $this ->render('show_category.html.twig',[
                'category' => $category
            ]);

        }
    /**
     * @Route("/categories", name="categories")
     */
    public function listCategories(CategoryRepository $categoryRepository)
    {
        //dans ma variable $categories je dois avoir toutes les valeurs de mon tableau
        $categories = $categoryRepository -> findAll();

        return $this->render('list_categories.html.twig',[
            'categories' => $categories
        ]);
    }












}