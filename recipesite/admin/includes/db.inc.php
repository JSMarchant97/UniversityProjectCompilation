<?php 
try
{
    $pdo = new PDO('mysql:host=mysql.cms.gre.ac.uk; dbname=mdb_jm1727g', 'jm1727g', '1ysfqxtqW2');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('SET NAMES "utf8"');
}
catch(PDOException $e)
{
    $output = 'Unable to connect to the database:' . $e->getMessage();
    //$output = 'Unable to connect to the database:';
    include 'error.html.php';
    exit();
}
?>