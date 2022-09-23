<!DOCTYPE html>
<html lang="fr" dir="ltr" class="sid-plesk">
<head>
    <title>Emploi Du Temps | L3 Miage</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=3.5, minimum-scale=0.5">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta property="og:site_name" content="L3 Miage | Orléans">
    <meta name="description" content="Voici l'emploi du temps des L3 Miage d'Orléans">
    <link href="img/l3_.png" rel="shortcut icon">
    <link rel="stylesheet" href="style.css">
    <meta property="og:image" content="img/l3large.png" />
    <meta name="theme-color" content="#07a89e"/>
    <link rel="apple-touch-icon" sizes="128x128" href="img/l3large.png">
</head>
<body>
<?php
    function groupeID(){
        if(isset($_POST['tpGrp'])){
            switch($_POST['tdGrp']){
                case 0:
                    $val = "37172%2C37171%2C31260%2C31223%2C69178%2C31339";
                    break;
                case 1:
                    $val = "37171%2C31260%2C31223%2C69178%2C31339";
                    break;
                case 2:
                    $val = "37172%2C31260%2C31223%2C69178%2C31339";
                    break;
            }
            switch($_POST['tpGrp']){
                case 0:
                    $val .= "%2C50166%2C50167%2C26013%2C34655";
                    break;
                case 1:
                    $val .= "%2C50166";
                    break;
                case 2:
                    $val .= "%2C50167";
                    break;
                case 3:
                    $val .= "%2C26013";
                    break;
                case 4:
                    $val .= "%2C34655";
                    break;
            }
        }
        else{
            $val = "37171%2C37172%2C50166%2C50167%2C26013%2C34655%2C31260%2C31223%2C69178%2C31339";
        }
        $_COOKIE['grp'] = $val;
        return $val;
    }
    function generateIdentifier(){
        $ch = curl_init("https://aderead.univ-orleans.fr/jsp/custom/modules/plannings/direct_planning.jsp?days=0%2C1%2C2%2C3%2C4%2C5&displayConfName=ENT&height=700&login=etuWeb&password=&projectId=3&resources=2278&showOptions=false&showPianoDays=false&showPianoWeeks=false&showTree=false&weeks=4");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $response = curl_exec($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        curl_close($ch);
        $JSESSIONID = explode("=", explode(":", explode(";", $header)[2])[2])[1];

        $ch = curl_init("https://aderead.univ-orleans.fr/jsp/custom/modules/plannings/imagemap.jsp?clearTree=true&width=150&height=150"); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Cookie: JSESSIONID='.$JSESSIONID
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        return explode("&", explode("identifier=",$response)[1])[0];
    }

?>
<div id="mainContent">
    <div class="header">
        <a href="index.php">
            <img alt="logo" src="img/l3_b.png" class="logo"></img>
        </a>   
    </div>
        <form class="center form" method="POST" action="index.php">
            <label for="tdGrp">Semaine
                    <?php
                    date_default_timezone_set('Europe/Paris');
                    $date = date("Y-m-d H:i:s");
                    $week = date("W", strtotime($date));
                    $year = date("Y", strtotime($date));
                    echo '<input onchange="this.form.submit()" value="'.(
                        !isset($_POST['week'])?
                        $year.'-W'.(
                            strlen($week)<2?
                            '0'+$week
                            :
                            $week
                        ):
                        $_POST['week']).'" type="week" name="week" id="camp-week" min="'.$year.'-W33" max="'.($year+1).'-W30" required>';
                    if($week < 33){
                        $year -= 1 ;
                    }
                    else{
                        $week -= 33 ;
                    }
                    if(isset($_POST['week'])){
                        $week = explode("-W", $_POST['week'])[1];
                        if($week < 33){
                            $week += 33;
                        }
                        else{
                            $week -= 33;
                        }
                    }

                    ?>
                </label>
            <label for="tdGrp">TD
            <select name="tdGrp">
                <option value="0" <?php if(!isset($_POST['tdGrp'])){echo'selected';} ?>></option>
                <option value="1" <?php if(isset($_POST['tdGrp']) && $_POST['tdGrp'] == 1){echo'selected';} ?>> Grp 1</option>
                <option value="2" <?php if(isset($_POST['tdGrp']) && $_POST['tdGrp'] == 2){echo'selected';} ?>> Grp 2</option>
            </select>
            </label>
            <label for="tpGrp">TP
            <select name="tpGrp">
                <option value="0" <?php if(!isset($_POST['tpGrp'])){echo'selected';} ?>></option>
                <option value="1" <?php if(isset($_POST['tpGrp']) && $_POST['tpGrp'] == 1){echo'selected';} ?>> Grp 1</option>
                <option value="2" <?php if(isset($_POST['tpGrp']) && $_POST['tpGrp'] == 2){echo'selected';} ?>> Grp 2</option>
                <option value="3" <?php if(isset($_POST['tpGrp']) && $_POST['tpGrp'] == 3){echo'selected';} ?>> Grp 3</option>
                <option value="4" <?php if(isset($_POST['tpGrp']) && $_POST['tpGrp'] == 4){echo'selected';} ?>> Grp 4</option>
            </select>
            </label>
            <button class="btnsubmit" type="submit">Valider</button>
        </form>
        <hr>
    <div class="maincontent">
        <div class="contenthead">
            <div>
                <h1 style="font-size: 22px;margin-bottom: 0px">📅 Emploi Du Temps :</h1>
                <p style="margin-left: 35px;"><i><?php if(isset($_POST['tdGrp'])){ ?> TD Groupe <?= $_POST['tdGrp'] ?> </i>|<i> TP Groupe <?= $_POST['tpGrp'] ?> <?php } ?></i></p>
            </div>
            <div class="contenthead">
                <a class="basebutton"  href="today.php">Aujourd'hui</a>
            </div>
        </div>
        <div class="center" id="edtContainer">
         
        </div>
    </div>
</div>

</div>
<div class="centeritem">
<a href="https://github.com/LeMustelide/EmploisDuTemps_Univ-Orleans" target="_blank" style="text-decoration:none;">
    <div class="cards">
     Tu souhaites nous aider ? Viens soumettre tes idées et correctifs depuis le <u>GitHub du projet</u> !
    </div>
</a>
</div>
</body>
<script type="application/javascript">
    var div = document.getElementById("edtContainer");
    console.log(div);
    var height = document.documentElement.clientHeight;
    var width = document.documentElement.clientWidth;
    if(width<height){
        width = height;
    }
    div.innerHTML = `<img class="edt" alt="edt" src="https://aderead.univ-orleans.fr/jsp/imageEt?identifier=<?= generateIdentifier() ?>&projectId=3&idPianoWeek=<?= $week ?>&idPianoDay=0%2C1%2C2%2C3%2C4&idTree=<?= groupeID() ?>&width=${width}&height=${height}&lunchName=REPAS&displayMode=1057855&showLoad=false&ttl=1662920359936&displayConfId=169"></img>`
</script>
<footer class="center">
    <p>Réalisé par <a href="https://marcvirgili.fr" target="_blank">Marc Virgili</a> & <a href="https://lykos.vortexdev.fr/" target="_blank">LyKøs</a></p>
</footer>
</html>
