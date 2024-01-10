<?php

    require_once '../user_type.php';
    require_once '../database/connection.php';
    require_once '../classes/customer.php';

    ob_start();
    session_start();

    $user = UserType::Guest;
    if(isset($_SESSION['status'])){
        header("Location: ../");
    }

    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['name'])){
        
        $customer = new Customer($_POST['name'], $_POST['username'], $_POST['password'], 0, $conn);

        $errMsg = $customer->validate();
        if($errMsg == ""){
            if($customer->insertToDatabase()){
                $errMsg = "Success";
            } else {
                $errMsg = "Error occured!";
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Dealership</title>
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
                        <?php if ($user == UserType::Admin) { ?>
                        <li class="nav-item">
                        <a class="nav-link" href="#">Menagers</a>
                        </li>
                        <?php } ?>
                        <?php if ($user == UserType::Menager || $user == UserType::Admin) { ?>
                        <li class="nav-item">
                        <a class="nav-link" href="#">Sellers</a>
                        </li>
                        <?php } ?>
                        <?php if ($user == UserType::Menager || $user == UserType::Admin || $user == UserType::Seller) { ?>
                        <li class="nav-item">
                        <a class="nav-link" href="#">Customers</a>
                        </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
                <?php } ?>
            </div>
            <div class="d-flex align-items-center">
                <?php if($user == UserType::Guest) { ?>
                <a href="../" class="btn btn-link px-3 me-2">
                go back
                </a>
                <?php } else {} ?>
            </div>
        </div>
    </nav>
    <div class="container">
        <form action="index.php" method="post" style="max-width:300px;margin:50px auto;">
        
            <div class="form-outline mb-4">
                <input type="text" name="name" id="form5Example3" class="form-control" />
                <label class="form-label" for="form5Example3">Name</label>
            </div>

            <div class="form-outline mb-4">
                <input type="text" name="username" id="form5Example2" class="form-control" />
                <label class="form-label" for="form5Example2">Username</label>
            </div>

            <div class="form-outline mb-4">
                <input name="password" type="password" id="form5Example1" class="form-control" />
                <label class="form-label" for="form5Example1">Password</label>
            </div>

            <div class="form-check d-flex justify-content-center mb-4">
                <input class="form-check-input me-2" type="checkbox" value="" id="form5Example3" checked />
                <label class="form-check-label" for="form5Example3">
                I have read and agree to the terms
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-block mb-4">REGISTER</button>
            <p class="text-center <?php if(isset($errMsg)){if($errMsg == "Success"){ echo "text-success"; } else { echo "text-danger"; } }?>"><?php if(isset($errMsg)){ echo $errMsg; } ?></p>
        </form>
    </div>
    <?php require_once '../footer.php'; ?>
</body>
</html>