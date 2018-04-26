<?php
require('db.php');
?>

<?php

if(isset($_POST['search'])) {
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

    $url = "index.php?go=players";

    if($_POST["imie"])
    {
        $url .= "&imie=$imie";
    }
    if($_POST["nazwisko"])
    {
        $url .= "&nazwisko=$nazwisko";
    }
    if($_POST["narodowosc"])
    {
        $url .= "&narodowosc=$narodowosc";
    }
    if($_POST["data"])
    {
        $url .= "&dataUrodzenia=$data";
    }
    if($_POST["pozycja"])
    {
        $url .= "&pozycja=$pozycja";
    }
    if($_POST["zespol"])
    {
        $url .= "&zespol=$zespol";
    }
    if($_POST["numer"])
    {
        $url .= "&numer=$numer";
    }
    if($_POST["kontrakt"])
    {
        $url .= "&kontrakt=$kontrakt";
    }
    if($_POST["wzrost"])
    {
        $url .= "&wzrost=$wzrost";
    }
    if($_POST["atak"])
    {
        $url .= "&zasieg_ataku=$atak";
    }
    if($_POST["blok"])
    {
        $url .= "&zasieg_bloku=$atak";
    }

    header("Location: $url");
    exit();
}


if (isset($_GET['imie'])) {
    $f_imie = $_GET['imie'];
} else $f_imie = "";

if (isset($_GET['nazwisko'])) {
    $f_nazwisko = $_GET['nazwisko'];
} else $f_nazwisko = "";


if (isset($_GET['dataUrodzenia'])) {
    $f_data = $_GET['dataUrodzenia'];
} else $f_data = "";

?>

<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="index.php">Strona Główna</a>
    </li>
    <li class="breadcrumb-item active">Zawodnicy</li>
</ol>




