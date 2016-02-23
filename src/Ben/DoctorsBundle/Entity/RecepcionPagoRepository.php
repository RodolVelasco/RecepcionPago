<?php

namespace Ben\DoctorsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * PersonRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RecepcionPagoRepository extends EntityRepository
{
    /* advanced search */
    public function search($searchParam) {
        extract($searchParam);        
        $qb = $this->createQueryBuilder('p');

        if(!empty($keyword))
            $qb->andWhere('concat(p.familyname, p.firstname) like :keyword or p.email like :keyword or p.city like :keyword or p.cin like :keyword')
                ->setParameter('keyword', '%'.$keyword.'%');
        if(!empty($ids))
            $qb->andWhere('p.id in (:ids)')->setParameter('ids', $ids);
        if(!empty($cin))
            $qb->andWhere('p.cin = :cin')->setParameter('cin', $cin);
        if(!empty($city))
            $qb->andWhere('p.city = :city')->setParameter('city', $city);
        if(!empty($gender))
            $qb->andWhere('p.gender = :gender')->setParameter('gender', $gender);
        if(!empty($date_from))
            $qb->andWhere('p.birthday > :date_from')->setParameter('date_from', $date_from);
        if(!empty($date_to))
            $qb->andWhere('p.birthday < :date_to')->setParameter('date_to', $date_to);
        if(!empty($sortBy)){
            $sortBy = in_array($sortBy, array('firstname', 'familyname', 'birthday')) ? $sortBy : 'id';
            $sortDir = ($sortDir == 'DESC') ? 'DESC' : 'ASC';
            $qb->orderBy('p.' . $sortBy, $sortDir);
        }
        if(!empty($perPage)) $qb->setFirstResult(($page - 1) * $perPage)->setMaxResults($perPage);

       return new Paginator($qb->getQuery());
    }

    public function counter() {
        $qb = $this->createQueryBuilder('p')->select('COUNT(p)');
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getCities()
    {
        return  $this->fetch("select distinct city as label from person");
    }
    private function fetch($query)
    {
        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute();
        return  $stmt->fetchAll();
    }
}
