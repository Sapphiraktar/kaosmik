# Kaosmik
![Logo](public/assets/img/logo-300.png)

Projet de jeu web  développé sous **CodeIgniter 4**. Le système repose sur la gestion d'un équipage de mercenaires, un marché de recrutement persistant avec rafraîchissement temporel (Cantina) et une génération dynamique des statistiques des héros selon leur niveau de rareté.

---

## Fonctionnalités Principales

- **La Cantina (Recrutement)** :
    - Offres de mercenaires renouvelées automatiquement toutes les 12 heures.
    - Décompte interactif en temps réel (HH:MM:SS) avec rechargement automatique à expiration.
    - Coût de rafraîchissement manuel calculé dynamiquement selon le temps restant.
- **Gestion de l'Équipage** :
    - Consultation de la liste des mercenaires possédés.
    - Système de licenciement sécurisé par une modal de confirmation (SweetAlert2) avec revente à la moitié du coût initial.
    - Système de licenciement par lot sécurisé par une modal de confirmation (SweetAlert2) avec revente à la moitié du coût initial.
- **Calculs & Statistiques Automatisés** :
    - Génération des héros à partir de modèles de base (`power_min`, `power_max`).
    - Application automatique des multiplicateurs de rareté sur la puissance et le coût en crédits.
- **Composants d'Affichage Reutilisables** :
    - Intégration de `HeroCell` (CodeIgniter View Cells) pour un rendu uniforme des cartes de héros entre les vues Cantina et Équipage.

---

## Stack Technique

- **Backend** : PHP 8.4+ / CodeIgniter 4.7
- **Base de données** : MySQL / MariaDB (Migrations & Seeders intégrés)
- **Frontend** : Bootstrap 5, Vanilla JavaScript (ES6+), FontAwesome / Pixels Sprites
- **Alertes & UX** : SweetAlert2

---

## Architecture & Concepts Clés

- **`CantinaService`** : Centralisation de la logique métier (calcul du temps restant, calcul des coûts, génération des lots de héros via `insertBatch`).
- **`HeroCell` (Cell Component)** : Gestion du rendu conditionnel de la carte héros (`cantina` vs `crew`) avec ajustement dynamique du layout Flexbox.
- **`RarityLevelModel`** : Calcul automatique des taux d'apparition et nettoyage des données via les callbacks de modèle (`beforeInsert`, `afterInsert`).

---

## Installation & Configuration

### 1. Prérequis
- PHP 8.4 avec les extensions actives (`pdo_mysql`, `intl`, `mbstring`).
- Composer 2.x.

### 2. Cloner le projet & Installer les dépendances
```bash
git clone https://github.com/CIPECMA/kaosmik
cd kaosmik
docker compose up -d
composer install
php spark migrate --all
php spark shield:user create
php spark shield:user activate
php spark shield:user addgroup
php spark db:seed MasterSeeder