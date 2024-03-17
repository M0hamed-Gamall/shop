<?php

    function gettitle(){

        global $page_title;

        if(isset($page_title))
        {
            echo $page_title;
        }
        else{
           
        }
    }

///////////////////////////////////////////////////////
    function redirect_home($msg , $sec = 3){
        ?>
        <div class="alert alert-danger" role="alert">
            <?= $msg ;?>
        </div>
        <div class="alert alert-primary" role="alert">
            <?php echo "you will redirected to home after $sec" ;?>
        </div>
        <?php
        header("refresh:$sec;url=index.php");
    }

/////////////////////////////////////////////////////////////////////
    function check_exist_in_DB($select , $table , $value){
        global $db;
        $check=$db->prepare("SELECT $select FROM $table WHERE $select = ?");
        $check->execute([$value]);
        $exist=$check->rowCount();

        return $exist ;
    }
//////////////////////////////////////////////////////////////////
    function count_items($column , $table ,$condition=''){
        global $db;
        $stmt=$db->prepare("SELECT COUNT($column) FROM $table $condition");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
//////////////////////////////////////////////////////////////////
    function get_latest( $column ,$table , $order , $num=3){
        global $db;
        $stmt=$db->prepare("SELECT $column FROM $table ORDER BY $order desc LIMIT $num ");
        $stmt->execute();

        $row = $stmt->fetchAll();
        return $row;
    }
