<?php

namespace App\Service;

use Exception;
use App\Entity\Product;
use App\Entity\Purchase;
use App\Repository\ProductRepository;
use App\Repository\PurchaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Psr\Log\LoggerInterface;


class PurchaseService
{
    public function __construct(
        private ProductRepository $productRepository,
        private EntityManagerInterface $entityManager,
        private PurchaseRepository $purchaseRepository,
        private LoggerInterface $logger
    ) {
        $this->productRepository = $productRepository;
        $this->entityManager = $entityManager;
        $this->purchaseRepository = $purchaseRepository;
        $this->logger = $logger;
    }

    public function getPurchasedProducts(UserInterface $user): array
    {
        $purchasedProducts = $this->purchaseRepository->findBy(['user' => $user]);
        $serializedPurchase = [];

        foreach ($purchasedProducts as $purchasedProduct) {
            $serializedPurchase[] = [
                'sku' => $purchasedProduct->getProduct()->getSku(),
                'name' => $purchasedProduct->getProduct()->getName(),
            ];
        }
        
        $this->logger->info('Retrieved purchased products for user.', ['user' => $user->getName()]);

        return $serializedPurchase;
    }

    public function createPurchase(int $productId, UserInterface $user): void
    {
        $product = $this->productRepository->find($productId);
        if (!$product instanceof Product)
        {
            throw new Exception("Product not found", 1);            
        }
        $this->logger->info('Purchase created successfully.', ['productId' => $productId, 'user' => $user->getName()]);
        $this->purchaseRepository->create($product, $user);
    }

    public function deletePurchase(string $sku): void
    {
        $product = $this->productRepository->findOneBy(['sku' => $sku]);

        if (!$product instanceof Product)
        {
            throw new Exception("Product not found", 1);            
        }

        $purchases = $this->purchaseRepository->findBy(['product' => $product]);

        if (!count($purchases))
        {
            throw new Exception("Purchase not found", 1);            
        }

        foreach ($purchases as $purchase)
        {            
            $this->entityManager->remove($purchase);
            $this->entityManager->flush();            
        }

        $this->logger->info('Purchase(s) deleted successfully.');
        
    }
}
