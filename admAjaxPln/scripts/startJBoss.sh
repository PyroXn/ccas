#!/bin/bash

#---------------------------------------------------------------------------------------------------------
# allume le jboss sur le serveur désigné par l'ip                                                        |
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
	pid="`ssh $1 'pgrep -f jboss'`"
	if [ "$pid" != "" ]
	then
		echo "le jboss est d&eacute;j&agrave; allum&eacute;"
		exit -1
	fi
	ssh $1 echo "" > /home/jboss/JbossServer/jboss/server/default/log/server.log
	ssh $1 rcjboss start 
	sleep 5
	ssh $1 "while [ \"\`grep 'Started in' /home/jboss/JbossServer/jboss/server/default/log/server.log\`\" == \"\" ]; do sleep 1 ; done"
	echo "JBoss allum&eacute;" 
fi
