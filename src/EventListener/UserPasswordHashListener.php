<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsEntityListener(event: Events::prePersist, entity: User::class)]
final readonly class UserPasswordHashListener
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function prePersist(User $user): void
    {
        $this->hashPassword($user);
    }

    private function hashPassword(User $user): void
    {
        if ($user->getPlainPassword()) {
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $user->getPlainPassword()
            );
            $user->setPassword($hashedPassword);
            $user->setPlainPassword(null); // Clear plain password
        }
    }
}
