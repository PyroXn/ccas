<?php
/**
 * classe représentant un serveur
 *
 * @author arg
 */
class dbSystem {
	var $nom;
	var $ip;
	var $prefixe;
	var $sql_framework;
	var $sql_all;
	var $pg_restore = "/mnt/extd/pgsql/bin/pg_restore";
	var $bases;
    
    /**
     * constructeur
     * - recherche les informations de la base de données à partir de son nom
     * - recherche la liste des bases triée
     * 
     * @param type $con une connection
     * @param type $nomDB le nom de la base dans le système
     */
	function dbSystem($con, $nomDB) {
        $query = "SELECT nom, ip, prefixe, sql_framework, sql_all FROM serveur where nom='".$nomDB."'";
        $result = pg_query($con, $query) or die("<span style='color:red'/>échec de la requête : " . pg_last_error()."</span><br>\n");
        $line = pg_fetch_array($result, null, PGSQL_ASSOC);
		$this->nom = $line['nom'];
        $this->ip = $line['ip'];
        $this->prefixe = $line['prefixe'];
		$this->sql_framework = $line['sql_framework'];
		$this->sql_all = $line['sql_all'];
        
        $query = "SELECT nom, tgz, encoding FROM bases order by ordre";
		$result = pg_query($con, $query) or die("<span style='color:red'/>échec de la requête : " . pg_last_error()."</span><br>\n");
        
		while($line = pg_fetch_array($result, null)) {
			$this->bases[] = $line;
        }
	}
	
    /**
     * importe les tgz contenus dans le dossier
     * - supprime les bases
     * - créer les bases
     * - insère les données
     * - ajoute les SQL qui ont bien
     * - vaccum
     * 
     * @param type $con une connection
     * @param type $path le dossier contenant les tgz
     */
	function importTGZ($con, $path) {
		$this->dropAllDb($con);						//ok connection avec psql
		$this->createAllDb($con);					//ok connection avec psql
		$this->insertTGZ($con,$path);				//utilisation d'un sh
		$this->rajouteSQL($con);					//utilisation connect php
		
		
		
		//$this->vaccumAllDb($con);
	}

	/**
     * copie une base vers une autre
     * si c'est le même serveur création avec template
     * sinon ça passe par un tgz intermédiaire
     * 
     * @param type $con une connection
     * @param type $source la base depuis laquelle copier
     * @param type $path le dossier intermédiaire
     */
	function copie($con, $source, $path) {
		//if ($this->ip == $source->ip) {
		//	$this->dropAllDb($con);
		//	$this->createWithTemplate($con, $source);
		//	$this->rajouteSQL($con);
		//	$this->vaccumAllDb($con);		
		//} else {
		if ($this->nom != 'db_model') {
			$source->exportTGZ($con, $path);
		}
		$this->importTGZ($con, $path);	
		//}
	}
	
	/**
     * dump les bases vers un tgz
     * 
     * @param type $con une connection
     * @param type $path le dossier de destination des tgz
     */
	function exportTGZ($con, $path) {
		foreach($this->bases as $line) {
			$base = $line["nom"];
			$tgz = $line["tgz"];
            $cmd = "sudo ./scripts/dump.sh ".$this->ip." ".$path."/".$tgz." ".$this->prefixe.$base;
			execPlusAffichage($cmd);
		}
	}

	private function dropAllDb($con) {
		foreach($this->bases as $line) {
			$base = $line["nom"];
			$tgz = $line["tgz"];
			$cmd = "psql -U postgres -h '".$this->ip."' -c "."'".'DROP DATABASE IF EXISTS "'.$this->prefixe.$base.'"'."'";
			execPlusAffichage($cmd);
		}
	}
	
	private function createAllDb($con) {
		foreach($this->bases as $line) {
			$base = $line["nom"];
			$encoding = $line["encoding"];
			$cmd = "psql -U postgres -h '".$this->ip."' -c ".'" CREATE DATABASE \"'.$this->prefixe.$base.'\" WITH ENCODING = '."'".$encoding."';".'"';
			execPlusAffichage($cmd);
		}
	}
	
	private function vaccumAllDb($con) {
		foreach($this->bases as $line) {
			$base = $line["nom"];
			$encoding = $line["encoding"];
			$cmd = 'psql -U postgres -h '.$this->ip.' -d '.$this->prefixe.$base.' -c "vacuum full analyse;"';
			execPlusAffichage($cmd);
		}
	}
	
	
	/**
	* On creer la db this a partir de la $dbsystem en utilisant un template
	*
	* @param type $con 
	* @param type $dbsystem (la db a copier par template)
	*/
	private function createWithTemplate($con, $dbsystem) {
		foreach($this->bases as $line) {
            $base = $line["nom"];
			$query = 'CREATE DATABASE "'.$this->prefixe.$base.'" TEMPLATE "'.$dbsystem->prefixe.$base.'"';
			echo $query."<BR>";
			pg_query($con, $query) or die("<span style='color:red'/>échec de la requête : " . pg_last_error()."</span><br>\n");
        }
	}
	
	private function insertTGZ($con,$path) {
		foreach($this->bases as $line) {
			$base = $line["nom"];
			$tgz = $line["tgz"];
			$cmd = "sudo ./scripts/restore.sh ".$this->ip." ".$path."/".$tgz." ".$this->prefixe.$base;
			execPlusAffichage($cmd);
		}
	}
	
    /**
     * fonction qui applique les SQL qui vont bien présents dans la table des serveurs
     * 
     * @param type $con 
     */
	private function rajouteSQL($con) {
		foreach($this->bases as $line) {
			$base = $line["nom"];
			$tgz = $line["tgz"];
			if ($base == "framework" && isset($this->sql_framework) && $this->sql_framework != "") {
                echo "applique framework ".$this->nom." ".$base."<br/>";
                echo "<pre>".$this->sql_framework."</pre><br/><br/>";
                
				appliqueSql($con, $this->nom, $base, $this->sql_framework);
			}
			if (isset($this->sql_all) && $this->sql_all != "") {
                echo "applique all ".$this->nom." ".$base."<br/>";
                echo "<pre>".$this->sql_all."</pre><br/><br/>";
                
				appliqueSql($con, $this->nom, $base, $this->sql_all);
			}
		}
	}
}

?>
