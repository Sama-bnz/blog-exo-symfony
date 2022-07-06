<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Je crée un objet de Mapping du nom de ORM
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

}