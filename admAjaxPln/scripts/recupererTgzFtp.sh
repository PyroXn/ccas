#!/bin/bash

#---------------------------------------------------------------------------------------------------------
# script permettant de récuérer les tgz sur un ftp                                                       |
#                                                                                                        |
#                                                                                                        |
#                                                                                                        |
#                                                                                                        |
#                                                                                                        |
#                                                                                                        |
# EXEMPLE : ./recupereTgzFtp.sh jedi:jedi@148.110.105.80/data_prod/ ./ *.tgz /mnt/extd/base.tgz/in/      |
#---------------------------------------------------------------------------------------------------------

if [ $# -ne 4 ]
then
	echo "usage $0 <login:mdp@ip/chemin> <chemin sur le ftp (./)> <fichiers sur le ftp (*.tgz)> <out>"
	exit -1
fi

echo "[`date +'%x %X'`] $0 $1 $2 $3 $4"

ftp ftp://$1 $2 $3 << END_SCRIPT
bi
prompt
lcd $4
get iftmun.tgz
get framework.tgz
get rbac.tgz
get jbpm.tgz
get bytea.tgz
get historique.tgz
bye
exit
