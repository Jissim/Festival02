<?php

// FONCTIONS DE CONNEXION
// utilisation de la methode pdo 

function getConnexion()
{
   $connexion = connect();
   if (!$connexion) {
      ajouterErreur("Echec de la connexion au serveur MySql");
      afficherErreurs();
      exit();
   }
   if (!selectBase($connexion)) {
      ajouterErreur("La base de données festival est inexistante ou non accessible");
      afficherErreurs();
      exit();
   }
   return $connexion;
}

function connect()
{
    $dbh = new PDO('mysql:host=localhost;dbname=festival;charset=utf8',
    'festival','123456',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  return $dbh;
}
// {
//    $user="root";
//    $pass="root";
//    $dsn = 'mysql:host=localhost;dbname=festival';
//    $dbh= new PDO($dsn, $user, $pass); 
//    return $dbh;
// }

/*function connect()
{
   $hote="localhost";
   $login="festival";
   $mdp="secret";
   return mysql_connect($hote, $login, $mdp);
}*/

function selectBase($connexion) 
{
   $bd="festival"; //anciennement abdelfest 
   $query="SET CHARACTER SET utf8";
   // Modification du jeu de caractères de la connexion
   // $res=mysql_query($query, $connexion); 
   // $res=connect()->query($query);
   // $ok=mysql_select_db($bd, $connexion);
   $ok= $connexion->query($query);
   return $ok;
}

// FONCTIONS DE GESTION DES ÉTABLISSEMENTS

// on adapte les requetes 

function obtenirReqEtablissements()
{
   $sql="SELECT id, nom 
   from Etablissement 
   order by id";
   return $sql;
}

/*function obtenirReqEtablissements()
{
   $req="select id, nom from Etablissement order by id";
   return $req;
}*/

function obtenirReqEtablissementsOffrantChambres()
{
   $sql="SELECT id, nom, nombreChambresOffertes 
   from Etablissement 
   where nombreChambresOffertes!=0 
   order by id";
   return $sql;
}

function obtenirReqEtablissementsAyantChambresAttribuées()
{
   $sql="SELECT distinct id, nom, nombreChambresOffertes 
   from Etablissement, Attribution 
   where id = idEtab 
   order by id";
   return $sql;
}

function obtenirDetailEtablissement($connexion, $id)
{
   $sql="SELECT * 
   from Etablissement 
   where id='$id'";
   // $rsEtab=mysql_query($req, $connexion);
   $rsEtab=$connexion->query($sql);
   // return mysql_fetch_array($rsEtab);
   return $rsEtab->fetch(PDO::FETCH_ASSOC);
}

function supprimerEtablissement($connexion, $id)
{
   $sql="DELETE 
   from Etablissement 
   where id='$id'";
   return $connexion->query($sql); // manque le return
}
 
function modifierEtablissement($connexion, $id, $nom, $adresseRue, $codePostal, 
                               $ville, $tel, $adresseElectronique, $type, 
                               $civiliteResponsable, $nomResponsable, 
                               $prenomResponsable, $nombreChambresOffertes)
{  
   $nom=str_replace("'", "''", $nom);
   $adresseRue=str_replace("'","''", $adresseRue);
   $ville=str_replace("'","''", $ville);
   $adresseElectronique=str_replace("'","''", $adresseElectronique);
   $nomResponsable=str_replace("'","''", $nomResponsable);
   $prenomResponsable=str_replace("'","''", $prenomResponsable);
  
   $sql="update Etablissement set nom='$nom',adresseRue='$adresseRue',
         codePostal='$codePostal',ville='$ville',tel='$tel',
         adresseElectronique='$adresseElectronique',type='$type',
         civiliteResponsable='$civiliteResponsable',nomResponsable=
         '$nomResponsable',prenomResponsable='$prenomResponsable',
         nombreChambresOffertes='$nombreChambresOffertes' where id='$id'";
   
   // mysql_query($req, $connexion);
   $connexion->query($sql);
}

function creerEtablissement($connexion, $id, $nom, $adresseRue, $codePostal, 
                            $ville, $tel, $adresseElectronique, $type, 
                            $civiliteResponsable, $nomResponsable, 
                            $prenomResponsable, $nombreChambresOffertes)
{ 
   $nom=str_replace("'", "''", $nom);
   $adresseRue=str_replace("'","''", $adresseRue);
   $ville=str_replace("'","''", $ville);
   $adresseElectronique=str_replace("'","''", $adresseElectronique);
   $nomResponsable=str_replace("'","''", $nomResponsable);
   $prenomResponsable=str_replace("'","''", $prenomResponsable);
   
   $sql="insert into Etablissement values ('$id', '$nom', '$adresseRue', 
         '$codePostal', '$ville', '$tel', '$adresseElectronique', '$type', 
         '$civiliteResponsable', '$nomResponsable', '$prenomResponsable',
         '$nombreChambresOffertes')";
   
   // mysql_query($req, $connexion);
   $connexion->query($sql);
}


