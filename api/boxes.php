<?php
if ($method == 'GET') // check the box state
{

        $data = DB::query("SELECT * FROM $tableName WHERE idBox=:idBox and idCasier=:idCasier", array(':idBox' => $numBox,':idCasier'=>$numcasier));
        if ($data != null) {
            echo json_encode($data[0]);
        } else {
            echo json_encode(['message' => 'BOX Not Found.']);
    }
} elseif ($method == 'POST') // add colis to the box
{
    if ($_POST != null) {
        extract($_POST);
        $colis_longeur=0;//from another api
        $colis_largeur=0;//from another api
        $colis_hauteur=0;//from another api
        $data = DB::query("SELECT * FROM `box` WHERE idBox=:idBox and idCasier=:idCasier", array(':idBox' => $idBox,':idCasier'=>$idCasier));
        $etat = $data[0]['etat'];
        $longeur=$data[0]['longeur'];
        $largeur=$data[0]['largeur'];
        $hauteur=$data[0]['hauteur'];
       if(($etat=="vide")&&($colis_longeur<$longeur)&&($colis_largeur<$largeur)&&($colis_hauteur<$hauteur)) {
              DB::query("INSERT INTO $tableName VALUES
                        (:idCasier,:idBox, :idColis,null, :idActeur, :typeActeur, :typeOperation)",
                  array(':idCasier' => $idCasier, ':idBox' => $idBox, ':idColis' => $idColis, ':idActeur' => $idActeur, ':typeActeur' => $typeActeur,"typeOperation"=>$typeOperation));
              DB::query("UPDATE `box` SET `etat` = 'plein'  WHERE idBox=:idBox and idCasier=:idCasier", array(':idBox' => $idBox, ':idCasier' => $idCasier));
              $data = DB::query("SELECT * FROM $tableName ");
              echo json_encode(['message' => 'colis added to the box successfully ', 'success' => true, 'table' => $data[0]]);
          }else{echo json_encode(['message' => 'le box est deja occupe ou plus petit que la taille du colis', 'success' => false]);
       }
    } else {
        echo json_encode(['message' => 'Please pill in all the credentials', 'success' => false]);
    }

}
elseif ($method == 'DELETE') //retrieve the colis from the box
{
    parse_str(file_get_contents("php://input"),$post_vars);
    $idColis= $post_vars['idColis'];
    $data = DB::query("SELECT `idCasier`,`idBox` FROM $tableName WHERE idColis=:idColis", array(':idColis' => $idColis));
    $idCasier = $data[0]['idCasier'];
    $idBox = $data[0]['idBox'];
    DB::query("DELETE FROM $tableName WHERE idColis=:idColis", array(':idColis' => $idColis));
    echo json_encode(['message' => 'Post Deleted successfully', 'success' => true]);
    DB::query("UPDATE `box` SET `etat` = 'vide'  WHERE idBox=:idBox and idCasier=:idCasier", array(':idBox' => $idBox, ':idCasier' => $idCasier));

}
