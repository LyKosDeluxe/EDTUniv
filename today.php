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
        <form class="center" method="POST" action="index.php">
            <label for="tdGrp">Groupe de TD</label>
            <select name="tdGrp">
                <option value="1" <?php if(isset($_POST['tdGrp']) && $_POST['tdGrp'] == 1){echo'selected';} ?>> Grp 1</option>
                <option value="2" <?php if(isset($_POST['tdGrp']) && $_POST['tdGrp'] == 2){echo'selected';} ?>> Grp 2</option>
            </select>
            <label for="tpGrp" style="margin-left:10px;white-space: nowrap;">Groupe de TP
            <select name="tpGrp">
                <option value="1" <?php if(isset($_POST['tpGrp']) && $_POST['tpGrp'] == 1){echo'selected';} ?>> Grp 1</option>
                <option value="2" <?php if(isset($_POST['tpGrp']) && $_POST['tpGrp'] == 2){echo'selected';} ?>> Grp 2</option>
                <option value="3" <?php if(isset($_POST['tpGrp']) && $_POST['tpGrp'] == 3){echo'selected';} ?>> Grp 3</option>
                <option value="4" <?php if(isset($_POST['tpGrp']) && $_POST['tpGrp'] == 4){echo'selected';} ?>> Grp 4</option>
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
                $currday = '3';
                break;
            case 'Thu':
                $currday = '4';
                break;
            case 'Fri':
                $currday = '5';
                break;
            case 'Sat':
                $currday = '6';
                break;
            case 'Sun':
                $currday = '0';
                $week = $week + 1;
                break;
        }
        ?>
          
          <div class="center">
        <img class="edt" alt="En temps normal, il y a une image d'un emploi du temps." style="height: <?=$imgheight?>px" alt="edt" src="https://aderead.univ-orleans.fr/jsp/imageEt?identifier=<?=$identifier?>&projectId=3&idPianoWeek=<?=$week ?>&idPianoDay=<?=$currday?>&idTree=<?=$val?>&width=<?=$imgwidth?>&height=700&lunchName=REPAS&displayMode=1057855&showLoad=false&ttl=1662920359936&displayConfId=169"></img>
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
<footer class="center">
    <p>Réalisé par <a href="https://marcvirgili.fr" target="_blank">Marc Virgili</a> & <a href="https://lykos.vortexdev.fr/" target="_blank">LyKøs</a></p>
</footer>
</html>
