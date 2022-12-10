<!-- manque le php -->
<?php
try {
  require './MODELE/Gestion.php';
  $connexion = connect();
  require './CONTROLEUR/Controleur.php';
}
catch (Exception $e) {
 $msgErreur = $e->getMessage();
  require './VUE/Erreur.php';
}
?>
