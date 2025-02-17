# ZakVille

Pour cet exercice, il nous est demandé de travailler en groupe. Il nous faut
créer un site avec 4 pages.

1. Page d'index
2. Page d'inscription d'un utilisateur
3. Page de connexion d'un utilisateur
4. Page de profil d'un utilisateur

Il nous faut réaliser cet exercice en utilisant du code PHP, avec un maximum de
**P**rogrammation **O**rienté **O**bjet (**POO**).

## Mike

Ses tâches sont de :

1. Créer la base de données avec n'importe quel nom.

   > J'ai choisi d'appeler cette base de données `tp_zakville`.
   >
   > Voir [database/01-create-database.sql](database/01-create-database.sql)

2. Créer une table `villes` en base de données avec les champs suivants et **10
   enregistrements**.

   | type     | champ    |
   | -------- | -------- |
   | `int`    | id       |
   | `string` | nom      |
   | `string` | pays     |
   | `string` | capitale |

   > Voir [database/02-create-table-villes.sql](database/02-create-table-villes.sql)
   >
   > Voir [database/03-insert-villes.sql](database/03-insert-villes.sql)

3. Créer une page d'index, n'importe quel sujet ou thème.

4. Créer la page d'inscription d'un utilisateur.

## Zakaria

Ses tâches sont de :

1. Créer une table `utilisateurs` en base de données avec les champs suivants et
   faire la relation en base de données entre les tables `utilisateurs` et
   `villes` :

   | type       | champ             |
   | ---------- | ----------------- |
   | `int`      | id                |
   | `string`   | nom               |
   | `string`   | prénom            |
   | `string`   | pseudo            |
   | `string`   | mot_de_passe      |
   | `datetime` | date_de_naissance |

   **Mike** exige que le nom faisant relation à la table `villes` se nomme
   `ville_id`.

   > Voir [database/02-create-table-utilisateurs.sql](database/02-create-table-utilisateurs.sql)

2. Créer la page de profil

   - La page DOIT être accessible uniquement lorsqu'un utilisateur est connecté.

   - Afficher les informations de l'utilisateur connecté, à savoir :

     1. Le nom
     2. Le prénom
     3. Le pseudo

   - Image requise.
