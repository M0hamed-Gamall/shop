<?php
ob_start();
     session_start();
     $page_title ='Sing UP';
    include 'init.php';
?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mt-5">Signup</h2>
                <div class="card my-3">
                    <div class="card-body">
                        <form method="POST" action="?login=2" autocomplete="off">
                            <div class="mb-3">
                                <label for="Name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirmPassword" name="con-password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                        </form>
                    </div>
                </div>
                <div class="text-center">
                    Already have an account? <a href="login.php">Login</a>
                </div>
            </div>
        </div>
    </div>


    <?php

        if(isset($_GET['login']) )
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                if($_POST['password'] != $_POST['con-password'] ){
                    ?>
                    <div class="alert alert-danger" role="alert" id="alertMessage">
                        two password don't match
                    </div>
                    <?php
                }else{

                    $name=$_POST['name'];
                    $email=$_POST['email'];
                    $pass=sha1( $_POST['password']);
                    
                    $name = filter_var($name, FILTER_SANITIZE_STRING);
                    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

                    $stmt=$db->prepare('INSERT INTO users (name , email , password ,username) VALUES (? , ? , ? , now() )');
                    $stmt->execute([$name , $email ,$pass ]);

                    $stmt=$db->prepare('SELECT user_id FROM users WHERE email = ?');
                    $stmt->execute([$email]);
                    $user=$stmt->fetch();
                    
                    $_SESSION['user']='loged in';
                    $_SESSION['name']=$name;
                    $_SESSION['email']=$email;
                    $_SESSION['id']=$user['user_id'];
                    
                    header('location: index.php');
                }
            }
        }
        ?>
        <script src="script.js"></script>
        <?php
    include 'includes/templates/footer.php';
    ob_end_flush(); 
