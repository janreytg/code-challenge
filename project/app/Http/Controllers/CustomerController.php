<?php

namespace App\Http\Controllers;

use App\Entities\Customer;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class CustomerController extends Controller
{
    private $entityManager;
    /**
     * @var EntityRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Customer::class);
    }
    public function index()
    {
        return response()->json(new CustomerCollection($this->repository->findAll()), 200);
    }

    public function show($id)
    {
        if(!$customer = $this->entityManager->find(Customer::class, $id))
        {
            return response()->json(['message' => 'Customer not found.', 'code' => 404], 404);
        }
        return new CustomerResource($customer);
    }
}
