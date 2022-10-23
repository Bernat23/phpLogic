<?php
session_start();
if(isset($_POST["paraula"])){
    $comptador = 0;
    $parar = false;
    array_values($_SESSION["funcions"]);
    foreach($_SESSION["funcions"] as $funcio) {
        if(strcmp($funcio, $_POST["paraula"]) == 0){
            $_SESSION["funcionsTrobades"][] = $funcio;  
            unset($_SESSION["funcions"][$comptador]);
            if(!isset($_SESSION["comptador"])) {
                $_SESSION["comptador"] = 1;
            } else {
                $_SESSION["comptador"]++;
            }
            $parar = true;
            $_SESSION["error"] = "";
        } elseif(!str_contains($_POST["paraula"], $_SESSION["lletres"][3])){
            $_SESSION["error"] = "Falta la lletra del mig";
            $parar = true;
        } elseif(isset($_SESSION["funcionsTrobades"])) {
            foreach($_SESSION["funcionsTrobades"] as $trobada){
                if((strcmp($_POST["paraula"], $trobada) == 0)) {
                    $_SESSION["error"] = "La paraula està repetida";
                    $parar = true;
                    break;
                }
                 else {
                    $_SESSION["error"] = "La funcio no existeix";
                }
            }  
        }else {
            $_SESSION["error"] = "La funcio no existeix";
        }
        $comptador++;
        if($parar) {
            echo $_SESSION["error"];
            break;
        }
    }
}


if(empty($_SESSION["funcions"])){
    $_SESSION["error"] = "Ja tens totes les funcions";
}
if($_SESSION['data'] != date('m-d-y')){
    header("Location:index.php?data=" . $_SESSION["data"], true, 302);
    echo $_SESSION["data"];  
} else {
    header("Location:index.php", true, 302);
}

?>