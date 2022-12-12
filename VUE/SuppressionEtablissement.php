<?php 
    $title = 'Festival -  Supprimer Etablissement'; 
?> 
<?php ob_start() ?>
<?php
$id=$_REQUEST['id'];  
$lgEtab=obtenirDetailEtablissement($connexion, $id);
$nom=$lgEtab['nom'];

// Cas 1ère étape (on vient de index.php?change=listeEtablissements)

if ($_REQUEST['modif']=='demanderSupprEtab')    
{
   echo "
   <br><center><h5>Souhaitez-vous vraiment supprimer l'établissement $nom ? 
   <br><br>
   <a href='index.php?change=supressionEtablissements&amp;modif=validerSupprEtab&amp;id=$id'>
   Oui</a>&nbsp; &nbsp; &nbsp; &nbsp;
   <a href='index.php?change=listeEtablissements'>Non</a></h5></center>";
}

// Cas 2ème étape (on vient de suppressionEtablissement.php)

else if ($_REQUEST['modif']=='validerSupprEtab')
{
   supprimerEtablissement($connexion, $id);
   echo "
   <br><br><center><h5>L'établissement $nom a été supprimé</h5>
   <a href='index.php?change=listeEtablissements'>Retour</a></center>";
}
?>
<?php $contenu = ob_get_clean();
 require './VUE/Template.php'; ?>
<?= $contenu ?>