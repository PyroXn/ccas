#!/bin/bash

#---------------------------------------------------------------------------------------------------------
# affiche le log l'ear sur la machine dont l'ip est passée en paramètre                                  |
#																									     |
# 																								     	 |
#                                                                                   					 |
#                                               		   				                				 |
#							     																		 |
#                                                                                     					 |
#                                                                                                 	     |
#---------------------------------------------------------------------------------------------------------
if [ $# -ne 2 ]
then
	echo "usage $0 <ip> <workspace> "
	exit -1
fi

echo "[`date +'%x %X'`] $0 $1 $2 $3"

ssh $1 cat "/home/dailybuild/$2/ClientWebIftmunJnlp/log/buildlog.log"
