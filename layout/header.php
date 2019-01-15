<?php //echo $_SESSION['page']; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>HIPAAComplete</title>  
  <link rel="shortcut icon" type="image/png" href="https://hipaadev.us/favicon.ico"/>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/css/all.css">
  <!-- Bootstrap 4 -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">

  <!-- DataTable -->
  <link href="assets/css/datatables.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

  <!--Navbar-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark primary-color indigo fixed-top scrolling-navbar">

    <!-- Navbar brand -->
    <a class="navbar-brand" href="#">HIPPA</a>

    <!-- Collapse button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
      aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapsible content -->
    <div class="collapse navbar-collapse" id="basicExampleNav">

      <!-- Links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item  <?php if ($_SESSION['page'] === 'index') echo 'active' ?>">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item  <?php if ($_SESSION['page'] === 'leads') echo 'active' ?>">
          <a class="nav-link" href="leads.php">Leads</a>
        </li>
        <?php if (!isset($_SESSION['user'])) {?>
          <li class="nav-item  <?php if ($_SESSION['page'] === 'login') echo 'active';?>">
            <a class="nav-link" href="login.php" >Login</a>
          </li>
        <?php } else {?>
          <!-- Profile -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            <i class="fas fa-user"></i> Profile </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-info" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item waves-effect waves-light"><?=$_SESSION['user']?></a>
              <a class="dropdown-item waves-effect waves-light" href="logout.php">Log out</a>
            </div>
          </li>
        <?php }?>
      </ul>     
    </div>
    <!-- Collapsible content -->
  </nav>
  <!--/.Navbar-->

  <!-- Spiner -->
  <div class="animationload">
      <div class="osahanloading"></div>
  </div>

