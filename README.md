# Louvre

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/57a85008041e40c891708bfa0a2839a0)](https://app.codacy.com/app/EveMarieT/louvre?utm_source=github.com&utm_medium=referral&utm_content=EveMarieT/louvre&utm_campaign=Badge_Grade_Dashboard)

Cette application a été créée dans le cadre de ma formation Chef de Projet Multimédia option développement, pour le le projet 4 
"Billetterie du Louvre". Il s'agit donc d'un projet uniquement.

Requirements
------------

* PHP 7.3.1 ou supérieur;
* et [les éléments nécessaires à la bonne exécution de Symfony] [2]

Installation
-----------
Pour installer l'application de la Billetterie du Louvre, s'assurer d'avoir installer [symfony] [4] et utiliser la commande suivante :

```bash
git clone https:://github.com/EveMarieT/louvre
```

Ou vous pouvez utiliser le téléchargement du code source en une archive ZIP à [cette adresse] [5] : 

Décompressez ce fichier et placez-le dans le répertoire prêt à recevoir l'application
Ouvrez votre terminal et placez-vous à la racine du projet.

Créez la base de données
------------------------

```bash
php bin/console doctrine:database:create
```
puis 
```bash
php bin/console doctrine:schema:update --force```



[1] : https://symfony.com/doc/current/best_practices/index.html
[2] : https://symfony.com/doc/current/reference/requirements.html
[3] : https://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html
[4] : https://symfony.com/download
[5] : https://github.com/EveMarieT/louvre.git
