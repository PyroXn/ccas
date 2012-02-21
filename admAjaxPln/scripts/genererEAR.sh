#!/bin/bash

#---------------------------------------------------------------------------------------------------------
# génère l'ear sur la machine dont l'ip est passée en paramètre et le copie dans le dossier de sortie    |
#																									     |
# - va dans le dossier /home/dailybuild/<workspace>/ClientWebIftmunJnlp							     	 |
# - fait un "ant deployonly" qui génère l'ear et le copie sur le JBoss de la machine					 |
# - copie l'ear sur le dossier en paramètre							   									 |
#							     																		 |
# exemple DAILY BULD ./genererEAR.sh 148.110.193.206 workspace /mnt/extd/base.tgz/out 					 |
# exemple PROD 6     ./genererEAR.sh 148.110.193.198 workspace-prod6 /mnt/extd/base-prod6.tgz/out 	     |
#---------------------------------------------------------------------------------------------------------
if [ $# -ne 3 ]
then
	echo "usage $0 <ip> <workspace> <out>"
	exit -1
fi

echo "[`date +'%x %X'`] $0 $1 $2 $3"

mkdir -p "$3"
ssh $1 "(cd /home/dailybuild/$2/ClientWebIftmunJnlp && ant deployonly) || (echo \"erreur DeployOnly sur $1\" && exit -1)" || exit -1
scp $1:/home/jboss/JbossServer/jboss/server/default/deploy/iftgest.ear "$3"
