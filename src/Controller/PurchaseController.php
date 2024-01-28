<?php

namespace App\Controller;

use App\Service\PurchaseService;
use JsonException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PurchaseController extends AbstractController
{
    private PurchaseService $purchaseService;

    public function __construct(
        PurchaseService $purchaseService,
         )
    {
        $this->purchaseService = $purchaseService;        
    }

    #[Route('/api/user/products', name: 'get_purchase', methods: "GET")]
    public function index(): JsonResponse
    {
        $purchasedProducts = $this->purchaseService->getPurchasedProducts($this->getUser());

        return $this->json($purchasedProducts);
    }

    #[Route('/api/user/products', name: 'create_purchase', methods: "POST")]
    public function create(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);
        $productId = $requestData['product_id'];

        try {
            $this->purchaseService->createPurchase($productId, $this->getUser());
            return $this->json(['message' => 'The purchased product was created successfully!'], 201);
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], 404);
        }
       
    }

    #[Route('/api/user/products/{sku}', name: 'delete_purchase', methods: "DELETE")]
    public function delete(string $sku): JsonResponse
    {
        try {
            $this->purchaseService->deletePurchase($sku);
            return $this->json(['message' => 'Purchase deleted successfully'], 301);

        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], 404);
        }

    }
}