function estUnIdEtablissement($connexion, $id)
{
   $sql="select * from Etablissement where id='$id'";
   // $rsEtab=mysql_query($req, $connexion);
   $rsEtab=$connexion->query($sql);
   // return mysql_fetch_array($rsEtab);
   return $rsEtab->fetch(PDO::FETCH_ASSOC);
}

function estUnNomEtablissement($connexion, $mode, $id, $nom)
{
   $nom=str_replace("'", "''", $nom);
   // S'il s'agit d'une création, on vérifie juste la non existence du nom sinon
   // on vérifie la non existence d'un autre établissement (id!='$id') portant 
   // le même nom
   if ($mode=='C')
   {
      $sql="select * from Etablissement where nom='$nom'";
   }
   else
   {
      $sql="select * from Etablissement where nom='$nom' and id!='$id'";
   }
   // $rsEtab=mysql_query($req, $connexion);
   $rsEtab=$connexion->query($sql);
   // return mysql_fetch_array($rsEtab);
   return $rsEtab->fetch(PDO::FETCH_ASSOC);
}

function obtenirNbEtab($connexion)
{
   $sql="select count(*) as nombreEtab from Etablissement";
   // $rsEtab=mysql_query($req, $connexion);
   $rsEtab=$connexion->query($sql);
   // $lgEtab=mysql_fetch_array($rsEtab);
   $lgEtab=$rsEtab->fetch(pdo::FETCH_ASSOC);
   return $lgEtab["nombreEtab"];
}

function obtenirNbEtabOffrantChambres($connexion)
{
   $sql="select count(*) as nombreEtabOffrantChambres from Etablissement where 
         nombreChambresOffertes!=0";
   // $rsEtabOffrantChambres=mysql_query($req, $connexion);
   $rsEtabOffrantChambres=$connexion->query($sql);
   // $lgEtabOffrantChambres=mysql_fetch_array($rsEtabOffrantChambres);
   $lgEtabOffrantChambres=$rsEtabOffrantChambres->fetch(pdo::FETCH_ASSOC);
   return $lgEtabOffrantChambres["nombreEtabOffrantChambres"];
}

// Retourne false si le nombre de chambres transmis est inférieur au nombre de 
// chambres occupées pour l'établissement transmis 
// Retourne true dans le cas contraire
function estModifOffreCorrecte($connexion, $idEtab, $nombreChambres)
{
   $nbOccup=obtenirNbOccup($connexion, $idEtab);
   return ($nombreChambres>=$nbOccup);
}

// FONCTIONS RELATIVES AUX GROUPES

function obtenirReqIdNomGroupesAHeberger()
{
   $sql="SELECT id, nom 
   from Groupe 
   where hebergement='O' 
   order by id";
   return $sql;
}

function obtenirNomGroupe($connexion, $id)
{
   $sql="select nom from Groupe where id='$id'";
   // $rsGroupe=mysql_query($req, $connexion);
   $rsGroupe=$connexion->query($sql);
   // $lgGroupe=mysql_fetch_array($rsGroupe);
   $lgGroupe=$rsGroupe->fetch(pdo::FETCH_ASSOC);
   return $lgGroupe["nom"];
}

