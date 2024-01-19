<?php
require_once("conf.php");
$yhendus = mysqli_connect($servernimi, $kasutaja, $parool, $andmebaas);

if (!empty($_POST['login']) && !empty($_POST['pass'])) {

    $login = htmlspecialchars(trim($_POST['login']));
    $pass = htmlspecialchars(trim($_POST['pass']));


    $cool = 'superpaev';
    $kryp = crypt($pass, $cool);


    $kask2 = $yhendus->prepare("INSERT INTO kasutaja (kasutaja, parool, onAdmin) VALUES (?, ?, 0)");
    $kask2->bind_param("ss", $login, $kryp);
    $kask2->execute();
        
    echo '<script>alert("Registreerimine õnnestus!"); window.location.href = "haldusleht.php";</script>';

    $kask2->close();
    $yhendus->close();
    exit();

}
?>
<script>
    function back() {
        window.history.back();
    }
</script>
<link rel="stylesheet" type="text/css" href="ZvezdiCss.css">
<h1>Registreerimine</h1>
<form action="" method="post">
    Kasutaja nimi: <input type="text" name="login"><br>
    Password: <input type="password" name="pass"><br>
    <input type="submit" value="Register">
    <input type="button" value="Tagasi" onclick="back()">
</form>