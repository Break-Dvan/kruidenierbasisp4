<?php
// include header.php
include 'inc/header.php';
// header tags toevoegen
echo '<header class="head">';
// url voor handmatige voorraad...
echo "<a href='product_new.php' class='btn-new'><i class='material-icons md-24'>add</i></a>";
echo "<a href='voorraad_import.php' class='btn-new'><i class='material-icons md-24'>file_upload</i></a>";


//echo '<span class="material-icons-outlined">
//import_export
//</span> ';
echo '</header>'; //afsluiten header
// voor gridopmaak alvast de main-content
echo '<main class="main-content">';
?>
    <!-- tabelkop met Voorraad als HTML-->
    <table id="voorraad">
        <tr>
            <th>artikelnummer</th>
            <th>omschrijving</th>
            <th>leverancier</th>
            <th>artikelgroep</th>
            <th>eenheid</th>
            <th>prijs</th>
            <th>aantal</th>
            <th>actie</th>
        </tr>
<?php
//bepaling 'page' voor paginering
if (isset($_GET["page"])) {
    $page = $_GET["page"];
}
else {
    $page=1;
}
//start vanaf
$start_from = ($page-1) * RECORDS_PER_PAGE;
//aantal pagina's bepalen t.b.v. paginering
$sql_count = "SELECT count(id) as aantal FROM product;";
$res_count = mysqli_query($dbconn, $sql_count);
$row = mysqli_fetch_assoc($res_count);
$total_rows = $row['aantal'];
$total_pages = ceil($total_rows / RECORDS_PER_PAGE);

// ophalen klantgegevens uit database
$query="SELECT id, artikelnummer, omschrijving, leverancier, artikelgroep, eenheid, prijs, aantal FROM product
        ORDER BY omschrijving, artikelgroep, artikelnummer
        LIMIT " .$start_from.",". RECORDS_PER_PAGE.";";
//$resultaat bepalen....
$result=mysqli_query($dbconn, $query);
//aantal records bepalen....
$aantal=mysqli_num_rows($result);
$contentTable="";
// tabel aanvullen met klantgegevens
if ($aantal>0){ //controle of er wel wat opgehaald wordt...
    while ($row=mysqli_fetch_array($result)) {
        $contentTable.="<tr>
                            <td>".$row['artikelnummer']."</td>                       
                            <td>".$row['omschrijving']."</td>                       
                            <td>".$row['leverancier']."</td>                       
                            <td>".$row['artikelgroep']."</td>                       
                            <td>".$row['eenheid']."</td>                      
                            <td>".$row['prijs']."</td>                      
                            <td>".$row['aantal']."</td>
                            <td>
                                <a href='product_edit.php?id={$row['id']}' class='btn-edit'><i class='material-icons md-24'>edit</i></a>
                                <a href='product_delete.php?id={$row['id']}' class='btn-delete'><i class='material-icons md-24'>delete</i></a>
                            </td>
                        </tr>";
    }
}
else {
    $contentTable='<tr>
                        <td colspan="9">Geen gegevens om op te halen...</td>
                    </tr>';
}
// weergave van de rest van de tabel;
$contentTable.='</table><br>';
echo $contentTable;
// paginering van de tabel
$page_url="voorraad.php";
include_once 'inc/paginering.php';


// include footer
//echo '</div>'; //frmDetail afsluiten
echo '</main>'; //main afsluiten
include ("inc/footer.php") ;
?>