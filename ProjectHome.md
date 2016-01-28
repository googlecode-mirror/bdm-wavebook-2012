# Bienvenue sur le SVN du projet de BDM #

## Contexte du projet ##

En priorité, nous devrons développer un **système de reconnaissance de visage et de parole** pour qu'un utilisateur puisse s'authentifier à Wave Book. Ce site est un espace de partage communautaire et de visionnage de fichiers multimédia de tout type (vidéo, photo, musique, texte).

Les algorithmes de reconnaissance seront certainement développés en C++ (API OpenCV,...) et le site web utilisera les technologies PHP/SQL/HTML5.

La version alpha est attendu pour début novembre. Il ne faut pas perdre de temps, cela va passer très vite.

## Notre SVN ##

### Récupération des fichiers du SVN ###

Pour récupérer les fichiers courants stockés sur le svn (svn checkout) :
  * Windows: Installer un client svn (exemple: [TortoiseSVN](http://tortoisesvn.net/downloads.html) ) et faire un checkout directement en mode graphique dans votre explorateur de fichier.
  * Linux:  taper la commande suivante :
```
svn checkout https://bdm-wavebook-2012.googlecode.com/svn/trunk/ bdm-wavebook-2012  --username VOTRE_EMAIL
```

Vous aurez besoins de spécifier votre mot de passe (généré automatiquement) lors du premier commit, ce dernier se trouve dans l'**onglet Profile > Settings**.

### Organisation du SVN ###

Le SVN reprend les principaux modules du projet, à savoir:
  * Reconnaissance\_sonore
  * Reconnaissance\_faciale
  * Site\_web
  * Base\_de\_donnees

Merci de bien respecter cette arborescence pour ne pas mélanger le travail de toute les équipes.

## Liens importants ##

Ci-dessous, veuillez trouvez quelques documents intéressants pour l'organisation de l'équipe durant le développement :
  * Document sur le [Listing des fonctionnalités & Deadlines](https://docs.google.com/document/d/1z94M5koBuRT8DGv-jz8hVhOsPx4-m86ZCkQQDBOFCvs/edit)
  * Document sur la [Répartition des tâches](.md)
  * Document sur les [Notes de cours](https://docs.google.com/document/d/1YlCwnxMVAFP16r2kt_leIv53t2DhTliPUe_hM9w2f54/edit) et points clés du projet.
  * Documentation sur [OpenCV](http://opencv.willowgarage.com/wiki/)