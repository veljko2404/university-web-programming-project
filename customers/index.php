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
    if($user == UserType::Guest || $user == UserType::Customer){
        header("Location: ../");
    }

    if(isset($_POST['discount'])){
        $q = "UPDATE customers SET discount = ".$_POST['discount']." WHERE id=".$_POST['id'];
        if($conn->query($q)){
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
    <title>Customers</title>
    <?php require_once '../mdb.php'; ?>
</head>
<body style="background-color:#f2f2f27d;">
    <script>
        <?php
            if(isset($added)){
                if($added){
                    echo 'alert("Discount added!")';
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
                        <?php if ($user == UserType::Menager || $user == UserType::Admin) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../sellers">Sellers</a>
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
        <h2 class="text-center" style="margin-top:30px;">Customers:</h2>
        <table class="table table-striped text-center" style="margin:30px 0;">
            <tr>
                <th>Name</th>
                <th>Username</th>
                <th>Discount</th>
                <th>Number of bought cars</th>
                <th>Add discount</th>
            </tr>
            <?php
                $q = "SELECT * FROM customers";
                $result = $conn->query($q);
                while($row = $result->fetch_assoc()){
                    $q = "SELECT * FROM sold_cars WHERE customers_id=".$row['id'];
                    $number = $conn->query($q)->num_rows;
            ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['discount']; ?>%</td>
                <td><?php echo $number; ?></td>
                <td><button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#Modal<?php echo $row['id']; ?>">Add discount</button></td>
            </tr>
            <div class="modal fade" id="Modal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add discount for <?php echo $row['username']; ?></h5>
                            <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <div class="form-outline mb-4">
                            <form action="index.php" method="post">
                                <input style="display:none;" type="number" name="id" value="<?php echo $row['id']; ?>">
                                <input type="number" id="form5Example2" name="discount" class="form-control"  style="margin-top:20px;border:1px solid grey; border-radius:5px;"/>
                                <label class="form-label" for="form5Example2">Amount of discount</label>
                                <button style="margin-top:30px;" type="submit" class="btn btn-primary btn-block mb-4">Add discount</button>
                            </form>
                        </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </table>
    </div>
    <?php require_once '../footer.php'; ?>
</body>
</html>