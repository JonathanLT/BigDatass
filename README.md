# BigDatass

## Présentation
À partir du framework PHP Symfony2, mettre en place une application permettant de la recherche à partir de mot clé qui nous retournerais un top des derniers tweets (>24h) avec liens sur l'utilisateurs et alimentation d'une base de donnée non-relationnelle à partir des données retournées pour faire dans un second temps du reporting sur l'ensemble des recherches (partie optionnel).

## Installation du projet
- Mettre le dépot git dans le dossier `/var/www/`
- Éxécuter `cd /var/www/BigDatass/bigdatass` dans le dossier de Symfony2
- Télécharger [composer.phar](https://getcomposer.org/composer.phar)
- Éxécuter `php composer.phar update`
- Télécharger [Datumbox_APIclient_PHP_1.0.zip](http://www.datumbox.com/files/Datumbox_APIclient_PHP_1.0.zip) et le placer son contenu dans `vendor/datumboxapi`
- Éxécuter `chmod -R 777 app/cache/ app/logs/` pour que les dossiers soit totalement accessible pour Symfony2
- Let's go !

## Équipe de développement pour ce projet
- [Allisson CROS](cros_a@etna-alternance.net)
- [Raphael DEBRAY](debray_r@etna-alternance.net)
- [Jonathan LOQUET](loquet_j@etna-alternance.net)
- [Fangyi LUO](luo_f@etna-alternance.net)
