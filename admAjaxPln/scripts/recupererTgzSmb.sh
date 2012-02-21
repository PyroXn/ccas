#!/bin/sh

#---------------------------------------------------------------------------------------------------------
# script permettant de recuperer les tgz sur un partage samba                                            |
#                                                                                                        |
#                                                                                                        |
#                                                                                                        |
#                                                                                                        |
#                                                                                                        |
#                                                                                                        |
# EXEMPLE : ./recupererTgzSmb.sh 148.110.193.228 pgfiles pln jupiter *.tgz /mnt/extd/base.tgz/in/        |
#---------------------------------------------------------------------------------------------------------

if [ $# -ne 6 ]
then
	echo "usage $0 <ip> <chemin sur le ftp> <login> <mdp> <fichiers sur le ftp (*.tgz)> <out>"
	exit -1
fi

echo "[`date +'%x %X'`] $0 $1 $2 $3 $4 $5 $6"

cd $6 || exit -1
smbclient //$1/$2 -U $3%$4 -c "prompt;mget $5"
