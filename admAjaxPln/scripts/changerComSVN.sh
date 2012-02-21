#!/bin/bash

#---------------------------------------------------------------------------------------------------------
# permet de modifier le commentaire d'un  la machine dont l'ip est passée en paramètre     				 |
# - si le serveur de destination est allumé : erreur                                                     |
# - si l'ear ne se trouve pas dans le dossier en paramètre : erreur                                      |
#                                                                                                        |
#                                                                                                        |
#                                                                                                        |
#                                                                                                        |
#                                                                                                        |
#---------------------------------------------------------------------------------------------------------
if [ $# -ne 2 ]
then
	echo "usage $0 <revision> <commentaire>"
	exit -1
fi

echo "[`date +'%x %X'`] $0 $1 $2"
COM="`echo $2 | tr '[A-Z]' '[a-z]' | sed 's/é/e/g;s/è/e/g;s/à/a/g;s/[^a-z0-9:]/ /g' | tr -s ' '`"

ssh 148.110.193.206 "svn propset --revprop -r $1 svn:log '$COM' file:///home/svnroot/trunk/"
