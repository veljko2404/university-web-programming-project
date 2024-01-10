<?php

    require_once '../user_type.php';
    require_once '../database/connection.php';

    ob_start();
    session_start();

    $user = UserType::Guest;
    if(isset($_SESSION['status'])){
        if($_SESSION['status'] == "customer"){
            $user = UserType::Customer;
        } else if($_SESSION['status'] == "seller") {
            $user = UserType::Seller;
        } else if($_SESSION['status'] == "menager") {
            $user = UserType::Menager;
        } else if($_SESSION['status'] == "admin"){
            $user = UserType::Admin;
        }
    }

    if($user == UserType::Guest){
        header("Location: ../");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers</title>
    <?php require_once '../mdb.php'; ?>
</head>
<body style="background-color:#f2f2f27d;">
    <nav class="navbar navbar-expand-sm navbar-light bg-white">
        <div class="container">
            <button
            class="navbar-toggler"
            type="button"
            data-mdb-toggle="collapse"
            data-mdb-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <a class="navbar-brand mt-2 mt-lg-0" href="#">
                    <img
                    src="../images/logo.png"
                    height="41"
                    alt="Logo"
                    loading="lazy"/>
                </a>
                <?php if($user != UserType::Guest) { ?>
                <ul style="margin-bottom:0 !important;" class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if($user == UserType::Customer){ ?>
                    <li class="nav-item">
                    <a class="nav-link" href="#">Bought cars</a>
                    </li>
                    <?php } else { ?>
                        <?php if ($user == UserType::Admin) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../menagers">Menagers</a>
                        </li>
                        <?php } ?>
                        <?php if ($user == UserType::Menager || $user == UserType::Admin) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../sellers">Sellers</a>
                        </li>
                        <?php } ?>
                        <?php if ($user == UserType::Menager || $user == UserType::Admin || $user == UserType::Seller) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../customers">Customers</a>
                        </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
                <?php } ?>
            </div>
            <div class="d-flex align-items-center">
                <?php if($user == UserType::Guest) { ?>
                <button type="button" class="btn btn-link px-3 me-2" data-mdb-toggle="modal" data-mdb-target="#exampleModal">
                Login
                </button>
                <?php } else { ?>
                <div class="dropdown">
                    <a
                    class="link-secondary me-3 dropdown-toggle hidden-arrow"
                    href="#"
                    id="navbarDropdownMenuLink"
                    role="button"
                    data-mdb-toggle="dropdown"
                    aria-expanded="false">
                        <i class="fas fa-user"></i>
                    </a>
                    <ul
                    class="dropdown-menu dropdown-menu-end"
                    aria-labelledby="navbarDropdownMenuLink">
                        <li>
                            <a class="dropdown-item" href="">Profile</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="../login/logout.php">Log Out</a>
                        </li>
                    </ul>
                </div>
                <?php } ?>
            </div>
        </div>
    </nav>
    <div class="container" style="margin-top:30px;">
        <h2 class="text-center">Your profile:</h2>
        <h4 class="text-center">Username: <?php echo $_SESSION['username']; ?></h4>
    </div>
</body>
</html>