<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;

/**
 * BrandRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BrandRepository extends EntityRepository
{
    public function findBestCustomer($brand)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT o, c, SUM(o.value) AS totalValue
            FROM AppBundle:VOrder o
            JOIN o.brand b JOIN o.customer c
            WHERE o.brand = :brand
            GROUP BY c.id ORDER BY totalValue DESC'
        )
        ->setMaxResults(1)
        ->setParameter('brand', $brand);

        try {
            return $query->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }
}
