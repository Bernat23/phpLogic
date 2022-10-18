<?php
session_start();
if(isset($_POST["paraula"])){
    $comptador = 0;
    foreach($_SESSION["funcions"] as $funcio) {
        if(strcmp($funcio, $_POST["paraula"]) == 0){
            $_SESSION["funcionsTrobades"][] = $funcio; 
            unset($_SESSION["funcions"][$comptador]);
            if(!isset($_SESSION["comptador"])) {
                $_SESSION["comptador"] = 1;
            } else {
                $_SESSION["comptador"]++;
            }
        } elseif(!str_contains($_POST["paraula"], $_SESSION["lletres"][3])){
            $_SESSION["error"] = "Falta la lletra del mig";
        } elseif(isset($_POST["funcionsTrobades"])) {
            $trobada = false;
            foreach($_POST["funcionsTrobades"] as $trobada){
                if((strcmp($paraula, $trobada) == 0)) {
                    $trobada = true;
                }
                if($trobada){
                    $_SESSION["error"] = "La paraula està repetida";
                } else {
                    $_SESSION["error"] = "La funcio no existeix";
                }
            }  
        }else {
            $_SESSION["error"] = "La funcio no existeix";
        }
        $comptador++;
    }
    $_SESSION["funcions"] = array_values($_SESSION["funcions"]);
    print_r($_SESSION["lletres"]);
    header("Location:index.php", true, 302);
}

?>