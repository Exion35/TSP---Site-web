<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Room;
use App\Entity\Region;
use App\Entity\Owner;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AppFixtures extends Fixture
{
    // définit un nom de référence pour une instance de Region
    public const IDF_REGION_REFERENCE = 'idf-region';
    
    public function load(ObjectManager $manager)
    {



    $region = new Region();
    $region->setCountry("FR");
    $region->setName("Ile de France");
    $region->setPresentation("La région française capitale");
    $manager->persist($region);

    $region2 = new Region();
    $region2->setCountry("FR");
    $region2->setName("Bretagne");
    $region2->setPresentation("La plus belle région de France");
    $manager->persist($region2);

    $region3 = new Region();
    $region3->setCountry("FR");
    $region3->setName("Auvergne-Rhône-Alpes");
    $region3->setPresentation("Magnifique région aux paysages tout ausi magnifiques");
    $manager->persist($region3);
    
    $manager->flush();

    // // Une fois l'instance de Region sauvée en base de données,
    // // elle dispose d'un identifiant généré par Doctrine, et peut
    // // donc être sauvegardée comme future référence.
    // $this->addReference(self::IDF_REGION_REFERENCE, $region);

    $owner = new Owner();
    $owner->setFirstName('Mathis');
    $owner->setFamilyName('GONTIER DELAUNAY');
    $owner->setAddress('Mortain');
    $owner->setCountry('France');
    $manager->persist($owner);

    $owner2 = new Owner();
    $owner2->setFirstName('Eloi');
    $owner2->setFamilyName('BESNARD');
    $owner2->setAddress('Lorient');
    $owner2->setCountry('France');
    $manager->persist($owner2);

    $owner3 = new Owner();
    $owner3->setFirstName('Léo');
    $owner3->setFamilyName('SAJAS');
    $owner3->setAddress('Valence');
    $owner3->setCountry('France');
    $manager->persist($owner3);

    $manager->flush();

    // $file = new UploadedFile('public/images/rooms/chbreleo.jpg','image');
    // $manager->persist($file);
    // $manager->flush();

    $room = new Room();
    $room->setOwner($owner);
    $room->setSummary("Belle chambre d'étudiant");
    $room->setDescription("Chambre d'étudiant à deux pas d'un parc floral et des centres commerciaux");
    $room->setAddress("Square Jean Allemane");
    $room->addRegion($region);
    $room->setCapacity(1);
    $room->setSuperficy(15);
    $room->setPrice(15);
    $room->setRating(4);
    $room->setOnSale(true);
    $room->setIsFree(true);
    // $room->setImageFile($file);
    $manager->persist($room);

    $room2 = new Room();
    $room2->setOwner($owner2);
    $room2->setSummary("Très bel appartement");
    $room2->setDescription("Un appartement en face de la mer et à 100m des remparts : parfaitement situé !");
    $room2->setAddress("Rue de Rennes, Saint-Malo");
    $room2->addRegion($region2);
    $room2->setCapacity(5);
    $room2->setSuperficy(150);
    $room2->setPrice(200);
    $room2->setRating(5);
    $room2->setOnSale(false);
    $room2->setIsFree(false);
    $manager->persist($room2);

    $room3 = new Room();
    $room3->setOwner($owner3);
    $room3->setSummary("Magnifique maison de vacances");
    $room3->setDescription("Maison parfaite pour des vacances en famille, les enfants vont adorer la piscine !");
    $room3->setAddress("Dinard");
    $room3->addRegion($region2);
    $room3->setCapacity(7);
    $room3->setSuperficy(300);
    $room3->setPrice(400);
    $room3->setRating(5);
    $room3->setOnSale(true);
    $room3->setIsFree(true);
    $manager->persist($room3);


    $manager->flush();

    
    }
}
