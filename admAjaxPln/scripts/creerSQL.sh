#!/bin/bash
echo "$0 `date`"
workspace=$1
version=$2
ref_bug=$3
#commentaire=$4
commentaire=`echo "$4" | sed "s/:/ /g" | sed "s/\\\\/ /g" | sed "s/\\'/ /g"`
utilisateur=$5
typee=$6
application=$7
db=$8
sql=$9
user=${10}
pass=${11}

sudo ssh 148.110.193.206 "[ -e $workspace$version ] || mkdir -p --verbose $workspace$version"

sudo ssh 148.110.193.206 "cd $workspace$version/.. && svn add --parents \"prod$version\""
sudo ssh 148.110.193.206 "cd $workspace$version/../.. && svn update"

sudo ssh 148.110.193.206 "echo \"$sql\" >> \"$workspace$version/$db-$ref_bug-$commentaire.sql\""

sudo ssh 148.110.193.206 "cd $workspace$version/ && svn add --parents \"$db-$ref_bug-$commentaire.sql\""
#sudo ssh 148.110.193.206 "cd $workspace$version/ && svn commit --encoding ISO-8859-1 --username $user --password $pass -m \"$commentaire\" \"$db-$ref_bug-$commentaire.sql\""
sudo ssh 148.110.193.206 "cd $workspace$version/../../ && svn commit --encoding ISO-8859-1 --username $user --password $pass -m  \"$commentaire\" "
