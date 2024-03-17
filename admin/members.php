<?php

session_start();
// print_r($_SESSION);
if(isset($_SESSION['username']))
{
    $page_title = 'members';
    include 'init.php';

    $open = '';
    if(isset($_GET['open'])){
        $open = $_GET['open'];
    }
    else{
        $open = 'Manage';
    }



    if($open == 'Manage' ){
        
        if(isset($_GET['admins'])){

            ?>
        <h1 class="text-center">Manage Admins</h1>
        
        <div class="text-center">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td>#ID</td>
                        <td>Username</td>
                        <td>Email</td>
                        <td>Full Name</td>
                        <td>Control</td>
                    </tr>
                    <?php

                        $stmt=$db->prepare("SELECT * from users WHERE admin = 1");
                        $stmt->execute();
                        $users=$stmt->fetchAll();

                        foreach ($users as $row ) {
                            ?>
                                <tr>
                                    <td><?= $row['user_id'];?></td>
                                    <td><?= $row['username'];?></td>
                                    <td><?= $row['email'];?></td>
                                    <td><?= $row['name'];?></td>
                                    
                                    <td>
                                        <a href="members.php?open=Edit&userid=<?=$row['user_id'];?>" class="btn btn-success">Edit</a>
                                        <a href="members.php?open=Delete&userid=<?=$row['user_id'];?>" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                                
                                <?php
                        }
                        ?>
                   
                </table>
                <a href="?open=Add"  class="btn btn-primary">Add New Admin </a>
                
            </div>
        </div>
        
        <?php
    }elseif(isset($_GET['users']))
    {
        ?>
        <h1 class="text-center">Manage Users</h1>
        
        <div class="text-center">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td>#ID</td>
                        <td>Username</td>
                        <td>Email</td>
                        <td>Full Name</td>
                        <td>Control</td>
                    </tr>
                    <?php

                        $stmt=$db->prepare("SELECT * from users WHERE admin = 0");
                        $stmt->execute();
                        $users=$stmt->fetchAll();

                        foreach ($users as $row ) {
                            ?>
                                <tr>
                                    <td><?= $row['user_id'];?></td>
                                    <td><?= $row['username'];?></td>
                                    <td><?= $row['email'];?></td>
                                    <td><?= $row['name'];?></td>
                                    
                                    <td>
                                        <a href="members.php?open=Edit&userid=<?=$row['user_id'];?>" class="btn btn-success">Edit</a>
                                        <a href="members.php?open=Delete&userid=<?=$row['user_id'];?>" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                                
                                <?php
                        }
                        ?>
                   
                </table>
                <a href="?open=Add"  class="btn btn-primary">Add New Admin </a>
                
            </div>
        </div>
        <?php
    }
    }
    elseif($open == 'Edit'){
        
        if(isset($_GET['userid']))
        {
            $stmt=$db->prepare('SELECT * FROM users WHERE user_id = ?');
            $stmt->execute([$_GET['userid']]);
            $user = $stmt->fetch();
            $exist = $stmt->rowCount();
        }
        if($exist)
        {

            ?>
            <h1 class="text-center"> Edit Profile</h1>
            <div class="container">
                <form action="members.php?open=Update" method="POST" >
                    <input type="hidden" name="id" value="<?= $_GET['userid']?>">
                    <div class="mb-3">
                        <label for="Username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="Username" placeholder="Username" name="username" value="<?= $user['username'] ;?>"  required="required">
                    </div>
                    <div class="mb-3">
                        <label for="Password" class="form-label">Password</label>
                        <input type="text" class="form-control" id="Password" placeholder="Leave it Blank If you Don't want to Change It " name="password" >
                    </div>
                    <div class="mb-3">
                        <label for="Email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="Email" placeholder="Email" name="email" value="<?= $user['email'] ;?>" required="required">
                    </div>
                    <div class="mb-3">
                        <label for="Full Name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="Full Name" placeholder="Full Name" name="full_name" value="<?= $user['name'] ;?>" required="required">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
            
            <?php
        }
        else
        {
            redirect_home("this id isn't exist" );
        }
    }
    elseif($open == 'Update'){

        echo "<h1 class='text-center'> Update Member </h1>";
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if(check_exist_in_DB("username" , "users" , $_POST['username'] ))
            {
                ?>
                <div class="alert alert-danger" role="alert">
                        this username already exist!
                </div>
            <?php
            header("refresh:2;url={$_SERVER['HTTP_REFERER']}");
            exit();
                
            }


            $stmt=$db->prepare('UPDATE users set username = ? , email = ? , name = ? where user_id = ?');
            $stmt->execute([$_POST['username'] ,$_POST['email']  , $_POST['full_name'] , $_POST['id'] ]);

            if($stmt->rowCount())
            {
                echo '<div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Data Updated Successfully!</h4>
                </div>';

            }
            else{
                echo' <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>No Data Changed!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
            if($_POST['password'] != '')
            {
                $stmt=$db->prepare('UPDATE users set password = ? where user_id = ?');
                $stmt->execute([sha1($_POST['password']) , $_POST['id'] ]);
            }
        }
        else{
            redirect_home("you are not authorized to open this page" );
        }
    }
    elseif($open == 'Add'){
        ?>
        <h1 class="text-center">Add New Admin</h1>
                <div class="container">
                    <form action="?open=Insert" method="POST" >
                        <div class="mb-3">
                            <label for="Username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="Username" placeholder="Username" name="username"  required="required">
                        </div>
                        <div class="mb-3">
                            <label for="Password" class="form-label">Password</label>
                            <input type="text" class="form-control" id="Password" placeholder="password " name="password" required="required">
                        </div>
                        <div class="mb-3">
                            <label for="Email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="Email" placeholder="Email" name="email"  required="required">
                        </div>
                        <div class="mb-3">
                            <label for="Full Name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="Full Name" placeholder="Full Name" name="full_name"  required="required">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>

        <?php
        


    }
    elseif($open == 'Insert')
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $username = $_POST['username'];
            $password = sha1($_POST['password']);
            $email = $_POST['email'];
            $name = $_POST['full_name'];
            
            if(check_exist_in_DB("username" , "users" , $_POST['username'] ) )
            {
                ?>
                <div class="alert alert-danger" role="alert">
                        this username already exist!
                </div>
                <?php

                header("refresh:2;url={$_SERVER['HTTP_REFERER']}");
                exit();
            }

            $stmt=$db->prepare('INSERT INTO users (username , email , name , password , admin) values ( ? , ? , ? , ? , 1)');
            $stmt->execute([$username , $email , $name , $password ]);

            echo '<div class="alert alert-success" role="alert">
                <h4 class="alert-heading">New Admin Added Successfully!</h4>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            header("refresh:1;url={$_SERVER['HTTP_REFERER']}");
            exit();
        }
        else{
            
            redirect_home("there is no data to insert" );
        }
    }
    elseif($open == 'Delete'){
        
        $stmt=$db->prepare('DELETE FROM users WHERE user_id = ?');
        $stmt->execute([$_GET['userid']]);
        echo '<div class="alert alert-success" role="alert">
                <h4 class="alert-heading">The Admin Deleted Successfully!</h4>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        header("refresh:1;url={$_SERVER['HTTP_REFERER']}");
        exit();

    }

    include 'includes\templates\footer.php';
}
else
{
    header('location: index.php');
    exit();
}

?>