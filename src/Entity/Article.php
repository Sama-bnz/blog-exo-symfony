<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Je crée une entité qui va servir à créer une table grâce aux annotations
 * @ORM\Entity()
 */
//Je crée une classe et j'en definis le nom
class Article
{
//    Je fournie à ma classe la valeur des colonnes
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     */
//    Je donne le titre à ma colonne
    public $id;

    /**
     * @ORM\Column(type="string")
     */
    public $title;

    /**
     * @ORM\Column(type="string")
     */
    public $image;

    /**
     * @ORM\Column(type="boolean")
     */
    public $isPublished;

    /**
     * @ORM\Column(type="string")
     */
    public $author;


//    Pour créer le fichier de migration:
//    "php bin/console make:migration"
//
//    Pour executer la migration:
//    "php bin/console doctrine:migration:migrate"
}