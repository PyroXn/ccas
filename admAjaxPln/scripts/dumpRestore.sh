#!/bin/bash

#---------------------------------------------------------------------------------------------------------
# dump  et restaure la base en parametres                                                                |
#                                                                                                        |
#                                                                                                        |
#                                                                                                        |
#                                                                                                        |
#                                                                                                        |
#                                                                                                        |
#                                                                                                        |
#---------------------------------------------------------------------------------------------------------
if [ $# -ne 4 ]
then
	echo "usage $0 <ip source> <base source> <ip dest> <base dest>"
	exit -1
fi

echo "[`date +'%x %X'`] $0 $1 $2 $3 $4"

/mnt/extd/pgsql/bin/pg_dump -U postgres -h $1 -Fc --compress=0 $2 | /mnt/extd/pgsql/bin/pg_restore -U postgres -h $3 -Fc -O -x -d $4

#/mnt/extd/pgsql/bin/pg_dump -U postgres -h 148.110.193.168 -Fc --compress=0 prod_iftmun | /mnt/extd/pgsql/bin/pg_restore -U postgres -h 148.110.193.171 -Fc -O -x -d daily_iftmun

