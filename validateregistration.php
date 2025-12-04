<?php include ("controller/main.php");
if(!isset($_GET['guiduser']) || empty($_GET['guiduser'])){
    redirect("404");
}else{
    $guiduser = $_GET['guiduser'];
    $query = "SELECT id FROM user WHERE guiduser = ? AND isdeleted = 0 AND isvalid = 0";
    $res=$db->prepare($query,array($guiduser));
    if($db->numRows($res) > 0){
        $row = mysqli_fetch_array($res);
        $id = $row['id'];
        $query = "UPDATE user SET isvalid = 1 WHERE id = ?";
        $db->prepare($query,array($id));
        redirect("login");
    }else{
        redirect("403");
    }
}
?>