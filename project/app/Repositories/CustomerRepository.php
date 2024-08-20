<?php

namespace App\Repositories;

use App\Entities\Customer;
use Doctrine\ORM\EntityRepository;

class CustomerRepository extends EntityRepository
{
    public function __construct(Customer $customer)
    {
        $this->entity = $customer;
    }

    /**
     * @param array $attributes
     * @return void
     */
    public function create(array $attributes)
    {
        try {
            foreach ($attributes as $key => $value) {
                if (in_array($key, $this->entity->fillable)) {
                    $this->entity->{$key} = $value;

                }
            }

            $x = $this->entity->persist($this->entity);
            $this->entity->flush();
            dd(1);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    /**
     * @param string $email
     * @return object|null
     */
    public function findByEmail(string $email)
    {
        return $this->findOneBy(['email' => $email]);
    }

    /**
     * @param int $id
     * @return object|null
     */
    public function findById(int $id)
    {
        return $this->findOneBy(['id' => $id]);
    }
}
