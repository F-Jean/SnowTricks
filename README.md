# SNOWTRICK

CRUD sur les figures de snowboard.

Contient :

-   un annuaire des figures de snowboard;
-   la gestion des figures (création, modification, consultation);
-   un espace de discussion commun à toutes les figures.

## Installation

Commencer par cloner le repository :

```
https://github.com/F-Jean/SnowTricks.git
cd SnowTricks
```

Mettre à jour les dépendances :

```
composer update
```

## Configuration

Créer la base de données, créer un fichier `.env.local` :

```
DATABASE_URL=mysql://root:password@127.0.0.1:3306/snowtricks
```

L'application utilise la vérification par mail ici avec Gmail,
afin qu'elle fonctionne ajouter à la suite :

```
MAILER_DSN=gmail://votreEmail:votreMDP@default?verify_peer=0
```

Lancer la création :

```
php bin/console doctrine:database:create
```

Installer les fixtures et mettre à jour la base de données

```
composer database
```

## Démarer le serveur et aller sur le site :

```
symfony server:start -d
https://127.0.0.1:8000
```
