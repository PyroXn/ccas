#!/bin/bash

#---------------------------------------------------------------------------------------------------------
# dump la base en parametres et la met en tgz dans le dossier de destination en parametre 				 |
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

/mnt/extd/pgsql/bin/pg_dump -U postgres -h $1 -F c -f $2 $3

#-Z 0