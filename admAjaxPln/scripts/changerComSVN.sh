#!/bin/bash

#---------------------------------------------------------------------------------------------------------
# permet de modifier le commentaire d'un  la machine dont l'ip est pass�e en param�tre     				 |
# - si le serveur de destination est allum� : erreur                                                     |
# - si l'ear ne se trouve pas dans le dossier en param�tre : erreur                                      |
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
COM="`echo $2 | tr '[A-Z]' '[a-z]' | sed 's/�/e/g;s/�/e/g;s/�/a/g;s/[^a-z0-9:]/ /g' | tr -s ' '`"

ssh 148.110.193.206 "svn propset --revprop -r $1 svn:log '$COM' file:///home/svnroot/trunk/"
