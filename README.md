# Application de Gestion des Actes d'État Civil

Une application web monolithique développée avec Laravel pour digitaliser la gestion des actes d'état civil (naissance, mariage, décès) au Cameroun.

## 🎯 Objectif

Digitaliser le parcours complet de demande et d'obtention des actes d'état civil :
- Dépôt de dossier en ligne
- Paiement sécurisé (Mobile Money / Virement bancaire)
- Traitement par l'administration
- Délivrance de l'acte (PDF avec QR code de vérification)

## 👥 Acteurs

### Citoyens
- Création de compte et authentification
- Soumission de demandes d'actes
- Upload des documents requis
- Paiement en ligne
- Suivi du statut des demandes
- Téléchargement des actes validés

### Agents Communaux
- Consultation des demandes en attente
- Validation des documents
- Demande de compléments
- Validation ou rejet des dossiers
- Communication avec les citoyens

### Administrateurs
- Gestion des comptes utilisateurs
- Configuration du système
- Supervision générale
- Génération de rapports

## 🚀 Fonctionnalités Principales

### Pour les Citoyens
- ✅ Inscription et authentification
- ✅ Création de demandes d'actes (naissance, mariage, décès)
- ✅ Upload de documents avec validation
- ✅ Paiement en ligne (Mobile Money / Virement)
- ✅ Suivi en temps réel du statut
- ✅ Messagerie avec les agents
- ✅ Téléchargement des actes PDF

### Pour les Agents
- ✅ Tableau de bord avec statistiques
- ✅ Liste des demandes en attente
- ✅ Validation des documents
- ✅ Demande de compléments
- ✅ Validation/rejet des dossiers
- ✅ Communication avec les citoyens

### Pour les Administrateurs
- ✅ Tableau de bord administratif
- ✅ Gestion des utilisateurs
- ✅ Configuration des tarifs et délais
- ✅ Rapports et statistiques
- ✅ Export de données

### Fonctionnalités Système
- ✅ Vérification publique des actes (QR code)
- ✅ Génération de PDF avec QR code
- ✅ Système de notifications
- ✅ Gestion des rôles et permissions
- ✅ Interface multilingue (Français)

## 🛠️ Technologies Utilisées

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Bootstrap 5, Blade Templates
- **Base de données**: SQLite (développement)
- **Authentification**: Laravel Auth
- **Paiements**: Système mock (intégration Mobile Money/Virement)
- **PDF**: Génération avec QR code
- **Icons**: Bootstrap Icons

## 📋 Prérequis

- PHP 8.2 ou supérieur
- Composer
- Node.js et NPM
- SQLite (ou MySQL/PostgreSQL)

## 🚀 Installation

1. **Cloner le projet**
```bash
git clone <repository-url>
cd freddy-mvondo
```

2. **Installer les dépendances**
```bash
composer install
npm install
```

3. **Configuration de l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Base de données**
```bash
php artisan migrate --seed
```

5. **Compilation des assets**
```bash
npm run build
```

6. **Démarrer le serveur**
```bash
php artisan serve
```

L'application sera accessible sur `http://localhost:8000`

## 👤 Comptes de Test

### Administrateur
- **Email**: admin@actescivils.cm
- **Mot de passe**: password

### Agent
- **Email**: agent1@actescivils.cm
- **Mot de passe**: password

### Citoyen
- **Email**: jean.dupont@example.com
- **Mot de passe**: password

## 📊 Types d'Actes Supportés

### Acte de Naissance
- **Délai**: 30 jours après naissance
- **Prix**: 7 200 XAF
- **Documents requis**:
  - Déclaration de naissance
  - CNI des parents
  - CNI des témoins

### Acte de Mariage
- **Prix**: 15 000 XAF
- **Documents requis**:
  - Actes de naissance des époux
  - CNI des époux
  - Certificats de célibat
  - Certificat de domicile
  - CNI des témoins
  - Photos 4x4

### Acte de Décès
- **Prix**: 5 000 XAF
- **Documents requis**:
  - Déclaration de décès
  - CNI du déclarant
  - CNI des témoins
  - Acte de mariage (si marié)

## 🔄 Workflow des Demandes

1. **Création** - Le citoyen crée une demande
2. **Brouillon** - Upload des documents requis
3. **Soumission** - Validation des documents et soumission
4. **Paiement** - Paiement en ligne (Mobile Money/Virement)
5. **Examen** - Traitement par l'agent communal
6. **Validation** - Validation ou rejet par l'agent
7. **Délivrance** - Génération du PDF avec QR code

## 🔐 Sécurité

- Authentification Laravel avec hachage des mots de passe
- Middleware de rôles pour l'autorisation
- Validation des fichiers uploadés
- Protection CSRF
- Stockage sécurisé des documents

## 📱 Responsive Design

L'application est entièrement responsive et s'adapte à tous les écrans :
- Desktop
- Tablette
- Mobile

## 🌐 Vérification Publique

Les actes générés incluent un QR code permettant la vérification publique :
- URL: `/verify/{reference_number}`
- Vérification gratuite et accessible à tous
- Affichage des informations de l'acte

## 📈 Rapports et Statistiques

### Tableau de bord Agent
- Demandes en attente
- Actes validés aujourd'hui
- Actes rejetés aujourd'hui
- Total du mois

### Tableau de bord Admin
- Nombre de citoyens/agents
- Demandes en attente
- Revenus totaux
- Statistiques mensuelles

## 🔧 Configuration

### Tarifs (modifiables par admin)
- Acte de naissance: 7 200 XAF
- Acte de mariage: 15 000 XAF
- Acte de décès: 5 000 XAF

### Délais (modifiables par admin)
- Déclaration de naissance: 30 jours
- Déclaration de mariage: 0 jour
- Déclaration de décès: 0 jour

## 🚀 Déploiement

### Production
1. Configurer la base de données de production
2. Configurer les variables d'environnement
3. Optimiser l'application:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Serveur Web
- Apache/Nginx avec PHP-FPM
- SSL/HTTPS recommandé
- Stockage des fichiers sécurisé

## 🤝 Contribution

1. Fork le projet
2. Créer une branche feature
3. Commit les changements
4. Push vers la branche
5. Ouvrir une Pull Request

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## 📞 Support

Pour toute question ou support :
- Email: contact@actescivils.cm
- Téléphone: +237 XXX XXX XXX

## 🔮 Roadmap

### Version 2.0
- [ ] Intégration réelle des paiements Mobile Money
- [ ] Notifications SMS/Email automatiques
- [ ] Application mobile native
- [ ] API REST pour intégrations tierces
- [ ] Système de workflow avancé
- [ ] Intégration avec les registres d'état civil existants

### Version 2.1
- [ ] Support multilingue (Anglais, Langues locales)
- [ ] Signature électronique des actes
- [ ] Blockchain pour la vérification
- [ ] Intelligence artificielle pour la validation des documents
- [ ] Tableau de bord analytics avancé

---

**Développé avec ❤️ pour digitaliser l'administration camerounaise**