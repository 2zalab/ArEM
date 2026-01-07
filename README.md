# ArEM - Plateforme d'Archives de l'ENS de Maroua

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://www.php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

**ArEM** (Archives de l'École Normale Supérieure de Maroua) est un dépôt institutionnel numérique conçu pour archiver, gérer et diffuser les productions académiques de l'ENS de Maroua. Inspiré de HAL mais adapté au contexte local, ArEM offre une solution simple, pédagogique et efficace.

## 🎯 Vision et Objectifs

ArEM n'est pas qu'un simple dépôt de fichiers PDF. C'est une **base de connaissance académique structurée, interopérable et durable** qui permet de :

- **Déposer** : Soumettre des travaux académiques avec métadonnées complètes
- **Valider** : Workflow de validation académique rigoureux
- **Conserver** : Stockage sécurisé avec identifiants pérennes
- **Diffuser** : Accès public ou contrôlé selon les droits définis

## ✨ Fonctionnalités Principales

### 🔐 Gestion des Utilisateurs et Rôles

- **Administrateur principal** : Gestion complète de la plateforme
- **Modérateur scientifique** : Validation des documents soumis
- **Déposant** : Soumission de documents (étudiants, enseignants, chercheurs)
- **Lecteur** : Consultation publique ou restreinte
- **Profils enrichis** : Photo, bio, identifiant ArEM unique

### 📄 Types de Documents Supportés

1. Mémoires de Licence et Master
2. Thèses de Doctorat
3. Articles scientifiques
4. Rapports de stage
5. Projets de fin d'étude
6. Cours et supports pédagogiques
7. Communications scientifiques
8. Rapports institutionnels
9. Documents administratifs académiques
10. Données de recherche (datasets)

### 🔄 Workflow de Validation Académique

1. **Dépôt** par l'auteur avec métadonnées complètes
2. **Vérification administrative** (complétude des informations)
3. **Validation scientifique** par un modérateur qualifié
4. **Publication** ou demande de corrections
5. **Historique complet** avec commentaires et versions

### 🔍 Recherche et Navigation

- **Recherche simple** : Mot-clé dans titre, résumé, mots-clés
- **Recherche avancée** : Par auteur, année, type, département, langue
- **Navigation structurée** : Par discipline, promotion, encadreur
- **Suggestions automatiques** de documents similaires

### 📊 Statistiques et Métriques

- Nombre de vues par document
- Nombre de téléchargements
- Statistiques par département
- Documents les plus consultés
- Tableaux de bord analytiques

### 🎨 Identité Visuelle

- **Couleurs** : Bleu marine (principal), Bleu ciel (secondaire)
- **Interface** : Sobre, académique, responsive
- **Design** : Bootstrap 5, icônes Bootstrap Icons

## 🏗️ Architecture Technique

### Stack Technologique

- **Backend** : Laravel 12.x (PHP 8.2+)
- **Frontend** : Blade templates + Bootstrap 5
- **Base de données** : MySQL / PostgreSQL / SQLite
- **Stockage** : Fichiers locaux sécurisés (possibilité cloud)
- **API** : REST (préparation interopérabilité)

### Structure de la Base de Données

```
users (utilisateurs avec rôles)
├── departments (départements)
├── document_types (types de documents)
├── documents (documents avec métadonnées)
│   ├── document_metadata (métadonnées spécifiques)
│   ├── validation_workflows (historique de validation)
│   ├── document_statistics (statistiques vues/téléchargements)
│   └── notifications (notifications utilisateurs)
```

### Identifiants ArEM

- **Utilisateur** : `AREM-AUTH-2026-000123`
- **Document** : `AREM-DOC-ENS-2026-00456`
- **URL persistante** : `https://arem.ens-maroua.cm/documents/AREM-DOC-ENS-2026-00456`

## 🚀 Installation

### Prérequis

- PHP >= 8.2
- Composer
- MySQL / PostgreSQL ou SQLite
- Node.js et NPM (pour les assets)

### Étapes d'Installation

```bash
# Cloner le repository
git clone https://github.com/2zalab/ArEM.git
cd ArEM

# Installer les dépendances PHP
composer install

# Copier et configurer l'environnement
cp .env.example .env
php artisan key:generate

# Configurer la base de données dans .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=arem_db
DB_USERNAME=root
DB_PASSWORD=

# Exécuter les migrations
php artisan migrate

# (Optionnel) Peupler avec des données de test
php artisan db:seed

# Installer les dépendances frontend
npm install
npm run build

# Lancer le serveur de développement
php artisan serve
```

Accédez à l'application sur `http://localhost:8000`

## 📁 Structure du Projet

```
ArEM/
├── app/
│   ├── Http/Controllers/
│   │   ├── HomeController.php
│   │   ├── DocumentController.php
│   │   ├── ValidationController.php
│   │   ├── SearchController.php
│   │   ├── ProfileController.php
│   │   ├── NotificationController.php
│   │   └── Admin/AdminController.php
│   └── Models/
│       ├── User.php
│       ├── Document.php
│       ├── DocumentType.php
│       ├── Department.php
│       ├── DocumentMetadata.php
│       ├── ValidationWorkflow.php
│       ├── Notification.php
│       └── DocumentStatistic.php
├── database/migrations/
│   ├── *_create_users_table.php
│   ├── *_add_arem_fields_to_users_table.php
│   ├── *_create_departments_table.php
│   ├── *_create_document_types_table.php
│   ├── *_create_documents_table.php
│   ├── *_create_document_metadata_table.php
│   ├── *_create_validation_workflows_table.php
│   ├── *_create_notifications_table.php
│   └── *_create_document_statistics_table.php
├── resources/views/
│   ├── layouts/app.blade.php
│   ├── home.blade.php
│   ├── documents/
│   ├── search/
│   ├── validation/
│   ├── profile/
│   └── admin/
└── routes/web.php
```

## 🎓 Utilisation

### Pour les Déposants

1. **S'inscrire** et compléter son profil
2. **Sélectionner le type** de document à déposer
3. **Remplir le formulaire** avec métadonnées requises
4. **Téléverser le fichier** PDF (max 20 Mo)
5. **Soumettre** pour validation
6. **Suivre le statut** via les notifications

### Pour les Modérateurs

1. Accéder à l'**espace de validation**
2. **Consulter** les documents en attente
3. **Examiner** les métadonnées et le contenu
4. **Approuver**, **rejeter** ou **demander des révisions**
5. **Ajouter des commentaires** justificatifs

### Pour les Administrateurs

1. **Tableau de bord** avec statistiques globales
2. **Gestion des utilisateurs** et des rôles
3. **Gestion des départements** et types de documents
4. **Rapports** et exports
5. **Configuration** de la plateforme

## 🔮 Évolutions Futures

- ✅ **Génération automatique de page de garde PDF**
- ✅ **Interconnexion avec HAL**
- ✅ **Export vers Google Scholar**
- ✅ **DOI institutionnel**
- ✅ **Export OAI-PMH**
- ✅ **Recommandations par IA**
- ✅ **Dépôt de vidéos pédagogiques**
- ✅ **API REST publique**
- ✅ **Multilingue (FR/EN)**

## 🤝 Contribution

Les contributions sont les bienvenues ! Pour contribuer :

1. Forkez le projet
2. Créez une branche (`git checkout -b feature/ma-fonctionnalite`)
3. Committez vos changements (`git commit -m 'Ajout de ma fonctionnalité'`)
4. Pushez vers la branche (`git push origin feature/ma-fonctionnalite`)
5. Ouvrez une Pull Request

## 📝 Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

## 📧 Contact

**École Normale Supérieure de Maroua**
Email: contact@ens-maroua.cm
Site web: https://ens-maroua.cm

## 🙏 Remerciements

- Inspiré par [HAL (Hyper Articles en Ligne)](https://hal.science)
- Développé avec [Laravel](https://laravel.com)
- Interface avec [Bootstrap](https://getbootstrap.com)

---

**ArEM** - Préserver et diffuser la connaissance académique de l'ENS de Maroua 🎓📚
