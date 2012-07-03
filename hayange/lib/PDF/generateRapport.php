<?php
    $mois = date("F");
    switch ($mois) {
        case 'January': $mois = 'Janvier'; break;
        case 'February': $mois = 'Février'; break;
        case 'March': $mois = 'Mars'; break;
        case 'April': $mois = 'Avril'; break;
        case 'May': $mois = 'Mai'; break;
        case 'June': $mois = 'Juin'; break;
        case 'July': $mois = 'Juillet'; break;
        case 'August': $mois = 'Août'; break;
        case 'September': $mois = 'Septembre'; break;
        case 'October': $mois = 'Octobre'; break;
        case 'November': $mois = 'Novembre'; break;
        case 'December': $mois = 'Decembre'; break;
        default: $mois =''; break;
    }
    ob_start();
    include(dirname(__FILE__).'/pageRapport.php');
    $content = ob_get_clean();	
    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output($chemin.'/'.$individu->id.'/RapportSocial_'.$idAide.'.pdf', 'F');
?>
