<?php
require('db.php');
?>

<?php


if(isset($_POST['cancel'])) {
    header("Location: index.php?go=players");
}

if(isset($_POST['insert'])) {

    $id = $_GET['id'];

    $imie = $_REQUEST['imie'];
    $nazwisko = $_REQUEST['nazwisko'];
    $narodowosc = $_REQUEST['narodowosc'];
    $data = $_REQUEST['data'];
    $pozycja = $_REQUEST['pozycja'];
    $zespol = $_REQUEST['zespol'];
    $numer = $_REQUEST['numer'];
    $kontrakt = $_REQUEST['kontrakt'];
    $wzrost = $_REQUEST['wzrost'];
    $atak = $_REQUEST['atak'];
    $blok = $_REQUEST['blok'];

    if(!$_POST["imie"] || !$_POST["nazwisko"])
    {
        header("Location: index.php?go=player-edit&form=empty");
        exit();
    }


    $update_query = "UPDATE bs_siatkarze SET `Imie` = '$imie', `Nazwisko` = '$nazwisko', `Data_urodzenia` = '$data', `Narodowosc` = '$narodowosc', `Pozycja` = '$pozycja', `Wzrost` = '$wzrost', `Zasieg_ataku`= '$atak', `Zasieg_bloku` = '$blok', `ID_zespolu` = '$zespol', `Nr_koszulki` = '$numer', `Dlugosc_kontraktu` = '$kontrakt' WHERE `ID_siatkarza` = '$id'";

    if (mysqli_query($conn, $update_query)) {
        echo '<div class="alert alert-success" role="alert">
  Siatkarz został edytowany... <a href="index.php?go=player&id='.$id.'">(Zobacz profil)</a>
</div>';
    } else {
        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
    }


    if (is_uploaded_file($_FILES['plik']['tmp_name'])) {
        $max_rozmiar = 1024*1024;
        $filename = $_FILES["plik"]["name"];
        $file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
        $file_ext = substr($filename, strripos($filename, '.')); // get file name

        $allowed_file_types = array('.png');

        $file_name = $id . " " . $imie . " ". $nazwisko . "".$file_ext;

        if (($_FILES['plik']['size'] > $max_rozmiar)) {
            echo 'Błąd! Plik jest za duży!';
        } else {
            //echo 'Odebrano plik. Początkowa nazwa: '.$_FILES['plik']['name'];
            //echo '<br/>';
            if (isset($_FILES['plik']['type'])) {
                //echo 'Typ: '.$_FILES['plik']['type'].'<br/>';
            }

            move_uploaded_file($_FILES['plik']['tmp_name'],
                $_SERVER['DOCUMENT_ROOT'].'/zespolowy/start/img/players/'. $file_name);


        }
    } else {
        //echo 'Błąd przy przesyłaniu danych! <br>';
    }


}
?>


<head>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
</head>



<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="index.php">Panel Administracyjny</a>
    </li>
    <li class="breadcrumb-item">
        <a href="index.php?go=players">Zawodnicy</a>
    </li>
    <li class="breadcrumb-item active">Dodawanie zawodnika</li>
</ol>

<?php
$fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if(strpos($fullUrl, "form=empty") == true) {
    echo '<div class="alert alert-danger" role="alert">
                 Uzupełnij wszystkie dane!
                </div>';
}

?>



<?php
$id = $_GET['id'];

$sel_query = "Select * from bs_siatkarze, bs_zespoly, bs_kraje, bs_pozycje WHERE ID_zespolu = ID_zespol AND Narodowosc = ID_kraj AND Pozycja = poz_skrot AND ID_siatkarza = '$id';";
$result = mysqli_query($conn,$sel_query);

while($row = mysqli_fetch_assoc($result)) {
    $id = $row["ID_siatkarza"];
    $imie = $row["Imie"];
    $nazwisko = $row["Nazwisko"];
    $file_name = $id . " " . $imie . " ". $nazwisko . "";

    $wzrost = $row["Wzrost"];
    $atak = $row["Zasieg_ataku"];
    $blok = $row["Zasieg_bloku"];

    $narodowosc = $row["Narodowosc"];

    $data = $row["Data_urodzenia"];

    $data = $row["Data_urodzenia"];

    $pozycja = $row["poz_nazwa"];
    $poz = $row["Pozycja"];

    $zespol = $row["zes_nazwa"];
    $id_zespol = $row["ID_zespol"];
    $nr = $row["Nr_koszulki"];
    $kontrakt = $row["Dlugosc_kontraktu"];

    $file_name_team = $zespol;
}


?>

