# SAE_PHP_MUSICS

Réaliser spotify en PHP. Voilà c'est déjà pas mal comme consignes.

## Membres du groupe 

- Kylian Riberou
- Marin Tremine
- Julien Rosse

## specs temporaires pour info

dans le yaml ce sont des albums il n'y a pas de musiques. Le lien de l'image est pour l'mg de l'album. Toutes les musiques hériteront de l'img de album. Ca sera a nous d'en rajouter. Il faut oublier l'attribut parent et utiliser seulement le "by" pour obtenir l'auteur ( meme le prof sait pas ce que le parent fait )

## MCD



## Configurer la base de données

Se rendre dans le dossier `app`.

Pour créer les tables : 
```bash
php cli/sqlite.php create-tables
```

Pour supprimer les tables : 
```bash
php cli/sqlite.php drop-tables
```