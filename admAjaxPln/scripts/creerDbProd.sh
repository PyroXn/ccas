#!/bin/bash
echo "$0 `date`"
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
