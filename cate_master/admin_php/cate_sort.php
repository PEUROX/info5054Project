<?php

include 'conn.php';

if($conn->connect_errno){

    $err = "Error: ".$db_conn->connect_error;
    echo $err;
    exit;
}

if ($_POST['cate_sel']=='cate_name'){

    $qry_name = "SELECT * FROM category_master ORDER BY cate_name";

    $result = $conn->query($qry_name);

    while($row = mysqli_fetch_array($result)){
    
        $cate_id = $row["category_id"];
        $cate_name = $row['cate_name'];
        $cate_des = $row['description'];
        $created_by = $row['created_by'];
        $cate_datetime=$row['created_datetime'];
    
       
    
        $return_arr[] = array("cate_id" => $cate_id,
                        "cate_name" => $cate_name,
                        "cate_des"=>$cate_des,
                        "created_by" => $created_by,
                        "cate_datetime" => date($cate_datetime));
    }

    echo json_encode($return_arr);
}

if ($_POST['cate_sel']=='cate_admin'){

    $qry_name = "SELECT * FROM category_master ORDER BY created_by";

    $result = $conn->query($qry_name);

    while($row = mysqli_fetch_array($result)){
    
        $cate_id = $row["category_id"];
        $cate_name = $row['cate_name'];
        $cate_des = $row['description'];
        $created_by = $row['created_by'];
        $cate_datetime=$row['created_datetime'];
    
       
    
        $return_arr[] = array("cate_id" => $cate_id,
                        "cate_name" => $cate_name,
                        "cate_des"=>$cate_des,
                        "created_by" => $created_by,
                        "cate_datetime" => date($cate_datetime));
    }

    echo json_encode($return_arr);
}

if ($_POST['cate_sel']=='cate_date'){

    $qry_name = "SELECT * FROM category_master ORDER BY created_datetime DESC";

    $result = $conn->query($qry_name);

    while($row = mysqli_fetch_array($result)){
    
        $cate_id = $row["category_id"];
        $cate_name = $row['cate_name'];
        $cate_des = $row['description'];
        $created_by = $row['created_by'];
        $cate_datetime=$row['created_datetime'];
    
       
    
        $return_arr[] = array("cate_id" => $cate_id,
                        "cate_name" => $cate_name,
                        "cate_des"=>$cate_des,
                        "created_by" => $created_by,
                        "cate_datetime" => date($cate_datetime));
    }

    echo json_encode($return_arr);
}

?>

