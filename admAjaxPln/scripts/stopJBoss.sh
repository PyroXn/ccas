#!/bin/bash

#---------------------------------------------------------------------------------------------------------
# éteint le jboss sur le serveur désigné par l'ip                                                        |
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
	pid="`ssh $1 \"pgrep -f '/bin/sh /home/jboss/JbossServer/jboss/bin/run.sh'\"`"
	if [ "$pid" == "" ]
	then
		echo "le jboss est d&eacute;j&agrave; &eacute;teint"
		exit -1
	fi
	ssh $1 "rcjboss stop"
	sleep 5
	#ssh $1 "while [ \"\`pgrep -f '/bin/sh /home/jboss/JbossServer/jboss/bin/run.sh'\`\" != \"\" ]; do sleep 1 ; done"
	ssh $1 "while [ \"\`grep 'Shutdown complete' /home/jboss/JbossServer/jboss/server/default/log/server.log\`\" == \"\" ]; do sleep 1 ; done"
	echo "JBoss &eacute;teint" 
fi