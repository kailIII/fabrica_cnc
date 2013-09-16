<?
$dbhost = 'localhost';
$dbuser = 'ab1255_cnc';
$dbpass = 'df7)!cnc)43()';
$dbname = 'ab1255_fabrica';
dbConnect('ab1255_fabrica');
function dbConnect($db='')
{
    global $dbhost, $dbuser, $dbpass;
    $dbcnx = @mysql_connect($dbhost, $dbuser, $dbpass)
        or die("[pmg_connection]Lo sentimos: El servidor de DB No esta disponible.");
    if ($db!="" AND !@mysql_select_db($db))
        die("[pmg_connection]Lo sentimos: La Base de datos no esta disponible.");
    return $dbcnx;
}
?>