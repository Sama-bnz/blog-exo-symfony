<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //Le builder est ce qui va me permettre de construire le formulaire
        $builder
            //genère l'input pour le title
            ->add('title')
            ->add('author')
            ->add('content')
            ->add('isPublished')
            //J'ajoute le champ category pour gerer la selection d'une
            //catégorie pour l'article
            //je lui met le type " car c'est une relation vers une entité
            //Je met en parametre mon input qui affiche les categories
            ->add('category',EntityType::class,[
                'class' => Category::class,
                'choice_label' =>'title'
            ])
            ->add('submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
