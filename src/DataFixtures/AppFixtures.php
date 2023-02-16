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

        // Création des users dans la table user \\

        $userRestaurateur = new User();
        $userRestaurateur->setEmail("arnaudpoivre@gmail.com");
        $passwordRestaurateur = $this->hasher->hashPassword($userRestaurateur, 'arnaud');
        $userRestaurateur->setPassword($passwordRestaurateur);
        $userRestaurateur->setRoles(["ROLE_RESTAURATEUR"]);
        $manager->persist($userRestaurateur);

        $userRestaurateur2 = new User();
        $userRestaurateur2->setEmail("benjapiedplu@gmail.com");
        $passwordRestaurateur2 = $this->hasher->hashPassword($userRestaurateur, 'ben');
        $userRestaurateur2->setPassword($passwordRestaurateur2);
        $userRestaurateur2->setRoles(["ROLE_RESTAURATEUR"]);
        $manager->persist($userRestaurateur2);


        $userLivreur = new User();
        $userLivreur->setEmail("ericlivreur@gmail.com");
        $passwordLivreur = $this->hasher->hashPassword($userLivreur, 'eric');
        $userLivreur->setPassword($passwordLivreur);
        $userLivreur->setRoles(["ROLE_LIVREUR"]);
        $manager->persist($userLivreur);

        $userLivreur2 = new User();
        $userLivreur2->setEmail("livreur@livreur.com");
        $passwordLivreur2 = $this->hasher->hashPassword($userLivreur2, 'cire');
        $userLivreur2->setPassword($passwordLivreur2);
        $userLivreur2->setRoles(["ROLE_LIVREUR"]);
        $manager->persist($userLivreur2);


        $userClient = new User();
        $userClient->setEmail("jujuleroy@gmail.com");
        $passwordClient = $this->hasher->hashPassword($userClient, 'julian');
        $userClient->setPassword($passwordClient);
        $userClient->setRoles(["ROLE_CLIENT"]);
        $manager->persist($userClient);

        $userClient2 = new User();
        $userClient2->setEmail("client@client.com");
        $passwordClient2 = $this->hasher->hashPassword($userClient2, 'client');
        $userClient2->setPassword($passwordClient2);
        $userClient2->setRoles(["ROLE_CLIENT"]);
        $manager->persist($userClient2);

        // Création des users dans la table user \\

        // Création des secteurs dans la table secteut \\

        $valMetroPol = new Secteur();
        $valMetroPol->setLibelle("Valenciennes Metropol");
        $manager->persist($valMetroPol);

        $banlieueParis = new Secteur();
        $banlieueParis->setLibelle("Banlieue Parisienne");
        $manager->persist($banlieueParis);

        // Création des secteurs dans la table secteut \\

        // Création des villes dans la table ville \\

        $valenciennes = new Ville();
        $valenciennes->setFkSecteur($valMetroPol);
        $valenciennes->setLibelle("Valenciennes");
        $manager->persist($valenciennes);

        $anzin = new Ville();
        $anzin->setFkSecteur($valMetroPol);
        $anzin->setLibelle("Anzin");
        $manager->persist($anzin);

        $sevran = new Ville();
        $sevran->setFkSecteur($banlieueParis);
        $sevran->setLibelle("Sevran");
        $manager->persist($sevran);

        // Création des villes dans la table ville \\
        
        // Création des utilisateurs dans la table personne \\

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

        $personneRestaurateur2 = new Personne();
        $personneRestaurateur2->setNom("Pluchart");
        $personneRestaurateur2->setPrenom("Benjapied");
        $personneRestaurateur2->setEmail($userRestaurateur2->getEmail());
        $personneRestaurateur2->setTelephone("0663673913");
        $personneRestaurateur2->setAdresse("45 rue de basic fit");
        $personneRestaurateur2->setVehicule(null);
        $personneRestaurateur2->setFkUser($userRestaurateur2);
        $personneRestaurateur2->setFkVille($valenciennes);
        $manager->persist($personneRestaurateur2);

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

        $personneLivreur2 = new Personne();
        $personneLivreur2->setNom("Sevran");
        $personneLivreur2->setPrenom("Livreur");
        $personneLivreur2->setEmail($userLivreur2->getEmail());
        $personneLivreur2->setTelephone("0665474713");
        $personneLivreur2->setAdresse("45 rue du bazar");
        $personneLivreur2->setVehicule("Voiture");
        $personneLivreur2->setFkUser($userLivreur2);
        $personneLivreur2->setFkVille($sevran);
        $manager->persist($personneLivreur2);

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

        $personneClient2 = new Personne();
        $personneClient2->setNom("Client");
        $personneClient2->setPrenom("Clitorine");
        $personneClient2->setEmail($userClient2->getEmail());
        $personneClient2->setTelephone("0669472913");
        $personneClient2->setAdresse("45 rue Marc Dorcel");
        $personneClient2->setVehicule(null);
        $personneClient2->setFkUser($userClient2);
        $personneClient2->setFkVille($sevran);
        $manager->persist($personneClient2);

        // Création des utilisateurs dans la table personne \\

        // Création de type de resto dans la table typeResto \\

        $typeRestoMexicain = new TypeResto();
        $typeRestoMexicain->setLibelle("Mexicain");
        $manager->persist($typeRestoMexicain);

        $typeRestoItalien = new TypeResto();
        $typeRestoItalien->setLibelle("Italien");
        $manager->persist($typeRestoItalien);

        $typeRestoKebab = new TypeResto();
        $typeRestoKebab->setLibelle("Kebab");
        $manager->persist($typeRestoKebab);

        $typeRestoCarnivore = new TypeResto();
        $typeRestoCarnivore->setLibelle("Carnivore");
        $manager->persist($typeRestoCarnivore);

        $typeRestoHalal = new TypeResto();
        $typeRestoHalal->setLibelle("Halal");
        $manager->persist($typeRestoHalal);

        // Création de type de resto dans la table typeResto \\

        // Création de restaurant dans la table restaurant \\

        $restaurantMexicain = new Restaurant();
        $restaurantMexicain->setNom("El Piquanté");
        $restaurantMexicain->setLieu("78 rue du piment");
        $restaurantMexicain->setFkPersonne($personneRestaurateur);
        $restaurantMexicain->setFkTypeResto($typeRestoMexicain);
        $restaurantMexicain->setFkVille($valenciennes);
        $manager->persist($restaurantMexicain);

        $restaurantPizzeria = new Restaurant();
        $restaurantPizzeria->setNom("Pizzare");
        $restaurantPizzeria->setLieu("125 rue de l'aléatoire");
        $restaurantPizzeria->setFkPersonne($personneRestaurateur);
        $restaurantPizzeria->setFkTypeResto($typeRestoItalien);
        $restaurantPizzeria->setFkVille($valenciennes);
        $manager->persist($restaurantPizzeria);

        $restaurantCarnivore = new Restaurant();
        $restaurantCarnivore->setNom("Le viandar");
        $restaurantCarnivore->setLieu("125 rue de l'abattoir");
        $restaurantCarnivore->setFkPersonne($personneRestaurateur2);
        $restaurantCarnivore->setFkTypeResto($typeRestoCarnivore);
        $restaurantCarnivore->setFkVille($anzin);
        $manager->persist($restaurantCarnivore);

        $restaurantHalal = new Restaurant();
        $restaurantHalal->setNom("Saveur du maghreb");
        $restaurantHalal->setLieu("125 rue du cochon");
        $restaurantHalal->setFkPersonne($personneRestaurateur2);
        $restaurantHalal->setFkTypeResto($typeRestoHalal);
        $restaurantHalal->setFkVille($sevran);
        $manager->persist($restaurantHalal);

        // Création de restaurant dans la table restaurant \\

        // Création des plats dans la table plat \\

        $platMexicain = new Plat();
        $platMexicain->setLibelle("Pate Bolo");
        $platMexicain->setDescription("Super pate bolo qui pique");
        $platMexicain->setTarif(11.95);
        $platMexicain->setFkRestaurant($restaurantMexicain);
        $platMexicain->setDisponibilite(true);
        $manager->persist($platMexicain);

        $platKebab = new Plat();
        $platKebab->setLibelle("Kebab sauce hanibal");
        $platKebab->setDescription("Le meilleur kebab d'europe, logique c'est hammid qui le fait");
        $platKebab->setTarif(5.65);
        $platKebab->setFkRestaurant($restaurantMexicain);
        $platKebab->setDisponibilite(false);
        $manager->persist($platKebab);

        $platItalien = new Plat();
        $platItalien->setLibelle("Pizza Ananas chèvre miel au anchois");
        $platItalien->setDescription("Pizza de 15cm avec chèvre miel ananas et anchois");
        $platItalien->setTarif(17.50);
        $platItalien->setFkRestaurant($restaurantPizzeria);
        $platItalien->setDisponibilite(true);
        $manager->persist($platItalien);

        $platMexicain2 = new Plat();
        $platMexicain2->setLibelle("Kebab sauce hanibal");
        $platMexicain2->setDescription("Le meilleur kebab d'europe, logique c'est hammid qui le fait");
        $platMexicain2->setTarif(5.65);
        $platMexicain2->setFkRestaurant($restaurantCarnivore);
        $platMexicain2->setDisponibilite(true);
        $manager->persist($platMexicain2);

        $platCochonHalal = new Plat();
        $platCochonHalal->setLibelle("Bon cochon halal");
        $platCochonHalal->setDescription("Tous est bon dans le cochon");
        $platCochonHalal->setTarif(16.65);
        $platCochonHalal->setFkRestaurant($restaurantHalal);
        $platCochonHalal->setDisponibilite(true);
        $manager->persist($platCochonHalal);

        // Création des plats dans la table plat \\

        // Création des status de commande dans la table status \\
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

        // Création des status de commande dans la table status \\

        // Création des commandes dans la table commande \\

        $commandeJuju = new Commande();
        $commandeJuju->setDestination($personneClient->getAdresse());
        $commandeJuju->setFkClient($personneClient);
        $commandeJuju->setFkStatus($statusPrete);
        $manager->persist($commandeJuju);

        $commandeSevran = new Commande();
        $commandeSevran->setDestination($personneClient2->getAdresse());
        $commandeSevran->setFkClient($personneClient2);
        $commandeSevran->setFkStatus($statusPrete);
        $manager->persist($commandeSevran);

        $commandePasPrete = new Commande();
        $commandePasPrete->setDestination($personneClient->getAdresse());
        $commandePasPrete->setFkClient($personneClient);
        $commandePasPrete->setFkStatus($statusAttente);
        $manager->persist($commandePasPrete);

        // Création des commandes dans la table commande \\

        // Création des détails de commande dans la table detailcommande \\

        $detailCommandeJuju = new DetailCommande();
        $detailCommandeJuju->setFkPlat($platMexicain);
        $detailCommandeJuju->setQuantite(3);
        $detailCommandeJuju->setFkCommande($commandeJuju);
        $manager->persist($detailCommandeJuju);

        $detailCommandeSevran = new DetailCommande();
        $detailCommandeSevran->setFkPlat($platCochonHalal);
        $detailCommandeSevran->setQuantite(2);
        $detailCommandeSevran->setFkCommande($commandeSevran);
        $manager->persist($detailCommandeSevran);

        $detailCommandePasPrete = new DetailCommande();
        $detailCommandePasPrete->setFkPlat($platItalien);
        $detailCommandePasPrete->setQuantite(2);
        $detailCommandePasPrete->setFkCommande($commandePasPrete);
        $manager->persist($detailCommandePasPrete);

        // Création des détails de commande dans la table commande \


        $manager->flush();
    }
}
