<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Address;
use App\Entity\Article;
use App\Entity\Profile;
use App\Entity\Category;
use EsperoSoft\Faker\Faker;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class BlogFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = new Faker();
        //$users=[];
        /* for ($i=0; $i <10; $i++) { 
           /*  $user = (new User())->setFullName($faker->full_name())
                                ->setEmail($faker->email())
                                ->setPassword(sha1("jzijoijzoijijoi"))
                                ->setCreatedAt($faker->dateTimeImmutable()); */
            /* $profile = (new Profile())->setPicture($faker->image())
                                    ->setCoverPicture($faker->image())
                                    ->setDateBirth($faker->dateTimeImmutable())
                                    ->setDescription($faker->description(60))
                                    ->setCreatedAt($faker->dateTimeImmutable());
             */
            /* $address = (new Address())->setStreet($faker->streetAddress())
                                    ->setCodePostal($faker->codepostal())
                                    ->setCity($faker->city())
                                    ->setCreatedAt($faker->dateTimeImmutable())
                                    ->setCountry($faker->country()); */
            /* $user->addAddress($address); */
            //$user->setProfile($profile);
           /*  $profile->setUser($user);
            $users[] = $user;
            $manager->persist($user);
            $manager->persist($address);
            $manager->persist($profile);
        } */

        $names = [
            'Actualités',
            'Politique',
            'Économie',
            'Culture',
            'Sports et loisirs',
            'Histoire',
            'Diplomatie',
            'Autre',
        ];
        foreach ($names as $name) {
            $category = (new Category())->setName($name)
            ->setDescription("Description de la catégorie ".$name)
            ->setImageUrl($faker->image())
            ->setCreatedAt($faker->dateTimeImmutable());
            $manager->persist($category);
        }
            
    
        /* for ($i=0; $i <50; $i++) { 
            $article = (new Article())->setTitle($faker->title())
                                    ->setContent($faker->text(5,10))
                                    ->setAuthor($users[rand(0, count($users)-1)])
                                    ->setImageUrl($faker->image())
                                    ->setCreatedAt($faker->dateTimeImmutable())
                                    ->addCategory($categories[rand(0, count($categories)-1)]);
            $manager->persist($article);
        }*/
        $manager->flush();
    }
}
