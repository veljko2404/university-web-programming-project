<?php

    require_once '../user_type.php';
    require_once '../database/connection.php';
    require_once '../classes/seller.php';

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

    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['sallary']) && isset($_POST['contract_duration']) && isset($_POST['menager_id'])){
        $seller = new Seller($_POST['username'],md5($_POST['password']),$_POST['sallary'],$_POST['contract_duration'],$_POST['menager_id'],$conn);
        if($seller->addToDatabase()){
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
    <title>Sellers</title>
    <?php require_once '../mdb.php'; ?>
</head>
<body style="background-color:#f2f2f27d;">
    <script>
        <?php
            if(isset($added)){
                if($added){
                    echo 'alert("Seller added!")';
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
    <div class="container">
        <h2 class="text-center" style="margin-top:30px;">Sellers:</h2>
        <table class="table table-striped text-center" style="margin:30px 0;">
            <tr>
                <th>Username</th>
                <th>Sallary</th>
                <th>Work from</th>
                <th>Contract duration</th>
                <th>Menager ID</th>
            </tr>
            <?php
                $q = "SELECT * FROM sellers";
                $result = $conn->query($q);
                while($row = $result->fetch_assoc()){
            ?>
            <tr>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['sallary']; ?></td>
                <td><?php echo $row['work_from']; ?></td>
                <td><?php echo $row['contract_duration_months']; ?></td>
                <td><?php echo $row['menager_id']; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
    <hr>
    <div class="container" style="margin-bottom:80px;max-width:500px;">
        <form action="index.php" method="post">
            <h3 class="text-center">Add new seller:</h3>
            <div class="form-outline" style="margin-top:20px;border:1px solid grey; border-radius:5px;">
                <input type="text" name="username" d="form2" class="form-control" />
                <label class="form-label" for="form12">Username</label>
            </div>
            <div class="form-outline" style="margin-top:20px;border:1px solid grey; border-radius:5px;">
                <input type="text" name="password" id="form3" class="form-control" />
                <label class="form-label" for="form3">Password</label>
            </div>
            <div class="form-outline" style="margin-top:20px;border:1px solid grey; border-radius:5px;">
                <input type="number" name="sallary" id="form4" class="form-control" />
                <label class="form-label" for="form4">Sallary</label>
            </div>
            <div class="form-outline" style="margin-top:20px;border:1px solid grey; border-radius:5px;">
                <input type="number" name="contract_duration" id="form4" class="form-control" />
                <label class="form-label" for="form4">Contract Duration</label>
            </div>
            <div class="form-outline" style="margin-top:20px;border:1px solid grey; border-radius:5px;">
                <input type="number" name="menager_id" id="form4" class="form-control" />
                <label class="form-label" for="form5">Menager ID</label>
            </div>
            <input value="CREATE" type="submit" style="margin-top:20px;" class="btn btn-primary btn-block mb-4">
        </form>
    </div>
    <?php require_once '../footer.php'; ?>
</body>
</html>