// FONCTIONS RELATIVES AUX ATTRIBUTIONS

// Teste la présence d'attributions pour l'établissement transmis    
function existeAttributionsEtab($connexion, $id)
{
   $sql="SELECT * 
   From Attribution 
   where idEtab ='$id'";
   // $rsAttrib=mysql_query($req, $connexion);
   $rsAtrrib=$connexion->query($sql); 
   // return mysql_fetch_array($rsAttrib);
   return $rsAtrrib->fetch(PDO::FETCH_ASSOC);
}

/*function existeAttributionsEtab($connexion, $id)
{
   $req="select * From Attribution where idEtab='$id'";
   $rsAttrib=mysql_query($req, $connexion);
   return mysql_fetch_array($rsAttrib);
}
*/

// Retourne le nombre de chambres occupées pour l'id étab transmis
function obtenirNbOccup($connexion, $idEtab)
{
   $sql="select IFNULL(sum(nombreChambres), 0) as totalChambresOccup from
        Attribution where idEtab='$idEtab'";
   // $rsOccup=mysql_query($req, $connexion);
   $rsOccup=$connexion->query($sql);
   // $lgOccup=mysql_fetch_array($rsOccup);
   $lgOccup=$rsOccup->fetch(pdo::FETCH_ASSOC);
   return $lgOccup["totalChambresOccup"];
}

// Met à jour (suppression, modification ou ajout) l'attribution correspondant à
// l'id étab et à l'id groupe transmis
function modifierAttribChamb($connexion, $idEtab, $idGroupe, $nbChambres)
{
   $sql="select count(*) as nombreAttribGroupe from Attribution where idEtab=
        '$idEtab' and idGroupe='$idGroupe'";
   // $rsAttrib=mysql_query($req, $connexion);
   $rsAttrib=$connexion->query($sql);
   // $lgAttrib=mysql_fetch_array($rsAttrib);
   $lgAttrib=$rsAttrib->fetch(pdo::FETCH_ASSOC);

   if ($nbChambres==0)
      $sql="delete from Attribution where idEtab='$idEtab' and idGroupe='$idGroupe'";
   else
   {
      if ($lgAttrib["nombreAttribGroupe"]!=0)
         $sql="update Attribution set nombreChambres=$nbChambres where idEtab=
              '$idEtab' and idGroupe='$idGroupe'";
      else
         $sql="insert into Attribution values('$idEtab','$idGroupe', $nbChambres)";
   }
   // mysql_query($req, $connexion);
   $connexion->query($sql);
}

// Retourne la requête permettant d'obtenir les id et noms des groupes affectés
// dans l'établissement transmis
function obtenirReqGroupesEtab($id)
{
   $sql="select distinct id, nom from Groupe, Attribution where 
        Attribution.idGroupe=Groupe.id and idEtab='$id'";
   return $sql;
}
            
// Retourne le nombre de chambres occupées par le groupe transmis pour l'id étab
// et l'id groupe transmis
function obtenirNbOccupGroupe($connexion, $idEtab, $idGroupe)
{
   $sql="select nombreChambres From Attribution where idEtab='$idEtab'
        and idGroupe='$idGroupe'";
   // $rsAttribGroupe=mysql_query($req, $connexion);
   $rsAttribGroupe=$connexion->query($sql);
   // if ($lgAttribGroupe=mysql_fetch_array($rsAttribGroupe))
   if ($lgAttribGroupe=$rsAttribGroupe->fetch(PDO::FETCH_ASSOC))
      return $lgAttribGroupe["nombreChambres"];
   else
      return 0;
}

// FONCTIONS DE CONTRÔLE DE SAISIE

// Si $codePostal a une longueur de 5 caractères et est de type entier, on 
// considère qu'il s'agit d'un code postal
function estUnCp($codePostal)
{
   // Le code postal doit comporter 5 chiffres
   return strlen($codePostal)== 5 && estEntier($codePostal);
}

// Si la valeur transmise ne contient pas d'autres caractères que des chiffres, 
// la fonction retourne vrai
function estEntier($valeur)
{
   // return !ereg("[^0-9]", $valeur);
   return !preg_match("%[^0-9]%", $valeur);
}

