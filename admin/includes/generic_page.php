<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Sistema de gestión de incidencias</title>
  <!-- Bootstrap core CSS-->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="../css/sb-admin.css" rel="stylesheet">
<script src="../vendor/jquery/jquery.min.js"></script>
<link href="../vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <script type="text/javascript" language="javascript" src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script type="text/javascript" class="init">
</script>

</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav" > 
    
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">      
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="column">
            <div class="navbar-brand"><a href="mostrar.php"><img src="../images/pixel.jpg" style="border-radius: 50%;" width="80px"></img></a></div>    
        </li>  
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="incidencias informáticas">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-wrench"></i>
            <span class="nav-link-text">incidencias informáticas</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseMulti">
            <li>
              <a href="#">software</a>
            </li>
            <li>
              <a href="#">hardware</a>
            </li>
              </ul>
            </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="gestión de usuarios">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMultiUsers" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-users"></i>
            <span class="nav-link-text">gestión de usuarios</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseMultiUsers">
            <li>
              <a href="#">altas</a>
            </li>
            <li>
              <a href="#">bajas</a>
            </li>
            <li>
              <a href="#">cambio de status</a>
            </li>
              </ul>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="administrar incidencias">
              <a class="nav-link" href="../mostrar.php">
                <i class="fa fa-fw fa-cogs"></i>
                <span class="nav-link-text">ver mis incidencias</span>
              </a>
            </li>


          </ul>
        </li>
      </ul>




      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto ">
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Logout</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card mb-3">



