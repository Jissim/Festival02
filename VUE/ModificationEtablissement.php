<?php 
    $title = 'Festival -  Modifier Etablissement'; 
?> 
<?php ob_start() ?>
<?php

// Déclaration du tableau des civilités
$tabCivilite=["M.","Mme","Melle"];  
$modif=$_REQUEST['modif'];
//$action=$_REQUEST['action']; inutile
$id=$_REQUEST['id'];

// Si on ne "vient" pas de ce formulaire, il faut récupérer les données à partir 
// de la base (en appelant la fonction obtenirDetailEtablissement) sinon on 
// affiche les valeurs précédemment contenues dans le formulaire
if ($modif=='demanderModifEtab')
{
   $lgEtab=obtenirDetailEtablissement($connexion, $id);
  
   $nom=$lgEtab['nom'];
   $adresseRue=$lgEtab['adresseRue'];
   $codePostal=$lgEtab['codePostal'];
   $ville=$lgEtab['ville'];
   $tel=$lgEtab['tel'];
   $adresseElectronique=$lgEtab['adresseElectronique'];
   $type=$lgEtab['typeEtablissement'];
   $civiliteResponsable=$lgEtab['civiliteResponsable'];
   $nomResponsable=$lgEtab['nomResponsable'];
   $prenomResponsable=$lgEtab['prenomResponsable'];
   $nombreChambresOffertes=$lgEtab['nombreChambresOffertes'];
}
else
{
   $nom=$_REQUEST['nom']; 
   $adresseRue=$_REQUEST['adresseRue'];
   $codePostal=$_REQUEST['codePostal'];
   $ville=$_REQUEST['ville'];
   $tel=$_REQUEST['tel'];
   $adresseElectronique=$_REQUEST['adresseElectronique'];
   $type=$_REQUEST['type'];
   $civiliteResponsable=$_REQUEST['civiliteResponsable'];
   $nomResponsable=$_REQUEST['nomResponsable'];
   $prenomResponsable=$_REQUEST['prenomResponsable'];
   $nombreChambresOffertes=$_REQUEST['nombreChambresOffertes'];

   verifierDonneesEtabM($connexion, $id, $nom, $adresseRue, $codePostal, $ville,  
                        $tel, $nomResponsable, $nombreChambresOffertes);      
   if (nbErreurs()==0)
   {        
      modifierEtablissement($connexion, $id, $nom, $adresseRue, $codePostal, $ville, 
                            $tel, $adresseElectronique, $type, $civiliteResponsable, 
                            $nomResponsable, $prenomResponsable, $nombreChambresOffertes);
   }
}

echo "
<form method='POST' action='index.php?&action=modificationEtablissements'>
   <input type='hidden' value='validerModifEtab' name='modif'>
   <table width='85%' cellspacing='0' cellpadding='0' align='center' 
   class='tabNonQuadrille'>
   
      <tr class='enTeteTabNonQuad'>
         <td colspan='3'>$nom ($id)</td>
      </tr>
      <tr>
         <td><input type='hidden' value='$id' name='id'></td>
      </tr>";
      
      echo '
      <tr class="ligneTabNonQuad">
         <td> Nom*: </td>
         <td><input type="text" value="'.$nom.'" name="nom" size="50" 
         maxlength="45"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Adresse*: </td>
         <td><input type="text" value="'.$adresseRue.'" name="adresseRue" 
         size="50" maxlength="45"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Code postal*: </td>
         <td><input type="text" value="'.$codePostal.'" name="codePostal" 
         size="4" maxlength="5"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Ville*: </td>
         <td><input type="text" value="'.$ville.'" name="ville" size="40" 
         maxlength="35"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Téléphone*: </td>
         <td><input type="text" value="'.$tel.'" name="tel" size ="20" 
         maxlength="10"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> E-mail: </td>
         <td><input type="text" value="'.$adresseElectronique.'" name=
         "adresseElectronique" size ="75" maxlength="70"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Type*: </td>
         <td>';
            if ($type==1)
            {
               echo " 
               <input type='radio' name='type' value='1' checked>  
               Etablissement Scolaire
               <input type='radio' name='type' value='0'>  Autre";
             }
             else
             {
                echo " 
                <input type='radio' name='type' value='1'> 
                Etablissement Scolaire
                <input type='radio' name='type' value='0' checked> Autre";
              }
           echo "
           </td>
         </tr>
         <tr class='ligneTabNonQuad'>
            <td colspan='2' ><strong>Responsable:</strong></td>
         </tr>
         <tr class='ligneTabNonQuad'>
            <td> Civilité*: </td>
            <td> <select name='civiliteResponsable'>";
               for ($i=0; $i<3; $i=$i+1)
                  if ($tabCivilite[$i]==$civiliteResponsable) 
                  {
                     echo "<option selected>$tabCivilite[$i]</option>";
                  }
                  else
                  {
                     echo "<option>$tabCivilite[$i]</option>";
                  }
               echo '
               </select>&nbsp; &nbsp; &nbsp; Nom*: 
               <input type="text" value="'.$nomResponsable.'" name=
               "nomResponsable" size="26" maxlength="25">
               &nbsp; &nbsp; &nbsp; Prénom: 
               <input type="text"  value="'.$prenomResponsable.'" name=
               "prenomResponsable" size="26" maxlength="25">
            </td>
         </tr>
         <tr class="ligneTabNonQuad">
            <td> Nombre chambres offertes*: </td>
            <td><input type="text" value="'.$nombreChambresOffertes.'" name=
            "nombreChambresOffertes" size ="2" maxlength="3"></td>
         </tr>
   </table>';
   
   echo "
   <table align='center' cellspacing='15' cellpadding='0'>
      <tr>
         <td align='right'><input type='submit' value='Valider' name='valider'>
         </td>
         <td align='left'><input type='reset' value='Annuler' name='annuler'>
         </td>
      </tr>
      <tr>
         <td colspan='2' align='center'><a href='index.php?action=listeEtablissements'>Retour</a>
         </td>
      </tr>
   </table>
  
</form>";

// En cas de validation du formulaire : affichage des erreurs ou du message de 
// confirmation
if ($modif=='validerModifEtab')
{
   if (nbErreurs()!=0)
   {
      afficherErreurs();
   }
   else
   {
      echo "
      <h5><center>La modification de l'établissement a été effectuée</center></h5>";
   }
}

?>
<?php $contenu = ob_get_clean(); 
 require './VUE/Template.php'; ?>
<?= $contenu ?>