
<?php
 function accueil() {
    require './VUE/Accueil.php';
}

/*Definition  du controleur frontal*/
function AffichageVue ($connexion) {
    
    if (isset($_GET['change'])){
        switch ($_GET['change']){
            case 'Gestion_eta' :
                require './VUE/listeEtablissements.php';
                break;
            case 'Attri_chambre' :
                require './VUE/ConsultationAttributions.php';
                break;
            case 'creationEtablissement' :
                require './VUE/CreationEtablissement.php';
                break;
            case 'modificationEtablissements' :
                require './VUE/ModificationEtablissement.php';
                break;
            case 'supressionEtablissements' :
                require './VUE/SuppressionEtablissement.php';
                break;
            case 'detailEtablissement':
                require './VUE/DetailEtablissement.php';
                break;
            case 'modificationAttributions' :
                require './VUE/ModificationAttributions.php';
                break;
            case 'donnerNbChambres' : 
                require './VUE/DonnerNbChambres.php';
                break;
            default : 
                throw new Exception("Action non reconnue par le contoleur");
                break;
        }
    } 
    else { 
        accueil(); 
    }
}
?>