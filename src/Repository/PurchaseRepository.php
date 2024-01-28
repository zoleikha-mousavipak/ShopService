<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\Purchase;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Purchase>
 *
 * @method Purchase|null find($id, $lockMode = null, $lockVersion = null)
 * @method Purchase|null findOneBy(array $criteria, array $orderBy = null)
 * @method Purchase[]    findAll()
 * @method Purchase[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PurchaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Purchase::class);
    }

    public function save(Purchase $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Purchase $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function create(Product $product, User $user): void
    {
        $purchase = new Purchase();
        $purchase->setUser($user);
        $purchase->setProduct($product);
        
        $this->getEntityManager()->persist($purchase);
        $this->getEntityManager()->flush();
    }

}
