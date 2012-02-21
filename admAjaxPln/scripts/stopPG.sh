#!/bin/bash

#---------------------------------------------------------------------------------------------------------
# éteint le Postgres sur le serveur désigné par l'ip                                                        |
#                                                                                                        |
#                                                                                                        |
#                                                                                                        |
#                                                                                                        |
#                                                                                                        |
#                                                                                                        |
#                                                                                                        |
#---------------------------------------------------------------------------------------------------------

if [ $# -ne 1 ]
then
	echo "usage $0 <ip>"
	exit -1
fi

echo "[`date +'%x %X'`] $0 $1 $2"

if [ "$1" == "148.110.193.168" ]; then
	echo "Pas de restart pour la 168" 
	exit -1
else 
	pid="`ssh $1 \"pgrep -f 'postmaster'\"`"
	if [ "$pid" == "" ]
	then
		echo "le Postgres est d&eacute;jà &eacute;teint"
		exit -1
	fi
	ssh $1 "rcpostgresql stop"
	sleep 5
	echo "Postgres &eacute;teint" 
fi