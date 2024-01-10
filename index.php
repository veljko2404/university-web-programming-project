<?php

    require_once 'user_type.php';
    require_once 'database/connection.php';

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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Dealership</title>
    <?php require_once 'mdb.php'; ?>
    <script src="javascript/login.js" type="text/javascript"></script>
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
                    src="images/logo.png"
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
                            <a class="nav-link" href="menagers">Menagers</a>
                        </li>
                        <?php } ?>
                        <?php if ($user == UserType::Menager || $user == UserType::Admin) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="sellers">Sellers</a>
                        </li>
                        <?php } ?>
                        <?php if ($user == UserType::Menager || $user == UserType::Admin || $user == UserType::Seller) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="customers">Customers</a>
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
                            <a class="dropdown-item" href="profile">Profile</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="login/logout.php">Log Out</a>
                        </li>
                        <?php if($user == UserType::Admin || $user == UserType::Menager) { ?>
                        <li>
                            <a class="dropdown-item" href="add_car">Add new car</a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <?php } ?>
            </div>
        </div>
    </nav>
    <div class="container text-center" style="margin-top:30px;">
        <?php
        $q = "SELECT * FROM cars";
        $result = $conn->query($q);
        if($result->num_rows > 0){
            ?>
        <div class="row">
            <div class="col-sm-2">Make</div>
            <div class="col-sm-2">Model</div>
            <div class="col-sm-2">Year</div>
            <div class="col-sm-2">Price</div>
            <div class="col-sm-2">Number of available</div>
            <div class="col-sm-2">Image</div>
        </div> <hr>
            <?php
        }
        while($row = $result->fetch_assoc()){
        ?>
        <div class="row">
            <div class="col-sm-2"><?php echo $row['make']; ?></div>
            <div class="col-sm-2"><?php echo $row['model']; ?></div>
            <div class="col-sm-2"><?php echo $row['year']; ?></div>
            <div class="col-sm-2"><?php echo $row['price']; ?></div>
            <div class="col-sm-2"><?php echo $row['number_of_available']; ?></div>
            <div class="col-sm-2"><img width="100%" src="images/<?php echo $row['image']; ?>" alt=""> </div>
        </div> 
        <?php } ?>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Login to your account</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-outline mb-4">
                        <input type="text" name="username" id="username" class="form-control" />
                        <label class="form-label" for="form2Example1">Username</label>
                    </div>

                    <div class="form-outline mb-4">
                        <input type="password" name="password" id="password" class="form-control" />
                        <label class="form-label" for="form2Example2">Password</label>
                    </div>

                    <div class="d-flex justify-content-center mb-4" style="margin-bottom:15px !important">
                        <p id="login_status"></p>
                    </div>

                    <button id="login" onclick="login()" class="btn btn-primary btn-block mb-4">LOGIN</button>

                    <div class="text-center">
                        <p>Not a member? <a href="register">Register</a></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'footer.php'; ?>
</body>
</html>