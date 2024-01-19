<?php
$kasutaja="d123171_edvardz";
$servernimi="d123171.mysql.zonevs.eu";
$parool="qwertysologgez";
$andmebaas="d123171_tantsud";
$yhendus = new mysqli($servernimi, $kasutaja, $parool, $andmebaas);
$yhendus->set_charset('UTF8');
