<?php //echo $_SESSION['page']; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>HIPPA Login Page</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="assets/mdbootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="assets/mdbootstrap/css/mdb.min.css" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="assets/mdbootstrap/css/style.css" rel="stylesheet">
</head>
<body>
  <!--Navbar-->
  <nav class="navbar navbar-expand-lg navbar-dark primary-color">

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
      <ul class="navbar-nav mr-auto">
        <li class="nav-item  <?php if ($_SESSION['page'] === 'index') echo 'active' ?>">
          <a class="nav-link" href="index.php">Home</a>
        </li>
      </ul>
      <!-- Links -->

      <ul class="navbar-nav mr-right">
        <?php if (!isset($_SESSION['user'])) {?>
          <li class="nav-item  <?php if ($_SESSION['page'] === 'login') echo 'active' ?>">
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
        <li class="nav-item">
          <!-- <a class="nav-link" href="logout.php">Logout</a> -->
        </li>
        <?php }?>
      </ul>
    </div>
    <!-- Collapsible content -->
  </nav>
  <!--/.Navbar-->
