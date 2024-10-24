# Site CV/Portfolio

Ce projet consiste à réaliser un site web de CV/Portfolio comprenant plusieurs pages et proposant diverses fonctionnalités pour la gestion des CV et portfolios. Il inclut une interface utilisateur intuitive avec des options d'authentification et de gestion de contenu.

## Fonctionnalités

### Pages principales :
- **Page d'accueil** : Landing page statique avec un aperçu des informations principales.
- **Page CV** : Modifiable par l'utilisateur connecté, affichant les informations de son CV.
- **Page Projets/Portfolio** : Liste des projets de l'utilisateur avec la possibilité d'ajouter et de modifier des projets.
- **Page de login** : Pour s'authentifier sur le site.
- **Page de logout** : Pour se déconnecter.
- **Page Profil** : L'utilisateur connecté peut modifier ses informations personnelles.
- **Page Panneau d’administration** : Accessible aux administrateurs

### Navigation
- Une en-tête et un pied de page sont présents sur toutes les pages.
- La navigation s'effectue via un menu.
- Une fois connecté, le nom et prénom de l'utilisateur apparaissent sur l'interface.

### Authentification
- **Connexion/Déconnexion** : Les utilisateurs peuvent se connecter et se déconnecter.
- **Gestion des utilisateurs** : Les administrateurs peuvent ajouter de nouveaux utilisateurs avec des rôles spécifiques (utilisateur ou administrateur).

### CV
- L'utilisateur connecté peut voir et modifier les informations de son CV.
- Il peut personnaliser le style de la page CV.

### Projets/Portfolio
- L'utilisateur connecté peut ajouter des projets à son portfolio.
- Les utilisateurs peuvent marquer des projets comme favoris.

### Profil
- L'utilisateur connecté peut modifier ses informations personnelles.

## Modèles de données

### Utilisateur (`user`)
- `email` : Adresse e-mail de l'utilisateur.
- `first_name` : Prénom de l'utilisateur.
- `last_name` : Nom de famille de l'utilisateur.
- `password` : Mot de passe de l'utilisateur.
- `role` : Rôle de l'utilisateur (user ou admin).

### CV (`cv`)
- `title` : Titre du CV.
- `description` : Description du CV.
- `skills` : Liste de compétences, formatée en objet JSON (par exemple : `skill: {title, description, years_of_experience}`).
- `experiences-external` : Expériences professionnelles externes (par exemple : `experience: {title, start_date, end_date}`).
- `educations-external` : Formations suivies (par exemple : `education: {school, start_date, end_date}`).

### Projet (`project`)
- `title` : Titre du projet.
- `description` : Description du projet.
- `image` : Image associée au projet.

## Installation

1. Clonez ce dépôt.
2. Installez les dépendances via un gestionnaire de paquets.
3. Démarrez le serveur local avec `Laragon` et déposez ce répo dans le fichier laragon `www`.

## Utilisation

1. Créez un compte ou connectez vous avec un compte admin ou `bigthomas@admin.ynov` / `password` .
2. Naviguez à travers le menu pour gérer votre CV et vos projets.
3. Accédez au panneau d'administration si vous disposez des droits d'administrateur ou grace au compte donnée au préalable.

## Technologies utilisées
- **Frontend** : HTML, CSS
- **Backend** : Php
- **Base de données** : MySQL , PhpMyAdmin

## Auteur

Ce projet a été développé par Laucournet Thomas , B2 Ynov projet Php 2024-2025
