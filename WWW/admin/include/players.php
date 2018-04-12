<?php
require('db.php');
?>

<!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index.php">Panel Administracyjny</a>
        </li>
        <li class="breadcrumb-item active">Zawodnicy</li>
      </ol>

    <a class="btn btn-primary" href="index.php?go=player-add">Dodaj siatkarza</a></p>

      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Zawodnicy</div>
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
					<th>Operacje</th>
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
                      <th>Operacje</th>
                  </tr>
                </tfoot>
              <tbody>

              <?php
              $count=1;
              $sel_query = "Select * from bs_siatkarze, bs_zespoly, bs_kraje, bs_pozycje WHERE ID_zespolu = ID_zespol AND Narodowosc = ID_kraj AND Pozycja = poz_skrot;";
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

                          $plik = '../img/players/'.$file_name.'.png';
                          $test = file_exists($plik);

                          if(!$test) {
                              echo '<img class="playerPicSmall" src="../img/default_player.png">';
                          } else {
                              echo '<img class="playerPicSmall" src="../img/players/'.$file_name.'.png" >';
                          }

                          ?>
                              <a href="index.php?go=player&id=<?php echo $id; ?>"><?php echo $row["Imie"]; ?> <?php echo $row["Nazwisko"]; ?></a>

                              <span class="tooltiptextP">
                                  <img class="tooltipIMG" src="../img/players/<?php echo $file_name; ?>.png" >
                              </span>
                          </div>
                          </td>
                      <td><img class="nationPic" align="middle" src="../img/flags/<?php echo $row["ID_kraj"]; ?>.png" >
                          <?php echo $row["kr_nazwa"]; ?></td>
                      <td><?php echo $row["poz_nazwa"]; ?></td>
                      <td><?php echo $row["Data_urodzenia"]; ?></td>
                      <td><?php echo $row["Wzrost"]; ?> cm</td>
                      <td><a href="#"><?php echo $row["zes_nazwa"]; ?></a></td>
                      <td><i class="fa fa-fw fa-pencil-square-o"></i> <i class="fa fa-fw fa-times"></i></td>
                  </tr>
                  <?php $count++; } ?>




              </tbody>
            </table>
          </div>
        </div>
      </div>