<div class="row">




    <a class="btn btn-primary btn-search" data-toggle="collapse" href="#collapseForm" role="button" aria-expanded="false" aria-controls="collapseForm">
        Wyszukiwanie
    </a><br>

    <div class="col-md-12 col-lg-3 col-xl-2 collapser" id="collapseFormr">

    <div class="card mb-3">
        <div class="card-body searchForm">

            <form action="" method="POST" ENCTYPE="multipart/form-data" >

                <div class="form-row">
                        <label for="inputEmail4">Imię</label>
                        <input type="text" class="form-control" name="imie"  value="<?=$f_imie; ?>" >
                </div>

                <div class="form-row">
                    <label for="inputPassword4">Nazwisko</label>
                    <input type="text" class="form-control" name="nazwisko" value="<?=$f_nazwisko; ?>">
                </div>

                <div class="form-row">
                    <label for="inputState">Narodowość</label>
                    <select name="narodowosc" class="form-control">
                        <?php
                        $sel_query = "Select * from bs_kraje;";
                        $result = mysqli_query($conn,$sel_query);
                        while($row = mysqli_fetch_assoc($result)) {
                            echo '<option value="'.$row["ID_kraj"].'">  '.$row["kr_nazwa"].'</option> ';
                        } ?>
                    </select>

                    <label for="inputCity">Data urodzenia</label>
                    <input type="text" class="form-control" name="data" placeholder="rok-miesiąc-dzień" value="<?=$f_data; ?>">

                    <label for="inputState">Pozycja</label>
                    <select name="pozycja" class="form-control">
                        <option selected>Wybierz...</option>
                        <option value="A">Atakujący</option>
                        <option value="L">Libero</option>
                        <option value="P">Przyjmujący</option>
                        <option value="R">Rozgrywający</option>
                        <option value="S">Środkowy</option>
                    </select>

                    <label for="inputCity">Zespół</label>
                    <select name="zespol" class="form-control">
                        <?php
                        $sel_query = "Select * from bs_zespoly ORDER BY zes_nazwa asc;";
                        $result = mysqli_query($conn,$sel_query);
                        while($row = mysqli_fetch_assoc($result)) {
                            echo '<option value="'.$row["ID_zespol"].'">  '.$row["zes_nazwa"].'</option> ';
                        } ?>
                    </select>

                    <label for="inputCity">Numer w zespole</label>
                    <input type="text" class="form-control" name="numer">

                    <label for="inputCity">Długość kontraktu</label>
                    <input type="text" class="form-control" name="kontrakt">

                    <label for="inputCity">Wzrost</label>
                    <input type="text" class="form-control" name="wzrost">

                    <label for="inputCity">Zasięg ataku</label>
                    <input type="text" class="form-control" name="atak">

                    <label for="inputCity">Zasięg bloku</label>
                    <input type="text" class="form-control" name="blok">
                </div>

                <br>
                <button type="submit"  name="search" class="btn btn-primary">Wyszukaj</button>
            </form>
        </div>

    </div>

    </div>


    <div class="col-md-12 col-lg-9 col-xl-10">

        <div class="card mb-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Imię i nazwisko</th>
                            <th>Narodowość</th>
                            <th>Pozycja</th>
                            <th>Data ur.</th>
                            <th>Wzrost</th>
                            <th>Zespół</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Imię i nazwisko</th>
                            <th>Narodowość</th>
                            <th>Pozycja</th>
                            <th>Data ur.</th>
                            <th>Wzrost</th>
                            <th>Zespół</th>
                        </tr>
                        </tfoot>
                        <tbody>

                        <?php
                        $count=1;

                        $sel_query = "Select * from bs_siatkarze, bs_zespoly, bs_kraje, bs_pozycje WHERE ID_zespolu = ID_zespol AND Narodowosc = ID_kraj AND Pozycja = poz_skrot";

                        if(isset($_GET['imie'])) {
                            $imie = $_GET['imie'];
                            $sel_query .= " AND Imie LIKE '%{$imie}%'";
                        }
                        if(isset($_GET['nazwisko'])) {
                            $nazwisko = $_GET['nazwisko'];
                            $sel_query .= " AND Nazwisko LIKE '%{$nazwisko}%'";
                        }
                        if(isset($_GET['narodowosc'])) {
                            $narodowosc = $_GET['narodowosc'];
                            $sel_query .= " AND narodowosc = $narodowosc";
                        }


                        if(isset($_GET['wzrost'])) {
                            $wzrost = $_GET['wzrost'];
                            $sel_query .= " AND Wzrost = $wzrost";
                        }
                        if(isset($_GET['zasieg_ataku'])) {
                            $atak = $_GET['zasieg_ataku'];
                            $sel_query .= " AND Zasieg_ataku = $atak";
                        }
                        if(isset($_GET['zasieg_bloku'])) {
                            $blok = $_GET['zasieg_bloku'];
                            $sel_query .= " AND Zasieg_bloku = $blok";
                        }


                        $result = mysqli_query($conn,$sel_query);

                        while($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td>
                                    <div class="tooltipP">
                                        <?php
                                        $id = $row["ID_siatkarza"];
                                        $imie = $row["Imie"];
                                        $nazwisko = $row["Nazwisko"];
                                        $file_name = $id . " " . $imie . " ". $nazwisko . "";
                                        $id_zespol = $row["ID_zespolu"];

                                        $plik = 'img/players/'.$file_name.'.png';
                                        $test = file_exists($plik);

                                        if(!$test) {
                                            echo '<img class="playerPicSmall" src="img/default_player.png">';
                                        } else {
                                            echo '<img class="playerPicSmall" src="img/players/'.$file_name.'.png" >';
                                        }

                                        ?>
                                        <a href="index.php?go=player&id=<?php echo $id; ?>"><?php echo $row["Imie"]; ?> <?php echo $row["Nazwisko"]; ?></a>

                                        <span class="tooltiptextP">
                                    <?php
                                    if(!$test) {
                                        echo '<img class="tooltipIMG" src="img/default_player.png">';
                                    } else {
                                        echo '<img class="tooltipIMG" src="img/players/'.$file_name.'.png" >';
                                    }
                                    ?>
                              </span>
                                    </div>
                                </td>
                                <td><img class="nationPic" align="middle" src="img/flags/<?php echo $row["ID_kraj"]; ?>.png" >
                                    <?php echo $row["kr_nazwa"]; ?></td>
                                <td><?php echo $row["poz_nazwa"]; ?></td>
                                <td><?php echo $row["Data_urodzenia"]; ?></td>
                                <td><?php echo $row["Wzrost"]; ?> cm</td>
                                <td><a href="index.php?go=team&id=<?php echo $id_zespol; ?>"><?php echo $row["zes_nazwa"]; ?></a></td>
                            </tr>
                            <?php $count++; } ?>




                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>





</div>
