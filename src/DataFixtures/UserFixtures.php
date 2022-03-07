<?php

namespace App\DataFixtures;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\User;
use App\Entity\Owner;


class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
    $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
    $this->LoadUsers($manager);
    }

    private function loadUsers(ObjectManager $manager)
    {
    foreach ($this->getUserData() as [$email,$firstName,$familyName,$plainPassword,$role]) {
        $user = new User();
        $encodedPassword = $this->passwordEncoder->encodePassword($user, $plainPassword);
        $user->setEmail($email);
        $user->setFirstName($firstName);
        $user->setFamilyName($familyName);
        $user->setPassword($encodedPassword);
        $roles = array();
        $roles[] = $role;
        $user->setRoles($roles);
        $manager->persist($user);

        $owner = new Owner();
        $owner->setUser($user);
        $owner->setFirstName($firstName);
        $owner->setFamilyName($familyName);
        $manager->persist($owner);
    }
    $manager->flush();
    }

    private function getUserData()
    {
    yield ['chris@localhost','Chris','LOCALHOST','chris','ROLE_USER'];
    // yield ['mathis@gontier','Mathis','GONTIER DELAUNAY','mathis','ROLE_USER'];
    // yield ['leo@sajas','Leo','SAJAS','leo','ROLE_USER'];
    // yield ['eloi@besnard','Eloi','BESNARD','eloi','ROLE_USER'];
    yield ['anna@localhost','Anna','LOCALHOST','anna','ROLE_ADMIN'];
    }
}