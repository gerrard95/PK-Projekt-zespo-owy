<?php
//include auth.php file on all secure pages
include("include/auth.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Panel Administracyjny - Internetowa baza zawodwników i zespołów siatkarskich</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  
  <link rel="stylesheet" href="css/bootstrap-select.css">
  
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="index.php">Panel Administracyjny - Internetowa baza zawodwników i zespołów siatkarskich</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item <?php $go = $_GET['go']; if(!$go){echo 'active';} ?>" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="index.php">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Start</span>
          </a>
        </li>
        <li class="nav-item <?php $go = $_GET['go']; if($go=='players' || $go=='player-add' || $go=='player'){echo 'active';} ?>" data-toggle="tooltip" data-placement="right" title="Zawodnicy">
          <a class="nav-link" href="index.php?go=players">
            <i class="fa fa-fw fa-user-circle"></i>
            <span class="nav-link-text">Zawodnicy</span>
          </a>
        </li>
        <li class="nav-item <?php $go = $_GET['go']; if($go=='teams'){echo 'active';} ?>" data-toggle="tooltip" data-placement="right" title="Zespoły">
          <a class="nav-link" href="index.php?go=teams">
            <i class="fa fa-fw fa-shield"></i>
            <span class="nav-link-text">Zespoły</span>
          </a>
        </li>
        <li class="nav-item <?php $go = $_GET['go']; if($go=='competitions'){echo 'active';} ?>" data-toggle="tooltip" data-placement="right" title="Rozgrywki">
          <a class="nav-link" href="index.php?go=competitions">
            <i class="fa fa-fw fa-table"></i>
            <span class="nav-link-text">Rozgrywki</span>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Wyloguj</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="content-wrapper">
    <div class="container-fluid">
      <?php $go = $_GET['go'];
					if(!empty($go)) {
					if(is_file("include/$go.php")) include "include/$go.php";
					else echo "<title>VM Database</title><br/> Błąd, strona nie istnieje..."; }
					else include "include/home.php";
			?>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © Internetowa baza zawodwników i zespołów siatkarskich 2018</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Czy na pewno chcesz się wylogować?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Wybierz "Wyloguj", jeśli chcesz zakończyć bieżącą sesję.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Anuluj</button>
            <a class="btn btn-primary" href="include/logout.php">Wyloguj</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>
    <script src="js/sb-admin-charts.min.js"></script>
  </div>
  
</body>

</html>
