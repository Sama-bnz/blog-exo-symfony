<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function add(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    //Je créer ma fonction search dans mon Article repository
    public function searchByWord($search)
    {
        //Le createQueryBuilder est un objet qui permet de créer des requetes SQL en PHP
        $qb = $this->createQueryBuilder('article');

        //Je fais un select sur ma table article
        $query = $qb->select('article')

        //je récupere les articles dont le titre corresponds à :search
            ->where('article.title LIKE :search')

        //Je dois definir la valeur de :search en lui mettant des "%" avant et apres, cela veux dire que meme si des mots
        // sont avant ou apres la recherche sera reussie
        //Je le fais en 2 étapes qui sont le setParameter et le GetQuery
        ->setParameter('search','%'.$search.'%')
        //Je récupere la requete
        ->getQuery();

        //Enfin j'execute la requete en base de donnée et je récupere les résultats
        return $query->getResult();
    }
//    /**
//     * @return Article[] Returns an array of Article objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Article
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
