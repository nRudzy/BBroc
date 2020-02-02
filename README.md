# FR4 - Création d'un site web (brocante)

Application de gestion des brocantes

## Application

### Requis
- PHP >= 7.1.3

### Installation

#### Cloner le dépôt Git
```bash
git clone https://forge.univ-lyon1.fr/p1806869/fr4.git
```

#### Installer les dépendances et configuration des paramètres
```bash
composer install
```

#### Base de données
Créer la base de données
```bash
php bin/console doctrine:database:create
```

Mettre à jour le schéma
```bash
php bin/console doctrine:migrations:migrate
```

#### Installer les assets
Vous devez avoir yarn d'installé sur votre machine
```bash
sudo npm install -g yarn
```

Initialiser yarn
```bash
yarn install
```

Compiler les assets (l'argument dépend de votre environnement de travail)
```bash
./node_modules/.bin/encore <dev|production>

marche aussi avec:
yarn encore dev --watch
```

#### Démarrer le serveur de dev
```bash
php bin/console server:run
```

L'application est alors utilisable en local à l'adresse suivante
```
http://localhost:8000
```
