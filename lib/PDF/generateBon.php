<?php

    ob_start();
    include(dirname(__FILE__).'/pageBon.php');
    $content = ob_get_clean();

    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output($chemin.'/'.$idAide.'/'.$numBon.'.pdf', 'F');
?>