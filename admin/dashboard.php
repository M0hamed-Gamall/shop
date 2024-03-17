<?php
    session_start();
    if(isset($_SESSION['username']))
    {
        $page_title = 'Dashboard';
        include 'init.php';
        
        
        //////////////////////////////////////
        ?>

        <div class="container">
            
            <h1>Dashboard</h1>
                
            <div class="container py-5">
                <div class="row">
                    
                    <div class="col-md-4">
                        <div class="count-card admins-count">
                            <i class="fas fa-user-shield"></i>
                            <h5>Total Admins</h5>
                            <p>
                                <a href="members.php?admins" class="text-white">
                                    <?php echo count_items("user_id", "users", "WHERE admin=1"); ?>
                                </a>
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="count-card users-count">
                            <i class="fas fa-users"></i>
                            <h5>Total Normal Users</h5>
                            <p>
                                <a href="members.php?users" class="text-white">
                                    <?php echo count_items("user_id", "users" ,"WHERE admin=0"); ?>
                                </a>
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="count-card items-count">
                            <i class="fas fa-box-open"></i>
                            <h5>Total Items</h5>
                            <p>
                                <a href="items.php" class="text-white">
                                    <?php echo count_items("item_id", "items"); ?>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
        
        <?php
        ///////////////////////////////////

        include 'includes\templates\footer.php';
    }
    else
    {
        header('location: index.php');
    }

    
?>