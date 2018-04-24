<?php
require('db.php');
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
    $wzrost_temp = $row["Wzrost"];
    $wzA = $row["Wzrost"];
    $wzA -= 2;
    $wzB = $row["Wzrost"];
    $wzB += 2;
    $atak = $row["Zasieg_ataku"];
    $blok = $row["Zasieg_bloku"];

    $narodowosc = $row["kr_nazwa"];
    $data = $row["Data_urodzenia"];

    $data_tempA = $row["Data_urodzenia"];
    $data_tempA = strtotime($data_tempA);
    $data_newA = strtotime('+ 2 year', $data_tempA);
    $dataA = date('Y-m-d', $data_newA);

    $data_tempB = $row["Data_urodzenia"];
    $data_tempB = strtotime($data_tempB);
    $data_newB = strtotime('- 2 year', $data_tempB);
    $dataB = date('Y-m-d', $data_newB);




    $pozycja = $row["poz_nazwa"];
    $poz = $row["Pozycja"];

    $zespol = $row["zes_nazwa"];
    $id_zespol = $row["ID_zespol"];
    $nr = $row["Nr_koszulki"];
    $kontrakt = $row["Dlugosc_kontraktu"];

    $file_name_team = $zespol;


    if($kontrakt == "0") $lata = "lat";
    if($kontrakt == "1") $lata = "rok";
    if($kontrakt == "2" || $kontrakt == "3" || $kontrakt == "4") $lata = "lata";
    if($kontrakt == "5") $lata = "lat";
}

?>

<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="index.php">Strona Główna</a>
    </li>
    <li class="breadcrumb-item">
        <a href="index.php?go=players">Zawodnicy</a>
    </li>
    <li class="breadcrumb-item active"><?=$imie; ?> <?=$nazwisko; ?></li>
</ol>


