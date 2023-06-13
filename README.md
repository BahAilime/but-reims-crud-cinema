# Développement d'une application Web de consultation et modification de films

## GUILLARD Firmin (guil0230) et BEGUIN Emilia (begu0025)

## Installation / Configuration

Installation de Composer


## Serveur Web local

**Lancement du serveur local :**  
php -d display_errors -S localhost:8000 -t public/

**Adresse d'accès du serveur local :**  
http://localhost:8000/

### Lancer le serveur avec composer :

**Sur Linux :**
- composer run-script start:linux

**Sur Windows :**
- composer run-script start:windows


## Style de codage

PHP CS Fixer permet de corriger les erreurs de mise en page pour respecter
la mise en page  PSR-12.

Pour l'utiliser il faut utiliser plusieurs commandes :

**1) Première vérification :**
- php vendor/bin/php-cs-fixer fix --dry-run  
  _(--dry run évite les modifications)_

**2) Deuxième vériification :**
- php vendor/bin/php-cs-fixer fix --dry-run --diff  
  _(--diff permet de voir les différences entre l'original et le
  corrigé)_

**3) Dernière vérification :**
- php vendor/bin/php-cs-fixer fix  
  _(fixe les erreurs)_

**Mise en forme automatique :**
CTRL+SHIFT+ALT+L

### Scripts composer PHP CS Fixer

**Vérification de code :**
- composer run-script test:cs

**Correction de code :**
- composer run-script fix:cs