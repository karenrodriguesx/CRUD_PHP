<?php
//conexão com o BD
try {
	$pdo = new PDO("mysql:dbname=agenda;host=localhost","root","");

} 
catch (PDOException $e) {
	echo "Erro com BD: " .$e->getMessage();
}
catch (Exception $e) {
	echo "Erro genérico: " .$e->getMessage();
}

?>
