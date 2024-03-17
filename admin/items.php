<?php

    session_start();
    $page_title = 'Items';

    if(isset($_SESSION['name']))
    {
        include 'init.php';

        $open = isset($_GET['open']) ? $_GET['open'] : 'Manage';

        if($open == 'Manage'){



                ?>
            <h1 class="text-center">Manage Items</h1>

            <div class="text-center">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <td>#ID</td>
                            <td>name</td>
                            <td>description</td>
                            <td>price</td>
                            <td>control</td>
                            
                        </tr>
                        <?php

                    
                            $stmt=$db->prepare("SELECT * from items ");
                            $stmt->execute();
                            $items=$stmt->fetchAll();

                            foreach ($items as $row ) {
                                ?>
                                    <tr>
                                        <td><?= $row['item_id'];?></td>
                                        <td><?= $row['name'];?></td>
                                        <td><?= $row['description'];?></td>
                                        <td><?= $row['price'];?></td>
                                        
                                        <td>
                                        <a href="items.php?open=Edit&item_id=<?=$row['item_id'];?>" class="btn btn-success">Edit</a>
                                        <a href="items.php?open=Delete&item_id=<?=$row['item_id'];?>" class="btn btn-danger">Delete</a>
                                       
                                        </td>
                                    </tr>

                                <?php
                            }
                        ?>
                    
                    </table>
                    <a href="?open=Add"  class="btn btn-primary">Add New Item</a>
                    
                </div>
            </div>
            
            <?php





        }elseif($open == 'Add')
        {
            ?>
            <h1 class="text-center">Add New Item</h1>
                    <div class="container">
                        <form action="?open=Insert" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="Name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="Username" placeholder="Name" name="name"  required="required">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <input type="text" class="form-control" id="Pasdescriptionsword" placeholder="Description " name="description" required="required">
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="text" class="form-control" id="price" placeholder="Price" name="price"  required="required">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">image</label>
                                <input type="file" class="form-control" id="image"  name="image"  required="required">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
    
            <?php
        }elseif ($open == 'Insert') {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];

            $image_name= rand(0 , 10000000) . $_FILES['image']['name'];
            $image_size= $_FILES['image']['size'];
            $image_tmp =$_FILES['image']['tmp_name'];
            
            $image_path = "images/".$image_name;
            move_uploaded_file( $image_tmp , "../images/".$image_name );
            

            $stmt=$db->prepare('INSERT INTO items (name , description , price , image ) values ( ? , ? , ? ,? )');
            $stmt->execute([$name , $description , $price , $image_path ]);

            echo '<div class="alert alert-success" role="alert">
                <h4 class="alert-heading">New Item Added Successfully!</h4>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            header("refresh:.3;url={$_SERVER['HTTP_REFERER']}");
            exit();
    






            

        }
        else{
            
            redirect_home("there is no data to insert" );
        }
    } elseif($open == 'Edit'){


        if(isset($_GET['item_id']))
        {
            $stmt=$db->prepare('SELECT * FROM items WHERE item_id = ?');
            $stmt->execute([$_GET['item_id']]);
            $item= $stmt->fetch();
            $exist = $stmt->rowCount();
        }
        if($exist)
        {

            ?>
            <h1 class="text-center"> Edit Item</h1>
            <div class="container">
                <form action="items.php?open=Update" method="POST" >
                    <input type="hidden" name="item_id" value="<?= $_GET['item_id']?>">
                    <div class="mb-3">
                        <label  class="form-label">name</label>
                        <input type="text" class="form-control"  name="name" value="<?= $item['name'] ;?>"  required="required">
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">desctiption</label>
                        <input type="text" class="form-control"   name="desctiption" value="<?= $item['description'] ;?>"  required="required">
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">price</label>
                        <input type="text" class="form-control"   name="price" value="<?= $item['price'] ;?>" required="required">
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

    }elseif($open == 'Update')
    {
        echo "<h1 class='text-center'> Update Item </h1>";
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
        
            $stmt=$db->prepare('UPDATE items set name = ? , description = ? , price = ? where item_id = ?');
            $stmt->execute([$_POST['name'] ,$_POST['desctiption']  , $_POST['price'] , $_POST['item_id'] ]);

            if($stmt->rowCount())
            {
                echo '<div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Data Updated Successfully!</h4>
                </div>';

                header('refresh:1;url=items.php');

            }
            else{
                echo' <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>No Data Changed!</strong>
                </div>';
                header('refresh:1;url=items.php');
            }
        }
        else{
            redirect_home("you are not authorized to open this page" );
        }
    }
    elseif($open == 'Delete'){
        
        $stmt=$db->prepare('DELETE FROM items WHERE item_id = ?');
        $stmt->execute([$_GET['item_id']]);
        header('location: items.php');
        exit();
        }



        include 'includes\templates\footer.php';
    }
    else{
        header('location: index.php');
        exit();
    }