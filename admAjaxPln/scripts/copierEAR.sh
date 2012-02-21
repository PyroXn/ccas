#!/bin/bash

#---------------------------------------------------------------------------------------------------------
# copie l'ear du dossier en param�tre sur la machine dont l'ip est pass�e en param�tre     				 |
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
	echo "usage $0 <ip> <in>"
	exit -1
fi

echo "[`date +'%x %X'`] $0 $1 $2"

pid="`ssh $1 'pgrep -f jboss'`"
if [ "$pid" != "" ]
then
	echo "le jboss est encore allum�"
	exit -1
fi
if  [ ! -f "$2/iftgest.ear" ]
then
	echo "l'ear n'existe pas $2/iftgest.ear"
	exit -1
fi
sudo scp "$2/iftgest.ear" $1:/home/jboss/JbossServer/jboss/server/default/deploy/



