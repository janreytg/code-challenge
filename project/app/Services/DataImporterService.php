<?php

namespace App\Services;

use App\Entities\Customer;
use Illuminate\Support\Facades\Http;
use LaravelDoctrine\ORM\Facades\EntityManager;

class DataImporterService
{
    /**
     * @var string
     */
    private $parameters;
    /**
     * @var string
     */
    private $apiUrl;
    private $em;
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repository;

    /**
     * Construct.
    */
    public function __construct()
    {
        $this->apiUrl = config('data_importer.api_data_url');
        $this->parameters = http_build_query(config('data_importer.data_filters'));
        $this->repository = EntityManager::getRepository(config('data_importer.entity_name'));
    }

    /**
     * {@inheritdoc}
     */
    public function retrieve(): array
    {
        try {
            $result = Http::get($this->apiUrl, $this->parameters);
            return $result->json()['results'];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @return Customer
     * @throws \Exception
     */
    public function import()
    {
        $customers = $this->retrieve();
        foreach ($customers as $customer) {
            $data = $this->buildData($customer);
            $customer = $this->createOrUpdate($data);
            EntityManager::persist($customer);
            EntityManager::flush();
        }

        return $customer;
    }

    /**
     * @param $customer
     * @return array
     */
    private function buildData($customer): array
    {
        return [
            'email' => $customer['email'],
            'username' => $customer['login']['username'],
            'password' => md5($customer['login']['password']),
            'full_name' => "{$customer['name']['first']} {$customer['name']['last']}",
            'gender' => $customer['gender'],
            'phone' => $customer['phone'],
            'city' => $customer['location']['city'],
            'country' => $customer['location']['country']
        ];
    }

    /**
     * @param array $data
     * @return Customer
     */
    private function createOrUpdate(array $data): Customer
    {
        $email = $data['email'];
        $username = $data['username'];
        if ($customer = $this->repository->findOneBy(compact('email')))
        {
            return $customer->update($data);
        } elseif ($customer = $this->repository->findOneBy(compact('username')))
        {
            return $customer->update($data);
        }

        return (new Customer)->create($data);
    }


}
