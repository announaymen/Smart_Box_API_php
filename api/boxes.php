<?php
if ($method == 'GET') {

        $data = DB::query("SELECT * FROM $tableName WHERE idBox=:idBox and idCasier=:idCasier", array(':idBox' => $numBox,':idCasier'=>$numcasier));
        if ($data != null) {
            echo json_encode($data[0]);
        } else {
            echo json_encode(['message' => 'BOX Not Found.']);
    }
} elseif ($method == 'POST') {
    if ($_POST != null) {
        extract($_POST);
        $data = DB::query("SELECT `etat` FROM `box` WHERE idBox=:idBox and idCasier=:idCasier", array(':idBox' => $idBox,':idCasier'=>$idCasier));
        $etat = $data[0]['etat'];
       if($etat=="inactif") {
           DB::query("INSERT INTO $tableName VALUES
                     (:idCasier,:idBox, :idColis, :idVendeur, :idLivreur, null,null)", array(':idCasier' => $idCasier, ':idBox' => $idBox, ':idColis' => $idColis, ':idVendeur' => $idVendeur, ':idLivreur' => $idLivreur));
           DB::query("UPDATE `box` SET `etat` = 'actif'  WHERE idBox=:idBox and idCasier=:idCasier", array(':idBox' => $idBox, ':idCasier' => $idCasier));
           $data = DB::query("SELECT * FROM $tableName ");
           echo json_encode(['message' => 'colis added to the box successfully ', 'success' => true, 'post' => $data[0]]);
       }else{ echo 'le box est deja occupé';}
    } else {
        echo json_encode(['message' => 'Please pill in all the credentials', 'success' => false]);
    }
}
