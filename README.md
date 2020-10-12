# devops-datis-01

Application Symfony 4 déployée sur Heroku
-

**Prod** : https://iim-symfony-2018.herokuapp.com/home/1 <br />

**Pre-prod** : https://iim-symfony-2018-preprod.herokuapp.com/home/1

Le workflow comporte 4 steps :

* actions/checkout@v2
*permet au workflow d'accéder à notre repo GitHub*

* symfonycorp/security-checker-action@v2
*vérifie si le composer.lock ne contient pas de vulnérabilités connues dans ses dépendences (check de sécurité)*

* michaelw90/PHP-Lint@master
*linter PHP*

* akhileshns/heroku-deploy@v3.5.7
*déploie automatiquement notre app sur Heroku*

Ces steps se déclenchent automatiquement à l'action spécifiée dans le workflow (on: push: ..)

Pour la config Heroku: 

 - Créer un fichier Procfile à la racine du projet, afin d'indiquer à Heroku quelle commande utiliser pour correctement lancer le serveur: 
 ```term
echo 'web: heroku-php-apache2 public/' > Procfile
```
- Ajouter les variables d'environnement Symfony (APP_ENV, DATABASE_URL) dans *Settings -> Config Vars*