<div class="row">
<!--    SIATKARZE Z KLUBU-->
    <div class="col-sm-4 col-xl-3">

        <div class="card mb-3">
            <div class="card-body">
                <p><a href="index.php?go=team&id=<?=$id_zespol; ?>">
                        <?php
                        $plik2 = 'img/teams/'.$file_name_team.'.png';
                        $test2 = file_exists($plik2);

                        if(!$test2) {
                            echo '';
                        } else {
                            echo '<img class="teamPic mr-3" src="img/teams/'.$file_name_team.'.png" >';
                        }
                        ?><?=$zespol; ?> </a> </p>
                <table class="table table-sm table-profile-player">
                    <thead class="thead-dark">
                    <tr>
                        <th></th>
                        <th>Imię i nazwisko</th>
                        <th></th>
                        <th>Wiek</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $count=1;
                    $sel_query2 = "Select * from bs_siatkarze, bs_zespoly, bs_kraje, bs_pozycje WHERE ID_zespolu = ID_zespol AND Narodowosc = ID_kraj AND Pozycja = poz_skrot AND ID_zespolu = $id_zespol;";
                    $result2 = mysqli_query($conn,$sel_query2);

                    while(($row = mysqli_fetch_assoc($result2))) {
                        $id2 = $row["ID_siatkarza"];
                        $imie2 = $row["Imie"];
                        $nazwisko2 = $row["Nazwisko"];
                        $pozycja2 = $row['poz_nazwa'];
                        $wzrost2 = $row["Wzrost"];
                        $id_kraj2 = $row["Narodowosc"];
                        $kraj2 = $row["kr_nazwa"];

                        $file_name2 = $id2 . " " . $imie2 . " ". $nazwisko2 . "";
                        $id_zespol2 = $row["ID_zespolu"];

                        $plik2 = 'img/players/'.$file_name2.'.png';
                        $test2 = file_exists($plik2);
                        ?>
                        <tr>
                            <td>
                                <?php if(!$test2) {
                                    echo '<img class="playerPicSmall" src="img/default_player.png">';
                                } else {
                                    echo '<img class="playerPicSmall" src="img/players/'.$file_name2.'.png" >';
                                } ?>
                            </td>
                            <td><a href="index.php?go=player&id=<?=$id2; ?>"><?=$imie2; ?> <?=$nazwisko2; ?></a></br>
                                <?=$pozycja2; ?></td>
                            <td><img class="nationPic" align="middle" src="img/flags/<?=$id_kraj2; ?>.png" title="<?=$kraj2; ?>"></td>
                            <td><?=$count;?></td>
                        </tr>
                        <?php
                        $count++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

<!--    PROFIL ZAWODNIKA-->
    <div class="col-sm-4 order-sm-first col-xl-6">
        <div class="card mb-3">

            <div class="card-body ">
                <div class="row">
                    <div class="col-md-2 player">

                        <?php
                        $plik = 'img/players/'.$file_name.'.png';
                        $test = file_exists($plik);

                        if(!$test) {
                            echo '<img class="playerPic mr-3" src="img/default_player.png">';
                        } else {
                            echo '<img class="playerPic mr-3" src="img/players/'.$file_name.'.png" >';
                        }
                        ?>
                    </div>

                    <div class="col-md-10 player-info">
                        <p class="h1"><a href="#"><?=$imie; ?> <?=$nazwisko; ?></a></p>
                        <p> <a href="#"><?=$zespol; ?>
                                <?php
                                $plik2 = 'img/teams/'.$file_name_team.'.png';
                                $test2 = file_exists($plik2);

                                if(!$test2) {
                                    echo '';
                                } else {
                                    echo '<img class="teamPic mr-3" src="img/teams/'.$file_name_team.'.png" >';
                                }
                                ?></a> </p>
                    </div>
                </div>

                </br>

                <div class="row">

                    <div class="col-sm-4">
                        <div class="datainfo text-center">Narodowość:<span><?=$narodowosc; ?></span></div>
                    </div>

                    <div class="col-sm-4">
                        <div class="datainfo text-center">Data urodzenia:<span><?=$data; ?></span></div>
                    </div>

                    <div class="col-sm-4">
                        <div class="datainfo text-center">Pozycja:<span><?=$pozycja; ?></span></div>
                    </div>

                </div>

                </br>

                <div class="row">

                    <div class="col-sm-6">
                        <div class="datainfo text-center">Zespół:<span><?=$zespol; ?></span></div>
                    </div>

                    <div class="col-sm-3">
                        <div class="datainfo text-center">Numer koszulki:<span><?=$nr; ?></span></div>
                    </div>

                    <div class="col-sm-3">
                        <div class="datainfo text-center">Długość kontraktu:<span><?=$kontrakt; ?> <?=$lata; ?></span></div>
                    </div>

                </div>

                </br>

                <div class="row">

                    <div class="col-sm-4">
                        <div class="datainfo text-center">Wzrost:<span><?=$wzrost; ?> cm</span></div>
                    </div>

                    <div class="col-sm-4">
                        <div class="datainfo text-center">Zasięg ataku:<span><?=$atak; ?> cm</span></div>
                    </div>

                    <div class="col-sm-4">
                        <div class="datainfo text-center">Zasięg bloku:<span><?=$blok; ?> cm</span></div>
                    </div>

                </div>


            </div>
        </div>


    </div>

<!--    PODOBNI SIATKARZE-->
    <div class="col-sm-4 col-xl-3">
        <div class="card mb-3">
            <div class="card-body">
                Podobni siatkarze <br>
                <table class="table table-sm table-profile-player">
                    <thead class="thead-dark">
                    <tr>
                        <th></th>
                        <th>Imię i nazwisko</th>
                        <th></th>
                        <th>Wiek</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $count=1;
                    $sel_query2 = "Select * from bs_siatkarze, bs_zespoly, bs_kraje, bs_pozycje WHERE ID_zespolu = ID_zespol AND Narodowosc = ID_kraj AND Pozycja = poz_skrot AND Wzrost BETWEEN $wzA AND $wzB AND Pozycja =  '".$poz."' AND  Data_urodzenia BETWEEN '$dataB' AND '$dataA' AND ID_siatkarza != '".$id."' ORDER BY RAND() LIMIT 6 ";
                    $result2 = mysqli_query($conn,$sel_query2);

                    while(($row = mysqli_fetch_assoc($result2)) && $count <= 5  ) {
                        $id2 = $row["ID_siatkarza"];
                        $imie2 = $row["Imie"];
                        $nazwisko2 = $row["Nazwisko"];
                        $pozycja2 = $row['poz_nazwa'];
                        $wzrost2 = $row["Wzrost"];
                        $id_kraj2 = $row["Narodowosc"];
                        $kraj2 = $row["kr_nazwa"];

                        $file_name2 = $id2 . " " . $imie2 . " ". $nazwisko2 . "";
                        $id_zespol2 = $row["ID_zespolu"];

                        $plik2 = 'img/players/'.$file_name2.'.png';
                        $test2 = file_exists($plik2);
                        ?>
                        <tr>
                            <td>
                                <?php if(!$test2) {
                                    echo '<img class="playerPicSmall" src="img/default_player.png">';
                                } else {
                                    echo '<img class="playerPicSmall" src="img/players/'.$file_name2.'.png" >';
                                } ?>
                            </td>
                            <td><a href="index.php?go=player&id=<?=$id2; ?>"><?=$imie2; ?> <?=$nazwisko2; ?></a></br>
                                <?=$pozycja2; ?></td>
                            <td><img class="nationPic" align="middle" src="img/flags/<?=$id_kraj2; ?>.png" title="<?=$kraj2; ?>"></td>
                            <td><?=$count;?></td>
                        </tr>
                        <?php
                        $count++;
                    }
                    ?>
                    </tbody>
                </table>






            </div>
        </div>

    </div>
</div>
