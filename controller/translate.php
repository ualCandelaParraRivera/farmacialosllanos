<?php include ("main.php");
if(isset($_POST['tag']) && isset($_POST['es']) && isset($_POST['en'])){
    $tag = $_POST['tag'];
    $es = $_POST['es'];
    $en = $_POST['en'];
    for($i = 0; $i < count($tag); $i++) {
        $query = "SELECT id FROM etiqueta WHERE tag = ? AND idioma = 'es'";
        $res = $db->prepare($query, array($tag[$i]));
        $row = mysqli_fetch_array($res);
        $query = "UPDATE etiqueta SET texto = ? WHERE id = ? AND idioma = 'es'";
        $db->prepare($query, array($es[$i],$row['id']));

        $query = "SELECT id FROM etiqueta WHERE tag = ? AND idioma = 'en'";
        $res = $db->prepare($query, array($tag[$i]));
        $row = mysqli_fetch_array($res);
        $query = "UPDATE etiqueta SET texto = ? WHERE id = ? AND idioma = 'en'";
        $db->prepare($query, array($en[$i],$row['id']));
    }
}
?>