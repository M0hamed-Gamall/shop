<?php 
    ob_start();
   session_start();
   $page_title = 'Shop';
   include 'init.php';
   if(isset($_SESSION['name'])){
?>
    <div class="container" >
        <h1 class="text-center">Welcom To Our Shop</h1>
        <div class="row ">
            <?php
                $allItems = $db->prepare('SELECT * FROM items');
                $allItems->execute();
                foreach ($allItems as $item) {
                    ?>

                        <div class="card  m-3" style="width: 18rem;">
                            <img src="<?= $item['image'] ;?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?=$item['name'] ;?></h5>
                                <p class="card-text"><?= $item['description'];?></p>
                                <h4 class="card-title"><?=$item['price'] ;?></h4>
                                <a href="?add=<?=$item['item_id'] ;?>" class="btn btn-primary">Add To Cart</a>
                            </div>
                        </div>
                        <?php
                }
                ?>
        </div>
    </div>
    <?php

    if(isset($_GET['add']))
    {
        $stmt=$db->prepare('SELECT * FROM items WHERE item_id = ?');
        $stmt->execute([$_GET['add']]);
        if($stmt->rowCount()){
            $item=$stmt->fetch();
            
            $stmt=$db->prepare('INSERT INTO user_items (for_user , price , image , item_id , name) VALUES ( ? , ? , ?, ? , ?)');
            $stmt->execute([$_SESSION['id'] , $item['price'] , $item['image'] ,$_GET['add'] , $item['name']]);
            header('location: index.php');
            exit();
            
        }
        else{
            header('location: index.php');
            exit();
        }
    }
    }
    else{
        header('location: login.php');
        exit();
    }




    include "includes/templates/footer.php";
    ob_end_flush();
?>


