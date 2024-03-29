<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/api/user', name: 'app_user', methods:"GET")]
    public function index(): JsonResponse
    {        
        return $this->json([
            'name' => $this->getUser()->getName(),
            'email' => $this->getUser()->getEmail(),
          ], 200);
    }

}
