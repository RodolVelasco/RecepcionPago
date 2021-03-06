<?php

namespace Ben\DoctorsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * LineaTrabajoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LineaTrabajoRepository extends EntityRepository
{
	/* advanced search */
    public function search($searchParam) {
        extract($searchParam);        
        $qb = $this->createQueryBuilder('p');

     	//exit(\Doctrine\Common\Util\Debug::dump($keyword));

        if(!empty($keyword))
            $qb->andWhere('concat(p.codigo, p.nombre) like :keyword')
                ->setParameter('keyword', '%'.$keyword.'%');
        if(!empty($ids))
            $qb->andWhere('p.id in (:ids)')->setParameter('ids', $ids);
        if(!empty($sortBy)){
            $sortBy = in_array($sortBy, array('codigo', 'nombre')) ? $sortBy : 'id';
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

    private function fetch($query)
    {
        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute();
        return  $stmt->fetchAll();
    }
    
    public function findByUnidadId($unidad_id){
        
        /*
        $qb = $this->createQueryBuilder('p');
     	//exit(\Doctrine\Common\Util\Debug::dump($unidad_id));
        if(!empty($unidad_id))
            $qb->andWhere('p.unidad = :unidadId')
                ->setParameter('unidadId', $unidad_id);
        
       //return $qb->getQuery();
       */
       $query = $this->getEntityManager()->createQuery("
        SELECT lt FROM BenDoctorsBundle:LineaTrabajo lt 
		WHERE lt.unidad = :unidadId
        ")->setParameter('unidadId', $unidad_id);
       
       return $query->getArrayResult();
    }
    public function findByCorrelativoLineaTrabajoId($linea_trabajo_id){
        
       $query = $this->getEntityManager()->createQuery("
        SELECT lt FROM BenDoctorsBundle:LineaTrabajo lt 
		WHERE lt.id = :lineaTrabajoId
        ")->setParameter('lineaTrabajoId', $linea_trabajo_id);
       
       return $query->getArrayResult();
    }
}
