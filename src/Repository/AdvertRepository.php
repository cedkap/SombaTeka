<?php

namespace App\Repository;

use App\Entity\Advert;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Advert|null find($id, $lockMode = null, $lockVersion = null)
 * @method Advert|null findOneBy(array $criteria, array $orderBy = null)
 * @method Advert[]    findAll()
 * @method Advert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdvertRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Advert::class);
    }

    // /**
    //  * @return Advert[] Returns an array of Advert objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Advert
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findListQuestionQB()
    {
        $qb =$this->createQueryBuilder('App\Entity\Advert q');
        $qb->andWhere('q.status = :status');
        $qb->orderBy('q.id', 'DESC');
        $qb->addSelect('s');
        $qb->setParameter('status','1');
        $qb->setFirstResult(0);
        $qb->setMaxResults(200);
        $query = $qb->getQuery();
        $question = $query->getResult();
        return $question;
    }

    /**
     * Par region
     * @param Region $region
     * @return mixed
     */

    public function findListRegion(Region $region)
    {
       // select * from advert, region where advert.region_id =region.id
        $dql= "SELECT q,s
                FROM App\Entity\Advert q
                JOIN q.Region s
                where q.Region= :Region
                 ORDER BY q.id DESC";
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter(":Region",$region);
        $query->setMaxResults(200);
        $question= $query->getResult();
        return $question;
    }

    public function findByRegionn($id)
    {
        // On passe par le QueryBuilder vide de l'EntityManager pour l'exemple
        $result = $this->createQueryBuilder('a')
            ->select('a')
            ->where('IDENTITY(a.Region) = :id')
            ->orWhere('IDENTITY(a.Categorie) = :id')
            ->orWhere('a.Prix > :purchasePrize')
            ->setParameter( ':purchasePrize', 1000)
            ->setParameter('id', $id)
            ->orderBy('a.id', 'DESC');
        return $result->getQuery()
            ->getResult();
    }

    public function findByRegiionAct()
    {
        // select * from advert, region where advert.region_id =region.id
        $dql= "SELECT q
                FROM App\Entity\Advert q
                 ORDER BY q.id DESC";
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setMaxResults(10);
        $question= $query->getResult();
        return $question;
    }

    public function findListCategorie($advert)
    {
        $dql= "SELECT q,s
                FROM App\Entity\Advert q
                JOIN q.Categorie s
                where q.id= :user
                
                 ORDER BY q.id DESC";
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter(":user",$advert);
        $query->setMaxResults(4);
        $question= $query->getResult();
        return $question;
    }

    public function findByCategorie($id)
    {
        // On passe par le QueryBuilder vide de l'EntityManager pour l'exemple
        $result = $this->createQueryBuilder('a')
            ->select('a')
            ->where('IDENTITY(a.Categorie) = :id')
            ->setParameter('id', $id)
            ->orderBy('a.id', 'DESC');
        return $result->getQuery()
            ->getResult();
    }





    //recherche par nom
    public function findByName($data,$searchCat,$searchRegion,$searchPriceMin,$searchPriceMax)
    {
        $result = $this->createQueryBuilder('a')->select('a');
        //dump($searchPriceMin);
       // dump($searchPriceMax);
        if (!empty($data)){
            $result->where('a.Name LIKE :data')
                ->orWhere('a.Prix LIKE :data')
               ->orWhere('c.Name LIKE :data')
                ->orWhere('r.Name LIKE :data')
                ->setParameter('data', "%".$data."%");
        }
        if (!empty($searchCat)){
            $result->andWhere('c.Name LIKE :searchCat')
            ->setParameter('searchCat', $searchCat);
        }
        if (!empty($searchRegion )){
            $result->andWhere('r.Name LIKE :searchRegion')
                ->setParameter('searchRegion', $searchRegion);
        }
        if (!empty($searchPriceMin) || !empty($searchPriceMax)){
            $result->andWhere('a.Prix BETWEEN :searchPriceMin AND :searchPriceMax ')
            ->setParameter('searchPriceMax', $searchPriceMax)
            ->setParameter('searchPriceMin', $searchPriceMin);
        }
        $result->leftJoin('a.Categorie','c');
        $result->leftJoin('a.Region','r');
//echo $result->getQuery()->getSQL();
//echo $result;
        return $result->getQuery()->getResult();
    }

}
