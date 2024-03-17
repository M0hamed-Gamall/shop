<?php
ob_start();
    session_start();
    $page_title ='Login';
    include 'init.php';
?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mt-5">Login</h2>
                <div class="card my-3">
                    <div class="card-body">
                        <form method="POST" action="?login=1" autocomplete="off">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>
                <div class="text-center">
                    Don't have an account? <a href="signup.php">Sign up</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
    <div class="row">
        <div class="col-md-6 col-lg-4 mx-auto">
            <!-- Card -->
            <div class="card custom-card">
                <!-- Card Header -->
                <div class="custom-card-header">
                    Use this take admin privilage
                </div>
                <!-- Card Body -->
                <div class="card-body custom-card-body">
                    <p class="custom-card-text">Email : admin@a.com</p>
                    <p class="custom-card-text">Password : 123</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php


if(isset($_GET['login']))
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $email=$_POST['email'];
            $pass= sha1($_POST['password']);
            $stmt=$db->prepare('SELECT * FROM users WHERE email = ? AND password = ?');
            $stmt->execute([$email ,$pass]);
            $user=$stmt->fetch();

            if($stmt->rowCount()){

                $_SESSION['user']='loged in';
                $_SESSION['name']=$user['name'];
                $_SESSION['email']=$email;
                $_SESSION['id'] =$user['user_id'];

                if($user['admin'] == 1){
                    $_SESSION['admin']='admin';
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['name'] =$user['name'];
                    $_SESSION['email'] =$user['email'];
                    $_SESSION['id'] =$user['user_id'];
                    header('location: admin');
                    exit();
                }else
                header('location: index.php');
                exit();

            }else{
                ?>
                <div class="alert alert-danger" role="alert" id="alertMessage">
                    Wrong Username Or Password
                </div>

            <?php
            }
            

        }
    }
    ?>
        <script src="script.js"></script>
    <?php

    include 'includes/templates/footer.php';
    ob_end_flush();