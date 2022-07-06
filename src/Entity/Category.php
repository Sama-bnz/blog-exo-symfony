<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 *  * Je crée une entité qui va servir à créer une table grâce aux annotations

 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
//Je crée une classe et j'en definis le nom

class Category
{
    /**
     * //    Je fournie à ma classe la valeur des colonnes

     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $color;

    /**
     * @ORM\Column(type="text")
     */
//    Le fait d'etre en privée permet de juste regarder
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished;
//    Le public permet de lire ET de definir la valeur
    public function getId(): ?int
    {
        return $this->id;
    }
//    Les getter et setter permettent de gerer si on veux la valeur en public ou en private
    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }
    //    Pour créer le fichier de migration:
//    "php bin/console make:migration"
//
//    Pour executer la migration:
//    "php bin/console doctrine:migration:migrate"
}
