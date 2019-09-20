<?php
if ($method == 'GET') {
    if ($numBox && $numcasier) {
        $data = DB::query("SELECT * FROM $tableName WHERE idBox=:idBox and idCasier=:idCasier", array(':idBox' => $numBox,':idCasier'=>$numcasier));
        if ($data != null) {
            echo json_encode($data[0]);
        } else {
            echo json_encode(['message' => 'BOX Not Found.']);
        }
    } else {
        $data = DB::query("SELECT * FROM $tableName");
        echo json_encode($data);
    }
} elseif ($method == 'POST') {
    if ($_POST != null) {
        extract($_POST);
        DB::query("INSERT INTO $tableName VALUES
                 (:idCasier,:idBox, :idColis, :idVendeur, :idLivreur, null,null)",array(':idCasier' => $idCasier, ':idBox' => $idBox, ':idColis' => $idColis,':idVendeur' => $idVendeur,':idLivreur' => $idLivreur));
        $data = DB::query("SELECT * FROM $tableName ");
        echo json_encode(['message' => 'colis added to the box successfully ', 'success' => true, 'post' => $data[0]]);
    } else {
        echo json_encode(['message' => 'Please pill in all the credentials', 'success' => false]);
    }
}

