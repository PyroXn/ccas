<?php
	
/*
 * connection à la base d'administration
 */
$db_admin_host 			= "148.110.193.168";			// Adresse de la db d'administration
$db_admin_name 			= "administration2";				// Nom de la db d'administration
$db_admin_user 			= "postgres";					// user pour db administration
$db_admin_pass 			= "postgres";					// pass pour db administration
	
/*
 * compilation d'un EAR de prod
*/
$ip_compilateur_prod	= "148.110.193.198";
$workspace_prod 		= "workspace-prod6";
$out_prod				= "/mnt/extd/base-prod6.tgz/out";

/*
compilation d'un EAR de dev
*/
$ip_compilateur_dev	= "148.110.193.206";
$workspace_dev 		= "workspace";
$out_dev			= "/mnt/extd/base.tgz/out";

/*
serveurs jboss
*/
$proddev			= "148.110.193.198";

/*
ftp 
*/
$ftp_ear			= "metis:metis@148.110.193.168";

/*
tgz
*/
$ip_tgz 			= "148.110.193.228";
$path_tgz 			= "pgfiles";
$login_tgz 			= "pln";
$mdp_tgz 			= "jupiter";
$dest_tgz			= "/mnt/extd/base.tgz/in";
$dest_tgz_tmp			= "/mnt/extd/base.tgz/tmp";

/*
 * base de prod
 */
$db_prod_base       = "db_prod";

/*
 * base model
 */
$db_model_base       = "db_model";

/*
 * base dev
 */
$db_dev_base       = "db_dev";
?>