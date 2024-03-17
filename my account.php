<?php
    ob_start();
    session_start();
    $page_title = 'My Account';


    

    if(isset($_SESSION['user'])){

        include 'init.php';
        if(isset($_GET['delete']))
        {
            $stmt=$db->prepare('DELETE FROM user_items WHERE for_user = ? AND item_id = ? ');
            $stmt->execute([$_SESSION['id'] ,$_GET['delete'] ] );
        }
        
?>
        <div class="container py-5">
            <div class="row">
                <div class="col-md-8 col-lg-6 mx-auto">
                    <div class="card">
                        <h5 class="card-header">Account Information</h5>
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" value="<?=$_SESSION['name']  ;?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" value="<?=$_SESSION['email']  ;?>" readonly>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php 

            $stmt=$db->prepare('SELECT * FROM user_items WHERE for_user = ?');
            $stmt->execute([$_SESSION['id']]);
            $items=$stmt->fetchAll();

            $total_price=0;
                ?>
                    <div class="container py-5">
                        <div class="row">
                            <h1 class="text-center">My Cart</h1>
                            <?php foreach($items as $item): 
                                $total_price += filter_var($item['price'], FILTER_SANITIZE_NUMBER_INT);
                                ?>
                                <div class="col-md-2"> <!-- Adjust column size as needed -->
                                    <div class="card smaller-card">
                                        <img src="<?=$item['image'];?>" class="card-img-top" alt="Product Image">
                                        <div class="card-body">
                                            <h5 class="card-title"><?=$item['name'];?></h5>
                                            <p class="card-text"><?=$item['price'];?></p>
                                            <a class="btn btn-danger" href="?delete=<?=$item['item_id'] ;?>">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="container py-5">
                        <div class="d-flex align-items-center">
                            <div class="me-2"> <!-- Adjusted spacing here -->
                                <h2 class="mb-0">Total Price Is <?= $total_price;?> $</h2>
                            </div>
                            <div>
                                <a type="button" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>
                    </div>   
                <?php

            }
    else{
        ?>
        <div class="alert alert-danger" role="alert">
             You Haven't an Account
        </div>
        <?php
    }

    


    include 'includes\templates\footer.php';
    ob_end_flush(); // Send output buffer and turn off buffering

    