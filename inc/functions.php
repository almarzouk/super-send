<?php 

function date_outil($date,$nombre_jour) {
 
    $year = substr($date, 0, -6);   
    $month = substr($date, -5, -3);   
    $day = substr($date, -2);   
 
    // récupère la date du jour
    $date_string = mktime(0,0,0,$month,$day,$year);
 
    // Supprime les jours
    $timestamp = $date_string + ($nombre_jour * 86400);
    $nouvelle_date = date("Y-m-d", $timestamp); 
 
    // pour afficher
   return $nouvelle_date;
 
    }
	
function mail_alerte($to,$nom_objet,$date_restitution)
{
	
$subject = 'Relance concerant prêt de matériel SUPER - délai dépassé';
$message = '<p>Bonjour, vous avez emprunté du matériel photo '.$nom_objet.' au site "Super".<br />La date de restitution programmée était le $date_restitution.<br />Merci de bien vouloir restituer le matériel dans les plus brefs délais.<br />Cordialement</p><p>Webmaster du site Super</p>';

$headers = 'From: webmaster@super.com' . "\r\n" .
    'Reply-To: webmaster@super.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);


}


$rep_default = "/super";
$url_standard = "http://" . $_SERVER['HTTP_HOST'] . $rep_default;
// echo $url_standard;
