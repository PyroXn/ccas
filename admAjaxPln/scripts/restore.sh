#!/bin/bash

#---------------------------------------------------------------------------------------------------------
# restaure la base a partir des tgz dans le dossier source                                               |
#                                                                                                        |
#                                                                                                        |
#                                                                                                        |
#                                                                                                        |
#                                                                                                        |
#                                                                                                        |
#                                                                                                        |
#---------------------------------------------------------------------------------------------------------
if [ $# -ne 3 ]
then
	echo "usage $0 <ip> <tgz> <base>"
	exit -1
fi

echo "[`date +'%x %X'`] $0 $1 $2 $3"

/mnt/extd/pgsql/bin/pg_restore -U postgres -h $1 -d $3 $2

#--jobs=2 -Fc -O -x -d