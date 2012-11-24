#!/bin/bash
#auteur:Jacques
#date derniere modif:24/11/12
#paramètre:
#resultat:

baseDir=../Base_de_donnees/upload/

for folders in `ls ${baseDir}` ; do
    typeset -i id=${folders}
    for images in `ls ${baseDir}${folders}` ; do
	if [ -f ${baseDir}${folders}/${images} ] ; then
	    make run ARG=2 IMG=${baseDir}${folders}/${images} ID=${id}
	fi;
    done;
done;
