<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function newUser(User $user): bool
    {
        $this->_em->persist($user);
        $this->_em->flush();

        return true;
    }

    public function readAllUsers()
    {
        $entityManager = $this->getEntityManager();
        
        $query = $entityManager->createQuery(
            "SELECT 
                u.email AS email, 
                u.name AS name,
                u.role AS role
            FROM App\Entity\User u
            ORDER BY u.email"
        );

        return $query->getResult();
    }
}