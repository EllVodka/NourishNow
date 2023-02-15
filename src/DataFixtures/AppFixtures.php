<?php

namespace App\DataFixtures;

use App\Entity\Commande;
use App\Entity\DetailCommande;
use App\Entity\Personne;
use App\Entity\Plat;
use App\Entity\User;
use App\Entity\Restaurant;
use App\Entity\Secteur;
use App\Entity\TypeResto;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;


    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;

    }
    
    public function load(ObjectManager $manager): void
    {

        $userRestaurateur = new User();
        $userRestaurateur->setEmail("arnaudpoivre@gmail.com");
        $passwordRestaurateur = $this->hasher->hashPassword($userRestaurateur, 'arnaud');
        $userRestaurateur->setPassword($passwordRestaurateur);
        $userRestaurateur->setRoles(["ROLE_RESTAURATEUR"]);
        $manager->persist($userRestaurateur);


        $userLivreur = new User();
        $userLivreur->setEmail("ericlivreur@gmail.com");
        $passwordLivreur = $this->hasher->hashPassword($userLivreur, 'eric');
        $userLivreur->setPassword($passwordLivreur);
        $userLivreur->setRoles(["ROLE_LIVREUR"]);
        $manager->persist($userLivreur);


        $userClient = new User();
        $userClient->setEmail("jujuleroy@gmail.com");
        $passwordClient = $this->hasher->hashPassword($userClient, 'julian');
        $userClient->setPassword($passwordClient);
        $userClient->setRoles(["ROLE_CLIENT"]);
        $manager->persist($userClient);


        $valMetroPol = new Secteur();
        $valMetroPol->setLibelle("Valenciennes Metropol");
        $manager->persist($valMetroPol);

        
        $valenciennes = new Ville();
        $valenciennes->setFkSecteur($valMetroPol->getId());
        $valenciennes->setLibelle("Valenciennes");
        $manager->persist($valenciennes);


        $personneRestaurateur = new Personne();
        $personneRestaurateur->setNom("Poivre");
        $personneRestaurateur->setPrenom("Arnaud");
        $personneRestaurateur->setEmail($userRestaurateur->getEmail());
        $personneRestaurateur->setTelephone("0647653913");
        $personneRestaurateur->setAdresse("45 rue du bordel");
        $personneRestaurateur->setVehicule(null);
        $personneRestaurateur->setFkUser($userRestaurateur->getId());
        $personneRestaurateur->setFkVille($valenciennes->getId());
        $manager->persist($personneRestaurateur);

        $personneLivreur = new Personne();
        $personneLivreur->setNom("Livreur");
        $personneLivreur->setPrenom("Eric");
        $personneLivreur->setEmail($userLivreur->getEmail());
        $personneLivreur->setTelephone("0665473913");
        $personneLivreur->setAdresse("45 rue de la livraison");
        $personneLivreur->setVehicule("Voiture");
        $personneLivreur->setFkUser($userLivreur->getId());
        $personneLivreur->setFkVille($valenciennes->getId());
        $manager->persist($personneLivreur);

        $personneClient = new Personne();
        $personneClient->setNom("Leroy");
        $personneClient->setPrenom("Julian");
        $personneClient->setEmail($userClient->getEmail());
        $personneClient->setTelephone("0665473913");
        $personneClient->setAdresse("45 rue de la livraison");
        $personneClient->setFkUser($userClient->getId());
        $personneClient->setFkVille($valenciennes->getId());
        $manager->persist($personneClient);

        $typeRestoMexicain = new TypeResto();
        $typeRestoMexicain->setLibelle("Mexicain");
        $manager->persist($typeRestoMexicain);

        $typeRestoItalien = new TypeResto();
        $typeRestoItalien->setLibelle("Italien");
        $manager->persist($typeRestoItalien);

        $typeRestoKebab = new TypeResto();
        $typeRestoKebab->setLibelle("Kebab");
        $manager->persist($typeRestoKebab);

        $restaurantMexicain = new Restaurant();
        $restaurantMexicain->setNom("El Piquanté");
        $restaurantMexicain->setLieu("78 rue du piment");
        $restaurantMexicain->setFkPersonne($userRestaurateur->getId());
        $restaurantMexicain->setFkTypeResto($typeRestoMexicain->getId());
        $restaurantMexicain->setFkVille($valenciennes->getId());
        $manager->persist($restaurantMexicain);

        $platMexicain = new Plat();
        $platMexicain->setLibelle("Pate Bolo");
        $platMexicain->setDescription("Super pate bolo qui pique");
        $platMexicain->setTarif(11.95);
        $platMexicain->setFkRestaurant($restaurantMexicain->getId());
        $manager->persist($platMexicain);

        $commandeJuju = new Commande();
        $commandeJuju->setDestination($personneClient->getAdresse());
        $commandeJuju->setFkClient($personneClient->getId());
        $commandeJuju->setFkLivreur($personneLivreur->getId());
        $manager->persist($commandeJuju);

        $detailCommandeJuju = new DetailCommande();
        $detailCommandeJuju->setFkPlat($platMexicain->getId());
        $detailCommandeJuju->setQuantite(3);
        $detailCommandeJuju->setFkCommande($commandeJuju->getId());
        $manager->persist($detailCommandeJuju);
        

        $manager->flush();
    }
}
