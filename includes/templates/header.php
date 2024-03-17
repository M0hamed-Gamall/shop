<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php gettitle();?> </title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- For FontAwesome 6 -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

        <!-- OR For FontAwesome 5 -->
        <link href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" rel="stylesheet">
        

        
        <link rel="stylesheet" href="layout\css\backend.css" />
        
    </head>
    <body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item d-flex align-items-center">
                <a class="nav-link text-success d-flex align-items-center" href="index.php">
                    <h1>Shop</h1>
                    <i class="fa-solid fa-cart-shopping fa-3x"></i>
                </a>
            </li>
            </ul>
            <form class="d-flex me-auto">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            <ul class="navbar-nav">
                <?php if(isset($_SESSION['user'])){
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link" href="my account.php">';
                        echo "<h3>".$_SESSION['name']."</h3>";
                    echo '</a>' ;
                    echo '</li>';
                    
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link" href="logout.php">';
                        echo "<h3>Logout</h3>";
                    echo '</a>' ;
                    echo '</li>';
                    if(isset($_SESSION['admin'])){

                        ?>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="admin"><h3>Return As Admin</h3></a>
                    </li>

                    
                    <?php
                }
                }
                else{

                    ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php"><h1>Login</h1></a> 
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="signup.php"><h1>Signup</h1></a> 
                </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>



