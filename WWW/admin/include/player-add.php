<?php
require('db.php');
?>

<?php

if(isset($_POST['insert'])) {
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
        header("Location: index.php?go=player-add&form=empty");
        exit();
    }


    $insert_query = "Insert INTO bs_siatkarze (`ID_siatkarza`, `Imie`, `Nazwisko`, `Data_urodzenia`, `Narodowosc`, `Pozycja`, `Wzrost`, `Zasieg_ataku`, `Zasieg_bloku`, `ID_zespolu`, `Nr_koszulki`, `Dlugosc_kontraktu`) VALUES ('', '$imie', '$nazwisko', '$data', '$narodowosc', '$pozycja', '$wzrost', '$atak', '$blok', '$zespol', '$numer', '$kontrakt')";

    if (mysqli_query($conn, $insert_query)) {
        $last_id = $conn->insert_id;
        echo '<div class="alert alert-success" role="alert">
  Siatkarz został dodany... <a href="index.php?go=player&id='.$last_id.'">(Zobacz profil)</a>
</div>';
    } else {
        echo "Error: " . $insert_query . "<br>" . mysqli_error($conn);
    }


if (is_uploaded_file($_FILES['plik']['tmp_name'])) {
    $max_rozmiar = 1024*1024;
    $filename = $_FILES["plik"]["name"];
    $file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
    $file_ext = substr($filename, strripos($filename, '.')); // get file name

    $allowed_file_types = array('.png');

    $file_name = $last_id . " " . $imie . " ". $nazwisko . "".$file_ext;

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

    mysqli_close($conn);
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

<!-- Example DataTables Card-->
<div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-pencil"></i> Uzupełnij formularz z danymi zawodnika
    </div>

    <div class="card-body card-background">

        <form action="" method="POST" ENCTYPE="multipart/form-data" >

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputEmail4">Imię</label>
                    <input type="text" class="form-control" name="imie" placeholder="Imię">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputPassword4">Nazwisko</label>
                    <input type="text" class="form-control" name="nazwisko" placeholder="Nazwisko">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="inputState">Narodowość</label>
                    <select name="narodowosc" class="form-control">
                        <?php
                        $sel_query = "Select * from bs_kraje;";
                        $result = mysqli_query($conn,$sel_query);
                        while($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="'.$row["ID_kraj"].'">  '.$row["kr_nazwa"].'</option> ';
                        } ?>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="inputCity">Data urodzenia</label>
                    <input type="text" class="form-control" name="data" placeholder="rok-miesiąc-dzień">
                </div>

                <div class="form-group col-md-2">
                    <label for="inputState">Pozycja</label>
                    <select name="pozycja" class="form-control">
                        <option selected>Wybierz...</option>
                        <option value="A">Atakujący</option>
                        <option value="L">Libero</option>
                        <option value="P">Przyjmujący</option>
                        <option value="R">Rozgrywający</option>
                        <option value="S">Środkowy</option>
                    </select>
                </div>



            </div>



            <div class="form-row">

                <div class="form-group col-md-2">
                    <label for="inputCity">Zespół</label>
                    <select name="zespol" class="form-control">
                        <?php
                        $sel_query = "Select * from bs_zespoly ORDER BY zes_nazwa asc;";
                        $result = mysqli_query($conn,$sel_query);
                        while($row = mysqli_fetch_assoc($result)) {
                            echo '<option value="'.$row["ID_zespol"].'">  '.$row["zes_nazwa"].'</option> ';
                        } ?>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="inputCity">Numer w zespole</label>
                    <input type="text" class="form-control" name="numer">
                </div>

                <div class="form-group col-md-2">
                    <label for="inputCity">Długość kontraktu</label>
                    <input type="text" class="form-control" name="kontrakt">
                </div>

            </div>




            <div class="form-row">

                <div class="form-group col-md-2">
                    <label for="inputCity">Wzrost</label>
                    <input type="text" class="form-control" name="wzrost">
                </div>

                <div class="form-group col-md-2">
                    <label for="inputCity">Zasięg ataku</label>
                    <input type="text" class="form-control" name="atak">
                </div>

                <div class="form-group col-md-2">
                    <label for="inputCity">Zasięg bloku</label>
                    <input type="text" class="form-control" name="blok">
                </div>

            </div>




            <div class="form-group">
                <label for="exampleFormControlFile1">Zdjęcie zawodnika</label>
                <input type="file" class="form-control-file" id="exampleFormControlFile1" name="plik">
            </div>



            <br>
            <button type="submit"  name="insert" class="btn btn-primary">Dodaj</button>
        </form>



    </div>

</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>