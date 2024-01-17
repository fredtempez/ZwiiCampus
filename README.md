# ZwiiCampus 1.4.07

ZwiiCampus (Learning Management System) est logiciel auteur destiné à mettre en ligne des tutoriels. Il dispose de plusieurs modalités d'ouverture et d'accès des contenus. Basé sur la version 13 du CMS Zwii, la structure logicielle est solide, le framework de Zwii est éprouvé.


## Configuration recommandée

* PHP 7.2 ou plus
* Support de .htaccess

## Licence

Cette œuvre est mise à disposition sous licence Attribution - Pas d'utilisation Commerciale - Pas de Modification 4.0 International. 

Pour voir une copie de cette licence, visitez http://creativecommons.org/licenses/by-nc-nd/4.0/ ou écrivez à Creative Commons, PO Box 1866, Mountain View, CA 94042, USA.


## Installation

Décompressez l'archive de Zwii et téléversez son contenu à la racine de votre serveur ou dans un sous-répertoire. C'est tout !

Vous trouverez de plus amples explications, en particulier pour une installation chez Free, dans la rubrique "Téléchargements" du forum.


## Procédures de mise à jour

A l'occasion de l'installation d'une version majeure, il est recommandé de réaliser une copie de sauvegarde.

### Automatique

* Connectez-vous à votre site.
* Si une mise à jour est disponible, elle vous est proposée dans la barre d'administration.
* Cliquez sur le bouton "Mettre à jour".

### Manuelle

* Sauvegardez l'intégralité de votre site, spécialement le répertoire "site".
* Décompressez la nouvelle version sur votre ordinateur.
* Transférez son contenu sur votre serveur en activant le remplacement des fichiers.


## Arborescence générale

*Légende : [R] Répertoire - [F] Fichier*

```text
[R] core                   Cœur du système
  [R] class                Classes
  [R] layout               Mise en page
  [R] module               Modules du cœur
  [R] vendor               Librairies extérieures
  [F] core.js.php          Cœur javascript
  [F] core.php             Cœur PHP

[R] module                 Modules de page
  [R] blog                 Blog
  [R] form                 Gestionnaire de formulaires
  [R] gallery              Galerie
  [R] news                 Nouvelles
  [R] redirection          Redirection

[R] site                   Contenu du site
  [R] backup               Sauvegardes automatiques
  [R] i18N                 Langues de l'interface de Zwii
  [R] data                 Répertoire des données
    [R] home               Dossier contenant les pages du site d'accueil
      [F] page.json        Données des pages
      [F] module.json      Données des modules de pages
      [F] theme.css        Thème de ce contenu
      [F] theme.json       Thème de ce contenu
      [R] content          Dossier des contenus de page
        [F] accueil.html   Exemple contenu de la page d'accueil
    [R] fonts              Dossier contenant les fontes installées
      [F] font.html       Fichier contenant les appels des fontes à charger sur cdnFonts
      [F] fonts.css        Fichier contenant la feuille de style liée aux polices de caractères locales
      [F] fontes.woff      Fichiers locaux des fontes (woff, etc..)
    [R] xxxxxxx            Dossiers des données de chaque contenu
    [R] modules            Personnalisation des modules ou données propres
    [F] admin.css          Thème des pages d'administration
    [F] admin.json         Données de thème des pages d'administration
    [F] blacklist.json     Journalisation des tentatives de connexion avec des comptes inconnus
    [F] category.json      Données des catégories de contenus
    [F] config.json        Configuration du site
    [F] core.json          Configuration du noyau
    [F] course.json        Données de contenus
    [F] custom.css         Feuille de style de la personnalisation avancée
    [F] enrolment.json     Données des inscriptions et des statistiques par contenu
    [F] font.json          Descripteur des fontes personnalisées
    [F] journal.log        Journalisation des activités
    [F] language.json      Langues de l'interface
    [F] profil.json        Profils des utilisateurs
    [F] user.json          Données des utilisateurs
    [F] .backup            Marqueur de la sauvegarde des fichiers si présent
  [R] file                 Répertoire d'upload du gestionnaire de fichiers
    [R] source             Ressources diverses
    [R] thumb              Miniatures des images
  [R] tmp                  Répertoire temporaire

[F] index.php              Fichier d'initialisation de ZwiiCampus
[F] robots.txt             Filtrage des répertoires accessibles aux robots des moteurs de recherche
[F] sitemap.xml            Plan du site
[F] sitemap.xml.gz         Version compressée

Le fichiers .htaccess contribuent à la sécurité en filtrant l'accès aux répertoires sensibles.

```
