#!/bin/bash

#---------------------------------------------------------------------------------------------------------
# copie l'ear du dossier en paramètre sur la machine dont l'ip est passée en paramètre     				 |
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
	echo "usage $0 <ip> <in>"
	exit -1
fi

echo "[`date +'%x %X'`] $0 $1 $2"

pid="`ssh $1 'pgrep -f jboss'`"
if [ "$pid" != "" ]
then
	echo "le jboss est encore allumé"
	exit -1
fi
if  [ ! -f "$2/iftgest.ear" ]
then
	echo "l'ear n'existe pas $2/iftgest.ear"
	exit -1
fi
sudo scp "$2/iftgest.ear" $1:/home/jboss/JbossServer/jboss/server/default/deploy/



