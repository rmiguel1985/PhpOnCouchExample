<?php
/**
 * User: rmiguel
 * Date: 22/07/2015
 * Time: 20:00
 */

require_once "CouchWrapper.php";

print "<p align='center'>Couchdb Test</p>";

$con = new CouchWrapper();
print $con->chart("600x200","1qaz");
?>