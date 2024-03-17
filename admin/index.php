<?php 
    $no_navbar =1;
    $page_title ='Login';

    session_start();
    if(isset($_SESSION['admin']))
    {
        header('location: dashboard.php');
        exit();
    }
    
    include 'init.php';
    

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $username = $_POST['user'];
        $password = sha1( $_POST['pass']);
        

        $stmt = $db->prepare('SELECT * FROM users WHERE username = ? AND password = ? AND admin = 1');
        $stmt->execute([$username , $password]);
        $count = $stmt->rowCount();
        $user = $stmt->fetch();

        if($count)
        {
            $_SESSION['username'] = $username;
            $_SESSION['name'] =$user['name'];
            $_SESSION['email'] =$user['email'];
            $_SESSION['id'] =$user['user_id'];
            header('location: dashboard.php');
            exit();
        }
        else{
            ?>
                <div class="alert alert-danger" role="alert">
                        Wrong Username Or Password
                </div>
            <?php
        }
    }
    
?>


    <form method="post" action="<?php $_SERVER['PHP_SELF'] ;?>" class="login">
        <h4 class="text-center" >Admin Login</h4>
        <input class="form-control" type="text" name="user" placeholder="Username" />
        <input class="form-control" type="password" name="pass" placeholder="Password" />
        <input class="btn btn-primary btn-block" type="submit" value="login" />
    </form>
    


<?php 
    include "includes/templates/footer.php";
?>