<?php
require('conf.php');

session_start();
?>

<?php
if(isset($_REQUEST["heatants"])){
    global $yhendus;
    $kask=$yhendus->prepare("UPDATE tantsud SET punktid=punktid+1 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["heatants"]);
    $kask->execute();
}
if(isset($_REQUEST["badtants"])){
    global $yhendus;
    $kask=$yhendus->prepare("UPDATE tantsud SET punktid=punktid-1 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["badtants"]);
    $kask->execute();
}
if(isset($_REQUEST["komment"])){
    if(!empty($_REQUEST["uuskomment"])){
    global $yhendus;
    $kask = $yhendus->prepare("UPDATE tantsud SET kommentaarid=CONCAT(kommentaarid, ?) WHERE id=?");
    $kommentplus=$_REQUEST["uuskomment"]."\n";
    $kask->bind_param("si", $kommentplus, $_REQUEST["komment"]);
    $kask->execute();
}
}
?>
<!doctype html>
<html lang="et">
<head>
    <link rel="stylesheet" type="text/css" href="ZvezdiCss.css">

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kasutaja</title>
</head>
<body>
<h1>Tantsid tähtedega</h1>
<?php
if ($_SESSION['onAdmin'] == 1) {
    echo "
    <nav>
        <ul>
            <li><a href='haldusleht.php'>Kasutaja</a></li>
            <li><a href='AdminLeht.php'>Admin</a></li>
        </ul>
    </nav>";
}
else{
    echo "Tervist!";
}
?>
<table>
    <tr>
        <th>Tantsupaari nimi</th>
        <th>Punktid</th>
        <th>Kuupäev</th>
        <th>Kommentaarid</th>
        <th colspan=3>Hindamine</th>
    </tr>
<?php
    global $yhendus;
    $kask=$yhendus->prepare("SELECT id, tantsupaar, punktid, ava_paev, kommentaarid FROM tantsud WHERE avalik=1");
    $kask->bind_result($id, $tantsupaar, $punktid, $paev, $komment);
    $kask->execute();
    while($kask->fetch()){
        echo "<tr>";
        $tantsupaar=htmlspecialchars($tantsupaar);
        echo "<td>".$tantsupaar."</td>";
        echo "<td>".$punktid."</td>";
        echo "<td>".$paev."</td>";
        echo "<td>".nl2br(htmlspecialchars($komment))."</td>";

        echo "<td>
<form action='?'>
        <input type='hidden'  value='$id' name='komment'>
        <input type='text' name='uuskomment' id='uuskomment'>
        <input type='submit' value='OK'>
</form>
        ";
        echo "<td><a href='?heatants=$id'>Lisa +1punkt</a></td>";

        echo "</tr>";
    }

?>
</table>
</body>
</html>
<?php