<?php
include("inc/header.php");

if ($_POST['submit']) {
    $inlognaam=isset($_POST['inlognaam']) ? $_POST['inlognaam'] : '';
    $wachtwoord=isset($_POST['wachtwoord']) ? $_POST['wachtwoord'] : '';
}
else {
    header('refresh: 1, index.php');
}
//selectquery opbouwen
$query = "SELECT m.id, m.inlognaam, m.wachtwoord, r.naam FROM medewerker m
            INNER JOIN rol r ON m.rol_id=r.id
            where m.inlognaam='" . $inlognaam . "' and m.wachtwoord='" . $wachtwoord . "';";
//$resultaat bepalen....
$result = mysqli_query($dbconn, $query);
//aantal records bepalen....
$aantal = mysqli_num_rows($result);
echo "AANTAL: $aantal<br>";
if ($aantal == 1) {
    while ($row = mysqli_fetch_array($result)) {
        $rol = $row['naam'];
    }
    $_SESSION['inlognaam'] = $inlognaam;
    $_SESSION['wachtwoord'] = $wachtwoord;
    $_SESSION['rol'] = $rol;
    $_SESSION['ingelogd'] = true;
    header('refresh: 1; url=kassa.php');
    exit;
} else {
    echo 'Helaas, uw inlognaam en/of wachtwoord corresponderen niet met onze gegevens. U wordt
            doorgestuurd...<br>';
    session_destroy();
    session_unset();
    //sluiten db-connectie
    mysqli_close($dbconn);
    header('refresh: 5; url=login.php');
    exit;
}
include("inc\footer.php");
?>