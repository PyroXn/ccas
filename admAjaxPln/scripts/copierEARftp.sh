#!/bin/bash

#---------------------------------------------------------------------------------------------------------
# script permettant de copier un fichier sur un ftp                                                      |
#                                                                                                        |
# - créer le dossier <annee>                                                                             |
# - créer le dossier <numero du patch>                                                                   |
#                                                                                                        |
#                                                                                                        |
#                                                                                                        |
# EXEMPLE: metis:metis@148.110.193.168 2011 patch6.2 "/mnt/extd/.../out/iftgest.ear" "iftgest.ear"       |
#---------------------------------------------------------------------------------------------------------

if [ $# -ne 5 ]
then
	echo "usage $0 <login:mdp@ip/chemin> <annee> <numero du patch> <path du fichier en local> <nom du fichier distant sans path>"
	exit -1
fi

echo "$0 `date`"
ftp ftp://$1 << END_SCRIPT
mkdir $2
cd $2
mkdir $3
cd $3
put $4 $5
bye
exit
help
