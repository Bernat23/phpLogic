<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <title>PHPògic</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Juga al PHPògic.">
    <link href="//fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<?php

if($_SERVER["REQUEST_METHOD"] = "GET") {
    if(isset($_GET["sol"])){
        foreach($_SESSION["solucions"] as $funcio){
            echo $funcio . " ";
        }
    }
    if(isset($_GET["neteja"])) {
        session_unset();
    }
}

if(isset($_GET["data"])){
    srand(seed($_GET["data"]));
    $_SESSION['data'] = $_GET["data"];
    obtenirLletres();
}
elseif(!isset($_SESSION['data'])) {
        $_SESSION['data'] = date('m-d-y');
        srand(seed($_SESSION['data']));
        obtenirLletres();

} elseif ($_SESSION['data'] != date('m-d-y')) {
    session_unset();
    $_SESSION['data'] = date('m-d-y');
    srand(seed($_SESSION['data']));
    obtenirLletres();

}

//Funció que agafa totes les funcions definides de php per defecte
function obtenirFuncions() {
    $funcions = get_defined_functions();
    return $funcions["internal"];
    
}

//Obté lletres aleatories depenent de la seed de cada dia
function obtenirLletres() {
    $alfabet = ["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","_","0","1","2","3","4","5","6","7","8","9"];
    $composenFuncions = false;
    while(!$composenFuncions) {
        $lletres = array();
        for($i = 0; $i < 7; ++$i){
            $lletra = "";
            do {
                $lletra = $alfabet[rand() % 37];
            }while(in_array($lletra, $lletres));
                $lletres[] = $lletra;
           
        }
        $composenFuncions = composen3Funcions($lletres);
    }
    $_SESSION['lletres'] = $lletres;
}


/*Comprova que les lletres poden formar 3 funcions si no es així es tornarà a cridar
un cop generades les noves lletres*/
function composen3Funcions($lletres) {
    $funcionsArray = obtenirFuncions();
    $comptador = 0;
    foreach($funcionsArray as $funcions => $funcio){
        $caracters = str_split($funcio);
        $validar = true;
        foreach($caracters as $char){ //mira caracter per caracter si està incluit a l 'array
            if($validar == false) {
            } else {
                $validar = in_array($char, $lletres);
                if($validar){
                    $validar = in_array($lletres[3], $caracters);
                }
            }
        }
        if($validar){
            $comptador++;
            $_SESSION["funcions"][] = $funcio;
        }
    }
    if($comptador < 3){
        unset($_SESSION["funcions"]);
        return false;
    } else {
        $_SESSION["solucions"] = $_SESSION["funcions"];
        return true;
    }

}

//funcio per escollir una seed depenent del dia
function seed($data){
    $data = strtotime($data);
    return $data;
}

