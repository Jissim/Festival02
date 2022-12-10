<?PHP
$user = 'root'; 
$pass = ''; 
// Data Source Name 
$dsn = 'mysql:host=localhost;dbname=festival';

try{ //tentative de connexion : on crée un objet de la classe PDO 
$dbh= new PDO($dsn, $user, $pass); 

//S'il y a des erreurs de connexion, un objet PDOException est lancé. Vous pouvez attraper cette exception si vous voulez  gérer cette erreur 

} catch (PDOException $e){ 
print "Erreur ! :" . $e->getMessage() . "<br/>"; 
die(); 
}
$sql = "SELECT * FROM EMBARCATION";
$sth = $dbh->query($sql); 
$result = $sth->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row){ 
echo $row['Numembarcation'];echo '-';
echo $row['Codetype'];echo '<br/>'; 
}
$dbh=NULL;

?>