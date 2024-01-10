<?php

    require_once '../user_type.php';
    require_once '../database/connection.php';
    require_once '../classes/car.php';

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
    
    if($user == UserType::Seller || $user == UserType::Guest || $user == UserType::Customer){
        header("Location: ../");
    }
    
    if(isset($_POST['make']) && isset($_POST['model']) && isset($_POST['price']) && isset($_POST['year']) && isset($_POST['number_of_available']) && isset($_FILES["image"])){
        $image_file = $_FILES["image"];
        move_uploaded_file(
            $image_file["tmp_name"],
            "../images/" . $image_file["name"]
        );
        $car = new Car($_POST['make'],$_POST['model'],$_POST['price'],$_POST['year'],$_POST['number_of_available'],$image_file["name"],$conn);
        if($car->insertToDatabase()){
            $added = true;
        } else {
            $added = false;
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menagers</title>
    <?php require_once '../mdb.php'; ?>
</head>
<body style="background-color:#f2f2f27d;">
    <script>
        <?php
            if(isset($added)){
                if($added){
                    echo 'alert("Car added!")';
                } else {
                    echo 'alert("Problem occured!")';
                }
            }
        ?>
    </script>
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
                <a class="navbar-brand mt-2 mt-lg-0" href="../">
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
                            <a class="dropdown-item" href="../profile">Profile</a>
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
    <div class="container" style="max-width:500px;">
        <h2 class="text-center" style="margin-top:30px;">Add new car:</h2>
        <form action="index.php" method="post" enctype="multipart/form-data">
            <div class="form-outline" style="margin-top:20px;border:1px solid grey; border-radius:5px;">
                <input type="text" name="make" id="form2" class="form-control" />
                <label class="form-label" for="form12">Make</label>
            </div>
            <div class="form-outline" style="margin-top:20px;border:1px solid grey; border-radius:5px;">
                <input type="text" name="model" id="form3" class="form-control" />
                <label class="form-label" for="form3">Model</label>
            </div>
            <div class="form-outline" style="margin-top:20px;border:1px solid grey; border-radius:5px;">
                <input type="number" name="year" id="form4" class="form-control" />
                <label class="form-label" for="form4">Year</label>
            </div>
            <div class="form-outline" style="margin-top:20px;border:1px solid grey; border-radius:5px;">
                <input type="number" name="price" id="form4" class="form-control" />
                <label class="form-label" for="form4">Price</label>
            </div>
            <div class="form-outline" style="margin-top:20px;border:1px solid grey; border-radius:5px;">
                <input type="number" name="number_of_available" id="form4" class="form-control" />
                <label class="form-label" for="form5">Number of available</label>
            </div>
            <div class="form-outline" style="margin-top:20px;border:1px solid grey; border-radius:5px;">
                <input accept="image/*" type="file" name="image" id="image" class="form-control" /> 
            </div>
            <input value="ADD" type="submit" style="margin-top:20px;" class="btn btn-primary btn-block mb-4">
        </form>
    </div>
    <?php require_once '../footer.php'; ?>
</body>
</html>