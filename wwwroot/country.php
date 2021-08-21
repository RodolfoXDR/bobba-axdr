<?php
require '../KERNEL-XDRCMS/Init.php';
header('Content-type: text/plain');


$q = SQL::query('SELECT country_cf, COUNT(country_cf) FROM xdr_users WHERE online = \'1\' GROUP by country_cf ORDER BY COUNT(country_cf) DESC');
while($row = $q->fetch_assoc())
{
	echo $row['country_cf'] . '    ' . $row['COUNT(country_cf)'] . '
';
}

?>