//barreja les lletres menys la del mig
function barrejar() {
    $array = $_SESSION["lletres"];
    unset($_SESSION["lletres"]);
    $guardar = $array[3];
    unset($array[3]);
    shuffle($array);
    $array[3] = $guardar;
    $_SESSION["lletres"] = $array;
}
?>
<body data-joc="2022-10-07">
<form method="post" name="myform" id="myform" action="process.php">
<div class="main">
    <h1>
        <a href=""><img src="logo.png" height="54" class="logo" alt="PHPlògic"></a>
    </h1>
    <div class="container-notifications">
        <!-- <p display=none class="hide" id="message" >La funció de PHP no existeix</p> -->
    </div>
    <div class="cursor-container">
        <p id="input-word"><span id="test-word"></span><span id="cursor">|</span></p>
        <input type="hidden" name="paraula" id="paraula">
    </div>
    <div class="container-hexgrid">
        <ul id="hex-grid">
            <li class="hex">
                <div class="hex-in"><a class="hex-link" data-lletra=<?php echo $_SESSION['lletres'][0]; ?> draggable="false"><p><?php echo $_SESSION['lletres'][0]; ?></p></a></div>
            </li>
            <li class="hex">
                <div class="hex-in"><a class="hex-link" data-lletra=<?php echo $_SESSION['lletres'][1]; ?> draggable="false"><p><?php echo $_SESSION['lletres'][1]; ?></p></a></div>
            </li>
            <li class="hex">
                <div class="hex-in"><a class="hex-link" data-lletra=<?php echo $_SESSION['lletres'][2]; ?> draggable="false"><p><?php echo $_SESSION['lletres'][2]; ?></p></a></div>
            </li>
            <li class="hex">
                <div class="hex-in"><a class="hex-link" data-lletra=<?php echo $_SESSION['lletres'][3]; ?> draggable="false" id="center-letter"><p><?php echo $_SESSION['lletres'][3]; ?></p></a></div>
            </li>
            <li class="hex">
                <div class="hex-in"><a class="hex-link" data-lletra=<?php echo $_SESSION['lletres'][4]; ?> draggable="false"><p><?php echo $_SESSION['lletres'][4]; ?></p></a></div>
            </li>
            <li class="hex">
                <div class="hex-in"><a class="hex-link" data-lletra=<?php echo $_SESSION['lletres'][5]; ?> draggable="false"><p><?php echo $_SESSION['lletres'][5]; ?></p></a></div>
            </li>
            <li class="hex">
                <div class="hex-in"><a class="hex-link" data-lletra=<?php echo $_SESSION['lletres'][6]; ?> draggable="false"><p><?php echo $_SESSION['lletres'][6]; ?></p></a></div>
            </li>
        </ul>
    </div>
    <div class="button-container">
        <button id="delete-button" type="button" title="Suprimeix l'última lletra" onclick="suprimeix()"> Suprimeix</button>
        <button id="shuffle-button" type="button" class="icon" aria-label="Barreja les lletres" title="Barreja les lletres">
            <svg width="16" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 512 512">
                <path fill="currentColor"
                      d="M370.72 133.28C339.458 104.008 298.888 87.962 255.848 88c-77.458.068-144.328 53.178-162.791 126.85-1.344 5.363-6.122 9.15-11.651 9.15H24.103c-7.498 0-13.194-6.807-11.807-14.176C33.933 94.924 134.813 8 256 8c66.448 0 126.791 26.136 171.315 68.685L463.03 40.97C478.149 25.851 504 36.559 504 57.941V192c0 13.255-10.745 24-24 24H345.941c-21.382 0-32.09-25.851-16.971-40.971l41.75-41.749zM32 296h134.059c21.382 0 32.09 25.851 16.971 40.971l-41.75 41.75c31.262 29.273 71.835 45.319 114.876 45.28 77.418-.07 144.315-53.144 162.787-126.849 1.344-5.363 6.122-9.15 11.651-9.15h57.304c7.498 0 13.194 6.807 11.807 14.176C478.067 417.076 377.187 504 256 504c-66.448 0-126.791-26.136-171.315-68.685L48.97 471.03C33.851 486.149 8 475.441 8 454.059V320c0-13.255 10.745-24 24-24z"></path>
            </svg>
        </button>
        <button id="submit-button" type="submit" title="Introdueix la paraula">Introdueix</button>
    </div>
    <div class="scoreboard">
        <div>Has trobat <span id="letters-found"><?php if(isset($_SESSION["comptador"])){
            echo $_SESSION["comptador"];
        } else {
            echo 0;
        }  ?></span> <span id="found-suffix">funcions</span><span id="discovered-text">.</span>
        </div>
        <div id="score"><?php
        echo "Comptador: ";
        if(isset($_SESSION["comptador"])){
            echo $_SESSION["comptador"];
        } else {
            echo 0;
        }
        ?></div>
        <div id="level"><?php if(isset($_SESSION["funcionsTrobades"])){
            echo "Les funcions trobades son: ";
            foreach($_SESSION["funcionsTrobades"] as $trobades){
                echo $trobades . "  ";
            }                            
        } ?></div>
        <div id="error"><?php if(isset($_SESSION["error"])) {echo $_SESSION["error"];unset($_SESSION["error"]);} ?></div>
    </div>
</div>
</form>
<script>
    
    function amagaError(){
        if(document.getElementById("message"))
            document.getElementById("message").style.opacity = "0"
    }
    function afegeixLletra(lletra){
        document.getElementById("test-word").innerHTML += lletra;
        document.getElementById("paraula").value += lletra;
    }
    function suprimeix(){
        document.getElementById("test-word").innerHTML = document.getElementById("test-word").innerHTML.slice(0, -1)
        document.getElementById("paraula").value = document.getElementById("paraula").value.slice(0,-1);
    }
    window.onload = () => {
        // Afegeix funcionalitat al click de les lletres
        document.getElementById("paraula").value = "";
        Array.from(document.getElementsByClassName("hex-link")).forEach((el) => {
            el.onclick = ()=>{afegeixLletra(el.getAttribute("data-lletra"))}
        })
        setTimeout(amagaError, 2000)
        //Anima el cursor
        let estat_cursor = true;
        setInterval(()=>{
            document.getElementById("cursor").style.opacity = estat_cursor ? "1": "0"
            estat_cursor = !estat_cursor
        }, 500)
    }
</script>
</body>
</html>

<?php

?>