// Si la valeur transmise ne contient pas d'autres caractères que des chiffres  
// et des lettres non accentuées, la fonction retourne vrai
function estChiffresOuEtLettres($valeur)
{
   // return !ereg("[^a-zA-Z0-9]", $valeur);
   return !preg_match("%[^a-zA-Z0-9]%", $valeur);
}

// Fonction qui vérifie la saisie lors de la modification d'un établissement. 
// Pour chaque champ non valide, un message est ajouté à la liste des erreurs
function verifierDonneesEtabM($connexion, $id, $nom, $adresseRue, $codePostal, 
                              $ville, $tel, $nomResponsable, $nombreChambresOffertes)
{
   if ($nom=="" || $adresseRue=="" || $codePostal=="" || $ville=="" || 
       $tel=="" || $nomResponsable=="" || $nombreChambresOffertes=="")
   {
      ajouterErreur("Chaque champ suivi du caractère * est obligatoire");
   }
   if ($nom!="" && estUnNomEtablissement($connexion, 'M', $id, $nom))
   {
      ajouterErreur("L'établissement $nom existe déjà");
   }
   if ($codePostal!="" && !estUnCp($codePostal))
   {
      ajouterErreur("Le code postal doit comporter 5 chiffres");   
   }
   if ($nombreChambresOffertes!="" && (!estEntier($nombreChambresOffertes) ||
       !estModifOffreCorrecte($connexion, $id, $nombreChambresOffertes)))
   {
      ajouterErreur
      ("La valeur de l'offre est non entière ou inférieure aux attributions effectuées");
   }
}

// Fonction qui vérifie la saisie lors de la création d'un établissement. 
// Pour chaque champ non valide, un message est ajouté à la liste des erreurs
function verifierDonneesEtabC($connexion, $id, $nom, $adresseRue, $codePostal, 
                              $ville, $tel, $nomResponsable, $nombreChambresOffertes)
{
   if ($id=="" || $nom=="" || $adresseRue=="" || $codePostal=="" || $ville==""
       || $tel=="" || $nomResponsable=="" || $nombreChambresOffertes=="")
   {
      ajouterErreur("Chaque champ suivi du caractère * est obligatoire");
   }
   if($id!="")
   {
      // Si l'id est constitué d'autres caractères que de lettres non accentuées 
      // et de chiffres, une erreur est générée
      if (!estChiffresOuEtLettres($id))
      {
         ajouterErreur
         ("L'identifiant doit comporter uniquement des lettres non accentuées et des chiffres");
      }
      else
      {
         if (estUnIdEtablissement($connexion, $id))
         {
            ajouterErreur("L'établissement $id existe déjà");
         }
      }
   }
   if ($nom!="" && estUnNomEtablissement($connexion, 'C', $id, $nom))
   {
      ajouterErreur("L'établissement $nom existe déjà");
   }
   if ($codePostal!="" && !estUnCp($codePostal))
   {
      ajouterErreur("Le code postal doit comporter 5 chiffres");   
   }
   if ($nombreChambresOffertes!="" && !estEntier($nombreChambresOffertes)) 
   {
      ajouterErreur ("La valeur de l'offre doit être un entier");
   }
}

// FONCTIONS DE GESTION DES ERREURS

function ajouterErreur($msg)
{
   if (! isset($_REQUEST['erreurs']))
      // $_REQUEST['erreurs']=array();
      $_REQUEST['erreurs']=[];
   $_REQUEST['erreurs'][]=$msg;
}

function nbErreurs()
{
   if (!isset($_REQUEST['erreurs']))
   {
	   return 0;
	}
	else
	{
	   return count($_REQUEST['erreurs']);
	}
}
 
function afficherErreurs()
{
   echo '<div class="msgErreur">';
   echo '<ul>';
   foreach($_REQUEST['erreurs'] as $erreur)
	{
      echo "<li>$erreur</li>";
	}
   echo '</ul>';
   echo '</div>';
} 

?>
