# Workflow des Demandes d'Actes Civils

## Diagramme de Flux

```
[Citoyen] → [Création Demande] → [Upload Documents] → [Soumission] → [Paiement] → [Examen Agent] → [Validation/Rejet] → [Génération PDF] → [Délivrance]
```

## États des Demandes

### 1. Brouillon (draft)
- **Qui**: Citoyen
- **Actions possibles**:
  - Modifier les informations
  - Ajouter/supprimer des documents
  - Soumettre la demande
  - Supprimer la demande

### 2. En attente de paiement (pending_payment)
- **Qui**: Citoyen
- **Actions possibles**:
  - Effectuer le paiement
  - Annuler la demande (retour au brouillon)

### 3. En cours d'examen (under_review)
- **Qui**: Agent communal
- **Actions possibles**:
  - Valider la demande
  - Rejeter la demande
  - Demander des documents supplémentaires
  - Communiquer avec le citoyen

### 4. Validé (validated)
- **Qui**: Système
- **Actions automatiques**:
  - Génération du PDF avec QR code
  - Notification au citoyen
  - Passage à l'état "Prêt"

### 5. Rejeté (rejected)
- **Qui**: Agent communal
- **Actions possibles**:
  - Le citoyen peut créer une nouvelle demande
  - Communication avec l'agent pour comprendre les motifs

### 6. Prêt (ready)
- **Qui**: Citoyen
- **Actions possibles**:
  - Télécharger l'acte PDF
  - Vérifier l'acte via QR code

## Rôles et Permissions

### Citoyen
- ✅ Créer des demandes
- ✅ Modifier ses demandes (brouillon uniquement)
- ✅ Uploader des documents
- ✅ Effectuer des paiements
- ✅ Consulter ses demandes
- ✅ Communiquer avec les agents
- ✅ Télécharger ses actes

### Agent Communal
- ✅ Consulter toutes les demandes
- ✅ Valider/rejeter les demandes
- ✅ Demander des documents supplémentaires
- ✅ Communiquer avec les citoyens
- ✅ Consulter les statistiques

### Administrateur
- ✅ Gérer tous les utilisateurs
- ✅ Consulter toutes les demandes
- ✅ Configurer le système
- ✅ Générer des rapports
- ✅ Superviser l'activité

## Processus de Validation

### 1. Vérification des Documents
L'agent vérifie que tous les documents requis sont présents et valides :

**Acte de Naissance**:
- [ ] Déclaration de naissance
- [ ] CNI des parents
- [ ] CNI des témoins

**Acte de Mariage**:
- [ ] Actes de naissance des époux
- [ ] CNI des époux
- [ ] Certificats de célibat
- [ ] Certificat de domicile
- [ ] CNI des témoins
- [ ] Photos 4x4

**Acte de Décès**:
- [ ] Déclaration de décès
- [ ] CNI du déclarant
- [ ] CNI des témoins
- [ ] Acte de mariage (si marié)

### 2. Validation des Informations
- Vérification de la cohérence des données
- Contrôle des délais légaux
- Validation des pièces d'identité

### 3. Décision
- **Validation**: Si tout est conforme
- **Rejet**: Si des éléments manquent ou sont incorrects
- **Demande de compléments**: Si des documents supplémentaires sont nécessaires

## Système de Paiement

### Méthodes Supportées
1. **Mobile Money**
   - Orange Money
   - MTN Mobile Money
   - Processus: Génération de référence → Paiement → Confirmation

2. **Virement Bancaire**
   - Banque Commerciale du Cameroun
   - Processus: Instructions de virement → Paiement → Confirmation

### Sécurité des Paiements
- Références uniques pour chaque paiement
- Vérification de l'idempotence
- Logs de toutes les transactions
- Intégration avec les APIs de paiement

## Génération des Actes

### Processus
1. **Validation de la demande** par l'agent
2. **Génération automatique** du PDF
3. **Création du QR code** de vérification
4. **Stockage sécurisé** du fichier
5. **Notification** au citoyen

### Contenu du PDF
- Informations de l'acte
- Numéro de référence unique
- QR code de vérification
- Signature numérique
- Filigrane de sécurité

## Vérification Publique

### URL de Vérification
```
https://actescivils.cm/verify/{reference_number}
```

### Informations Affichées
- Type d'acte
- Statut (validé)
- Date de validation
- Informations principales (sans données sensibles)
- Lien de téléchargement (si autorisé)

## Notifications

### Types de Notifications
1. **Email**: Confirmations, mises à jour de statut
2. **SMS**: Notifications urgentes, confirmations de paiement
3. **In-app**: Messages dans l'interface utilisateur

### Déclencheurs
- Création de compte
- Soumission de demande
- Confirmation de paiement
- Changement de statut
- Validation/rejet
- Génération d'acte

## Gestion des Erreurs

### Erreurs Communes
1. **Documents manquants**: Demande de compléments
2. **Paiement échoué**: Retry ou méthode alternative
3. **Délai dépassé**: Procédure spéciale
4. **Données incorrectes**: Rejet avec explication

### Procédures de Récupération
- Sauvegarde automatique des brouillons
- Historique complet des actions
- Possibilité de reprendre une demande
- Support client intégré

## Métriques et Rapports

### Indicateurs Clés
- Nombre de demandes par type
- Taux de validation/rejet
- Temps de traitement moyen
- Revenus générés
- Satisfaction utilisateur

### Rapports Disponibles
- Rapport mensuel des activités
- Statistiques de paiement
- Performance des agents
- Analyse des délais
- Export des données

## Sécurité et Conformité

### Protection des Données
- Chiffrement des documents sensibles
- Accès restreint par rôle
- Logs d'audit complets
- Sauvegarde régulière

### Conformité Légale
- Respect des délais légaux
- Conservation des données selon la loi
- Traçabilité complète
- Signature électronique des actes
