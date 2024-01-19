<?php
require ('conf.php');

session_start();

function isAdmin(){
    return  isset($_SESSION['onAdmin']) && $_SESSION['onAdmin'];
}

if (isAdmin()) {
    echo "Admin";
} 
else {
    echo "neAdmin";
    }
// punktide nulliks
if(isset($_REQUEST["punktid0"])){
    global $yhendus;
    $kask=$yhendus->prepare("UPDATE tantsud SET punktid=0 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["punktid0"]);
    $kask->execute();
}
// peitmine
if(isset($_REQUEST["peitmine"])){
    global $yhendus;
    $kask=$yhendus->prepare("UPDATE tantsud SET avalik=0 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["peitmine"]);
    $kask->execute();
}
// näitmine
if(isset($_REQUEST["naitmine"])){
    global $yhendus;
    $kask=$yhendus->prepare("UPDATE tantsud SET avalik=1 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["naitmine"]);
    $kask->execute();
}
// kustutamine
if(isset($_REQUEST["deletetants"])){
    global $yhendus;
    $kask=$yhendus->prepare("DELETE from tantsud WHERE id=?");
    $kask->bind_param("i", $_REQUEST["deletetants"]);
    $kask->execute();
}
if(isset($_REQUEST["paarinimi"]) && !empty($_REQUEST["paarinimi"])){
    global $yhendus;
    $kask = $yhendus->prepare("INSERT INTO tantsud (tantsupaar, ava_paev) VALUES(?, NOW())");
    $kask->bind_param("s", $_REQUEST["paarinimi"]);
    $kask->execute();
}
?>
<!doctype html>
<html lang="et">
<head>
    <link rel="stylesheet" type="text/css" href="ZvezdiCss.css"

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
</head>
<body>
<h1>Tantsid tähtedega</h1>
<nav>
    <ul>
        <li><a href="haldusleht.php">Kasutaja</a></li>
        <li><a href="AdminLeht.php">Admin</a></li>
    </ul>
</nav>
<h2>AdministreerimisLeht</h2>
<table>
    <tr>
        <th>Tantsupaari nimi</th>
        <th>Punktid</th>
        <th>Kuupäev</th>
        <th>Kommentaarid</th>
        <th>Avalik</th>
        <th colspan="3">Admin Õigus</th>
    </tr>
<?php
    global $yhendus;
    $kask=$yhendus->prepare("SELECT id, tantsupaar, punktid, ava_paev, kommentaarid, avalik FROM tantsud");
    $kask->bind_result($id,$tantsupaar,$punktid,$paev, $komment, $avalik);
    $kask->execute();
    while($kask->fetch()){
        $tekst="Näita";
        $seisund="naitmine";
        $tekst2="Kasutaja ei näe";
        if($avalik==1){
            $tekst="Peida";
            $seisund="peitmine";
            $tekst2="Kasutaja näe";
        }
        echo "<tr>";
        $tantsupaar=htmlspecialchars($tantsupaar);
        echo "<td>".$tantsupaar;"</td>";
        echo "<td>".$punktid;"</td>";
        echo "<td>".$paev;"</td>";
        echo "<td>".$komment;"</td>";
        echo "<td>".$avalik."/".$tekst2;"</td>";
        echo "<td><a href='?punktid0=$id'>Punktid Nulliks!</a></td>";
        echo "<td><a href='?deletetants=$id'>Kustuta paar</a></td>";
        echo "<td><a href='?$seisund=$id'>$tekst</a></td>";
        echo "<tr>";
    }
?>
    <form action="?">
        <label for="paarinimi">Lisa uus paar</label>
        <input type="text" name="paarinimi" id="paarinimi">
        <input type="submit" value="Lisa paar">
    </form>
</table>
</body>
</html>
<?php