<!-- Example DataTables Card-->
<div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-pencil"></i> Edytuj formularz z danymi zawodnika
    </div>

    <div class="card-body card-background">

        <form action="" method="POST" ENCTYPE="multipart/form-data" >

            <div class="form-row">
                <div class="form-group col-12 col-md-6 col-xl-3">
                    <label for="inputEmail4">Imię</label>
                    <input type="text" class="form-control" name="imie" placeholder="Imię" value="<?=$imie;?>">
                </div>
                <div class="form-group col-12 col-md-6 col-xl-3">
                    <label for="inputPassword4">Nazwisko</label>
                    <input type="text" class="form-control" name="nazwisko" placeholder="Nazwisko" value="<?=$nazwisko;?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4 col-xl-2">
                    <label for="inputState">Narodowość</label>
                    <select name="narodowosc" class="form-control">
                        <?php
                        $sel_query = "Select * from bs_kraje;";
                        $result = mysqli_query($conn,$sel_query);

                        while($row = mysqli_fetch_assoc($result)) {
                           ?>
                            <option value="<?php echo $row["ID_kraj"]; ?>" <?php echo ($row['ID_kraj'] == $narodowosc) ? 'selected="selected"' : ''; ?> >  <?php echo $row["kr_nazwa"]; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-4 col-xl-2">
                    <label for="inputCity">Data urodzenia</label>
                    <input type="text" class="form-control" name="data" placeholder="rok-miesiąc-dzień" value="<?=$data;?>">
                </div>

                <div class="form-group col-md-4 col-xl-2">
                    <label for="inputState">Pozycja</label>
                    <select name="pozycja" class="form-control">
                        <option>Wybierz...</option>
                        <option value="A" <?php if($poz == "A") { echo 'selected';} ?>>Atakujący</option>
                        <option value="L" <?php if($poz == "L") { echo 'selected';} ?>>Libero</option>
                        <option value="P" <?php if($poz == "P") { echo 'selected';} ?>>Przyjmujący</option>
                        <option value="R" <?php if($poz == "R") { echo 'selected';} ?>>Rozgrywający</option>
                        <option value="S" <?php if($poz == "S") { echo 'selected';} ?>>Środkowy</option>
                    </select>
                </div>


            </div>



            <div class="form-row">

                <div class="form-group col-md-4 col-lg-3 col-xl-2">
                    <label for="inputCity">Zespół</label>
                    <select name="zespol" class="form-control">
                        <?php
                        $sel_query = "Select * from bs_zespoly ORDER BY zes_nazwa asc;";
                        $result = mysqli_query($conn,$sel_query);
                        while($row = mysqli_fetch_assoc($result)) {
                       ?>
                            <option value="<?php echo $row["ID_zespol"]; ?>" <?php echo ($row['ID_zespol'] == $id_zespol) ? 'selected="selected"' : ''; ?> >  <?php echo $row["zes_nazwa"]; ?></option>
                       <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-4 col-lg-3 col-xl-2">
                    <label for="inputCity">Numer w zespole</label>
                    <input type="text" class="form-control" name="numer" placeholder="Numer w zespole" value="<?=$nr;?>">
                </div>

                <div class="form-group col-md-4 col-lg-3 col-xl-2">
                    <label for="inputCity">Długość kontraktu</label>
                    <input type="text" class="form-control" name="kontrakt" placeholder="Długość kontraktu" value="<?=$kontrakt;?>">
                </div>

            </div>




            <div class="form-row">

                <div class="form-group col-md-4 col-lg-3 col-xl-2">
                    <label for="inputCity">Wzrost</label>
                    <input type="text" class="form-control" name="wzrost" placeholder="Wzrost" value="<?=$wzrost;?>">
                </div>

                <div class="form-group col-md-4 col-lg-3 col-xl-2">
                    <label for="inputCity">Zasięg ataku</label>
                    <input type="text" class="form-control" name="atak" placeholder="Zasięg ataku" value="<?=$atak;?>">
                </div>

                <div class="form-group col-md-4 col-lg-3 col-xl-2">
                    <label for="inputCity">Zasięg bloku</label>
                    <input type="text" class="form-control" name="blok" placeholder="Zasięg bloku" value="<?=$blok;?>">
                </div>

            </div>




            <div class="form-group">
                <label for="exampleFormControlFile1">Zdjęcie zawodnika</label>
                <input type="file" class="form-control-file" id="exampleFormControlFile1" name="plik">
            </div>



            <br>
            <button type="submit"  name="insert" class="btn btn-primary">Zapisz</button>
            <button type="submit"  name="cancel" class="btn btn-primary">Anuluj</button>
        </form>



    </div>

</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>