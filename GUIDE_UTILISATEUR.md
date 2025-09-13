# Guide d'Utilisation - Application de Gestion des Actes d'État Civil

## 🎯 Introduction

Ce guide vous accompagne dans l'utilisation de l'application de gestion des actes d'état civil. Que vous soyez citoyen, agent communal ou administrateur, vous trouverez ici toutes les informations nécessaires pour utiliser efficacement le système.

## 👥 Guide pour les Citoyens

### 1. Création de Compte

1. **Accédez à la page d'accueil**

    - Rendez-vous sur `http://localhost:8000`
    - Cliquez sur "Créer un compte"

2. **Remplissez le formulaire d'inscription**

    - Nom complet
    - Adresse email
    - Numéro de téléphone (optionnel)
    - Mot de passe (minimum 8 caractères)
    - Confirmation du mot de passe

3. **Validez votre inscription**
    - Acceptez les conditions d'utilisation
    - Cliquez sur "Créer mon compte"

### 2. Connexion

1. **Page de connexion**
    - Email et mot de passe
    - Option "Se souvenir de moi"
    - Cliquez sur "Se connecter"

### 3. Créer une Demande d'Acte

#### Étape 1: Sélection du Type d'Acte

1. Cliquez sur "Nouvelle Demande"
2. Choisissez le type d'acte :
    - **Acte de Naissance** (7 200 XAF)
    - **Acte de Mariage** (15 000 XAF)
    - **Acte de Décès** (5 000 XAF)

#### Étape 2: Remplissage du Formulaire

**Pour un Acte de Naissance :**

-   Informations sur l'enfant (prénom, nom, date de naissance, lieu, sexe)
-   Informations sur les parents (noms, professions)

**Pour un Acte de Mariage :**

-   Informations sur les époux (noms, dates de naissance)
-   Informations sur le mariage (date, lieu)

**Pour un Acte de Décès :**

-   Informations sur le défunt (nom, date de décès, lieu, cause)
-   Informations sur le déclarant (nom, lien de parenté)

#### Étape 3: Upload des Documents

1. Cliquez sur "Ajouter un document"
2. Sélectionnez le type de document
3. Choisissez le fichier (PDF, JPG, PNG - max 10MB)
4. Cliquez sur "Télécharger"

**Documents Requis :**

-   **Naissance**: Déclaration de naissance, CNI parents, CNI témoins
-   **Mariage**: Actes de naissance époux, CNI époux, certificats, photos
-   **Décès**: Déclaration de décès, CNI déclarant, CNI témoins

#### Étape 4: Soumission

1. Vérifiez que tous les documents requis sont uploadés
2. Cliquez sur "Soumettre"
3. Votre demande passe en "En attente de paiement"

### 4. Effectuer le Paiement

1. **Accédez à la page de paiement**

    - Cliquez sur "Effectuer le paiement" dans votre demande

2. **Choisissez la méthode de paiement**

    - **Mobile Money**: Entrez votre numéro de téléphone
    - **Virement Bancaire**: Suivez les instructions affichées

3. **Confirmez le paiement**
    - Montant affiché
    - Cliquez sur "Payer"

### 5. Suivre votre Demande

1. **Tableau de bord**

    - Consultez le statut de vos demandes
    - Filtrez par type ou statut

2. **Détails de la demande**

    - Cliquez sur "Voir" pour accéder aux détails
    - Consultez les messages des agents
    - Téléchargez les documents

3. **Statuts possibles**
    - **Brouillon**: En cours de modification
    - **En attente de paiement**: Paiement requis
    - **En cours d'examen**: Traitement par l'agent
    - **Validé**: Approuvé par l'agent
    - **Rejeté**: Refusé avec motif
    - **Prêt**: Acte disponible au téléchargement

### 6. Télécharger votre Acte

1. **Demande validée**

    - Statut "Prêt"
    - Bouton "Télécharger l'acte"

2. **Fichier PDF**
    - Contient toutes les informations
    - QR code de vérification
    - Signature officielle

## 👨‍💼 Guide pour les Agents Communaux

### 1. Connexion

-   **Email**: agent1@actescivils.cm
-   **Mot de passe**: password

### 2. Tableau de Bord

1. **Statistiques**

    - Demandes en attente
    - Actes validés aujourd'hui
    - Actes rejetés aujourd'hui
    - Total du mois

2. **Actions rapides**
    - Examiner les demandes
    - Voir tous les actes
    - Vérifier un acte

### 3. Examiner une Demande

1. **Liste des demandes en attente**

    - Cliquez sur "Examiner les demandes"
    - Filtrez par type ou date

