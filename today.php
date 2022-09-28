<!DOCTYPE html>
<html lang="fr" dir="ltr" class="sid-plesk">
<head>
    <title>Aujourd'hui | L3 Miage</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=3.5">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta property="og:site_name" content="L3 Miage | Orléans">
    <meta name="description" content="Voici l'emploi du temps d'Aujourd'hui des L3 Miage d'Orléans">
    <link href="img/l3_.png" rel="shortcut icon">
    <link rel="stylesheet" href="style.css">
    <meta property="og:image" content="img/l3large.png" />
    <meta name="theme-color" content="#07a89e"/>
    <link rel="apple-touch-icon" sizes="128x128" href="img/l3large.png">
</head>
<div id="mainContent">
    <div class="header">
        <img src="img/l3_b.png" class="logo"></img>
    </div>
    <form class="center form" method="POST" action="index.php">
            <label for="tdGrp">SEM
                    <?php
                    date_default_timezone_set('Europe/Paris');
                    $date = date("Y-m-d H:i:s");
                    $week = date("W", strtotime($date));
                    $year = date("Y", strtotime($date));
                    if(isset($_SERVER['HTTP_USER_AGENT'])){
                        $agent = $_SERVER['HTTP_USER_AGENT'];
                    }
                    if(strlen(strstr($agent,"Chrome")) > 0){
                        $browser = 'Chrome';
                    }
                    if($browser!='Chrome'){
                        echo '<select style="text-align-last: center;" name="semaine">';
                        
                        date_default_timezone_set('Europe/Paris');
                        $date = date("Y-m-d H:i:s");
                        $week = date("W", strtotime($date)) - 33;
                        $year = date("Y", strtotime($date));
                        for($i = 0; $i<53; $i++){
                            $monday = new DateTime;
                            $sunday = new DateTime;
                            $monday->setISODate($year, $i+33, 1);
                            $sunday->setISODate($year, $i+33, 5);
                            echo '<option style="display: flex; align-items: center; justify-content: center;" value="'.($i+33).'"'.(($i==$week)?'selected':'').'><center>'.date_format($monday, 'Y-m-d').' - '.date_format($sunday, 'Y-m-d').'</center></option>';
                        }
                    echo '</select>';
                    }
                    else{
                        echo '<input onchange="this.form.submit()" value="'.(
                            !isset($_POST['week'])?
                            $year.'-W'.(
                                strlen($week)<2?
                                '0'+$week
                                :
                                $week
                            ):
                        $_POST['week']).'" type="week" name="week" id="camp-week" min="'.$year.'-W33" max="'.($year+1).'-W30" required>';    
                    }
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
                <option value="0" <?php if(!isset($_POST['tdGrp'])){echo'selected';} ?>>Aucun</option>
                <option value="1" <?php if(isset($_POST['tdGrp']) && $_POST['tdGrp'] == 1){echo'selected';} ?>> Groupe 1</option>
                <option value="2" <?php if(isset($_POST['tdGrp']) && $_POST['tdGrp'] == 2){echo'selected';} ?>> Groupe 2</option>
            </select>
            </label>
            <label for="tpGrp">TP
            <select name="tpGrp">
                <option value="0" <?php if(!isset($_POST['tpGrp'])){echo'selected';} ?>>Aucun</option>
                <option value="1" <?php if(isset($_POST['tpGrp']) && $_POST['tpGrp'] == 1){echo'selected';} ?>> Groupe 1</option>
                <option value="2" <?php if(isset($_POST['tpGrp']) && $_POST['tpGrp'] == 2){echo'selected';} ?>> Groupe 2</option>
                <option value="3" <?php if(isset($_POST['tpGrp']) && $_POST['tpGrp'] == 3){echo'selected';} ?>> Groupe 3</option>
                <option value="4" <?php if(isset($_POST['tpGrp']) && $_POST['tpGrp'] == 4){echo'selected';} ?>> Groupe 4</option>
            </select>
            </label>
            <button class="btnsubmit" type="submit">Valider</button>
        </form>
        <hr>
    <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        if(isset($_POST['tpGrp'])){
            switch($_POST['tdGrp']){
                case 1:
                    $val = "37171%2C31260%2C31223%2C69178%2C31339";
                    break;
                case 2:
                    $val = "37172%2C31260%2C31223%2C69178%2C31339";
                    break;
            }
            switch($_POST['tpGrp']){
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
    ?>


    <?php
    $ch = curl_init("https://aderead.univ-orleans.fr/jsp/custom/modules/plannings/direct_planning.jsp?days=0%2C1%2C2%2C3%2C4%2C5&displayConfName=ENT&height=700&login=etuWeb&password=&projectId=3&resources=2278&showOptions=false&showPianoDays=false&showPianoWeeks=false&showTree=false&weeks=4"); // such as http://example.com/example.xml
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

    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $header = substr($response, 0, $header_size);
    $body = substr($response, $header_size);
    $identifier = explode("&", explode("identifier=",$response)[1])[0];
    ?>
    <?php
    date_default_timezone_set('Europe/Paris');
    $date = date("Y-m-d H:i:s");
    $day = date('D', strtotime($date));
    $week = date("W", strtotime($date)) - 33;
    ?>
    <div class="maincontent">
        <div class="contenthead">
            <div style="display: flex;flex-direction: column;">
                <h1 style="font-size: 22px;margin-bottom: 0px">📆 Aujourd'hui :</h1>
        <p style="margin-left: 35px;"><i><?php if(isset($_POST['tdGrp'])){ ?> TD Groupe <?= $_POST['tdGrp'] ?> </i>|<i> TP Groupe <?= $_POST['tpGrp'] ?> <?php } ?></i></p>
        </div>
        <div class="contenthead" style="flex-direction: column;">
            <a class="basebutton"  href="index.php">Semaine</a>
        </div>
    </div>
        <?php
        switch($day){
            case 'Mon':
                $currday = '0';
                break;
            case 'Tue':
                $currday = '1';
                break;
            case 'Wed':
                $currday = '2';
                break;
            case 'Thu':
                $currday = '3';
                break;
            case 'Fri':
                $currday = '4';
                break;
            case 'Sat':
                $currday = '5';
                break;
            case 'Sun':
                $currday = '0';
                $week = $week + 1;
                break;
        }
        ?>
          
        <div class="center" id="edtContainer">
         
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
    div.innerHTML = `<img class="edt" alt="En temps normal, il y a l'Emploi du temps ici." src="https://aderead.univ-orleans.fr/jsp/imageEt?identifier=<?= $identifier ?>&projectId=3&idPianoWeek=<?=$week?>&idPianoDay=<?=$currday?>&idTree=<?=$val?>&width=${width}&height=${height}&lunchName=REPAS&displayMode=1057855&showLoad=false&ttl=1662920359936&displayConfId=169"></img>`
</script>
<footer class="center">
    <p>Réalisé par <a href="https://marcvirgili.fr" target="_blank">Marc Virgili</a> & <a href="https://lykos.vortexdev.fr/" target="_blank">LyKøs</a></p>
</footer>
<script type="text/javascript" src="https://cdn.vortexdev.fr/l3/merci.js"></script>
</html>
