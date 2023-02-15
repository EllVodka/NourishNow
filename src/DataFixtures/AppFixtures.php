<?php

namespace App\DataFixtures;

use App\Entity\Commande;
use App\Entity\DetailCommande;
use App\Entity\Personne;
use App\Entity\Plat;
use App\Entity\User;
use App\Entity\Restaurant;
use App\Entity\Secteur;
use App\Entity\Status;
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
        $valenciennes->setFkSecteur($valMetroPol);
        $valenciennes->setLibelle("Valenciennes");
        $manager->persist($valenciennes);


        $personneRestaurateur = new Personne();
        $personneRestaurateur->setNom("Poivre");
        $personneRestaurateur->setPrenom("Arnaud");
        $personneRestaurateur->setEmail($userRestaurateur->getEmail());
        $personneRestaurateur->setTelephone("0647653913");
        $personneRestaurateur->setAdresse("45 rue du bordel");
        $personneRestaurateur->setVehicule(null);
        $personneRestaurateur->setFkUser($userRestaurateur);
        $personneRestaurateur->setFkVille($valenciennes);
        $manager->persist($personneRestaurateur);

        $personneLivreur = new Personne();
        $personneLivreur->setNom("Livreur");
        $personneLivreur->setPrenom("Eric");
        $personneLivreur->setEmail($userLivreur->getEmail());
        $personneLivreur->setTelephone("0665473913");
        $personneLivreur->setAdresse("45 rue de la livraison");
        $personneLivreur->setVehicule("Voiture");
        $personneLivreur->setFkUser($userLivreur);
        $personneLivreur->setFkVille($valenciennes);
        $manager->persist($personneLivreur);

        $personneClient = new Personne();
        $personneClient->setNom("Leroy");
        $personneClient->setPrenom("Julian");
        $personneClient->setEmail($userClient->getEmail());
        $personneClient->setTelephone("0665473913");
        $personneClient->setAdresse("45 rue de la livraison");
        $personneClient->setVehicule(null);
        $personneClient->setFkUser($userClient);
        $personneClient->setFkVille($valenciennes);
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
        $restaurantMexicain->setFkPersonne($personneRestaurateur);
        $restaurantMexicain->setFkTypeResto($typeRestoMexicain);
        $restaurantMexicain->setFkVille($valenciennes);
        $manager->persist($restaurantMexicain);

        $platMexicain = new Plat();
        $platMexicain->setLibelle("Pate Bolo");
        $platMexicain->setDescription("Super pate bolo qui pique");
        $platMexicain->setTarif(11.95);
        $platMexicain->setFkRestaurant($restaurantMexicain);
        $manager->persist($platMexicain);

        $statusAttente = new Status();
        $statusAttente->setLibelle("En attente");
        $manager->persist($statusAttente);

        $statusAccepter = new Status();
        $statusAccepter->setLibelle("Acceptée");
        $manager->persist($statusAccepter);

        $statusPrete = new Status();
        $statusPrete->setLibelle("Prête");
        $manager->persist($statusPrete);

        $statusPriseEnCharge = new Status();
        $statusPriseEnCharge->setLibelle("Prise en charge par le livreur");
        $manager->persist($statusPriseEnCharge);

        $statusCommandeLivrer = new Status();
        $statusCommandeLivrer->setLibelle("Commande livrée");
        $manager->persist($statusCommandeLivrer);

        $commandeJuju = new Commande();
        $commandeJuju->setDestination($personneClient->getAdresse());
        $commandeJuju->setFkClient($personneClient);
        $commandeJuju->setFkLivreur($personneLivreur);
        $commandeJuju->setFkStatus($statusPrete);
        $manager->persist($commandeJuju);

        $detailCommandeJuju = new DetailCommande();
        $detailCommandeJuju->setFkPlat($platMexicain);
        $detailCommandeJuju->setQuantite(3);
        $detailCommandeJuju->setFkCommande($commandeJuju);
        $manager->persist($detailCommandeJuju);
        

        $manager->flush();
    }
}