2. **Détails de la demande**

    - Informations du citoyen
    - Documents fournis
    - Historique des messages

3. **Actions possibles**
    - **Valider**: Si tout est conforme
    - **Rejeter**: Avec motif de rejet
    - **Demander des documents**: Si des pièces manquent

### 4. Valider une Demande

1. **Vérification des documents**

    - Présence de tous les documents requis
    - Qualité et lisibilité des documents
    - Cohérence des informations

2. **Validation**

    - Cliquez sur "Valider"
    - Ajoutez des notes (optionnel)
    - Confirmez la validation

3. **Résultat**
    - PDF généré automatiquement
    - QR code créé
    - Notification envoyée au citoyen

### 5. Rejeter une Demande

1. **Motif de rejet**

    - Documents manquants
    - Informations incorrectes
    - Délai dépassé
    - Autres raisons

2. **Processus**

    - Cliquez sur "Rejeter"
    - Rédigez le motif détaillé
    - Confirmez le rejet

3. **Notification**
    - Le citoyen est informé
    - Peut créer une nouvelle demande

### 6. Demander des Documents Supplémentaires

1. **Sélection des documents**

    - Cochez les documents requis
    - Rédigez un message explicatif

2. **Envoi**
    - Le citoyen reçoit la demande
    - Peut uploader les documents manquants

## 👨‍💻 Guide pour les Administrateurs

### 1. Connexion

-   **Email**: admin@actescivils.cm
-   **Mot de passe**: password

### 2. Tableau de Bord Administratif

1. **Statistiques globales**

    - Nombre de citoyens/agents
    - Demandes en attente
    - Revenus totaux
    - Activité du mois

2. **Gestion des utilisateurs**
    - Activer/désactiver des comptes
    - Modifier les rôles
    - Consulter l'activité

### 3. Configuration du Système

1. **Tarification**

    - Modifier les prix des actes
    - Ajuster selon les besoins

2. **Délais**

    - Déclaration de naissance (30 jours)
    - Déclaration de mariage (0 jour)
    - Déclaration de décès (0 jour)

3. **Paramètres généraux**
    - Informations de contact
    - Configuration des paiements

### 4. Rapports et Statistiques

1. **Rapports disponibles**

    - Rapport mensuel des activités
    - Statistiques de paiement
    - Performance des agents

2. **Export des données**
    - Format CSV
    - Filtres par période
    - Données complètes

## 🔍 Vérification Publique des Actes

### Pour Vérifier un Acte

1. **Page de vérification**

    - Rendez-vous sur `/verify`
    - Entrez le numéro de référence

2. **Informations affichées**

    - Type d'acte
    - Statut (validé)
    - Date de validation
    - Informations principales

3. **Téléchargement**
    - Lien vers le PDF (si autorisé)
    - Vérification gratuite

## 📱 Utilisation Mobile

### Interface Responsive

-   L'application s'adapte automatiquement aux écrans mobiles
-   Navigation optimisée pour le tactile
-   Upload de documents facilité

### Fonctionnalités Mobile

-   Création de demandes
-   Upload de photos directement
-   Paiement Mobile Money
-   Notifications push

## ❓ Questions Fréquentes

### Q: Comment récupérer mon mot de passe ?

R: Contactez l'administration ou utilisez la fonction "Mot de passe oublié" (à implémenter).

### Q: Puis-je modifier ma demande après soumission ?

R: Non, une fois soumise, la demande ne peut plus être modifiée. Contactez l'agent si nécessaire.

### Q: Combien de temps prend le traitement ?

R: Généralement 3 à 5 jours ouvrables après validation du paiement.

### Q: Puis-je payer en espèces ?

R: Oui, contactez l'administration pour les modalités.

### Q: Mon acte est-il valide à l'étranger ?

R: Les actes générés sont conformes aux standards internationaux.

## 🆘 Support et Contact

### En cas de problème

-   **Email**: contact@actescivils.cm
-   **Téléphone**: +237 XXX XXX XXX
-   **Heures**: Lundi - Vendredi, 8h00 - 17h00

### Assistance technique

-   Vérifiez votre connexion internet
-   Essayez de rafraîchir la page
-   Videz le cache de votre navigateur
-   Contactez le support si le problème persiste

## 🔒 Sécurité et Confidentialité

### Protection des données

-   Tous les documents sont chiffrés
-   Accès restreint par rôle
-   Sauvegarde régulière
-   Conformité RGPD

### Bonnes pratiques

-   Utilisez un mot de passe fort
-   Déconnectez-vous après utilisation
-   Ne partagez pas vos identifiants
-   Signalez tout comportement suspect

---

**Merci d'utiliser notre service de gestion des actes d'état civil !**
