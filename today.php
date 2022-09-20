<!DOCTYPE html>
<html lang="fr" dir="ltr" class="sid-plesk">
<head>
    <title>Aujourd'hui | L3 Miage</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta property="og:site_name" content="L3 Miage | Orléans">
    <meta name="description" content="Voici l'emploi du temps d'Aujourd'hui des L3 Miage d'Orléans">
    <link href="img/l3_.png" rel="shortcut icon">
    <link rel="stylesheet" href="/style.css">
    <meta property="og:image" content="/img/l3large.png" />
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
    //$day = date('D', strtotime($date));
    ?>
    <div class="maincontent">
        <div class="contenthead">
            <div style="display: flex;flex-direction: column;">
                <h1 style="font-size: 22px;margin-bottom: 0px">📆 Aujourd'hui :</h1>
        <p style="margin-left: 35px;"><i><?php if(isset($_POST['tdGrp'])){ ?> TD Groupe <?= $_POST['tdGrp'] ?> </i>|<i> TP Groupe <?= $_POST['tpGrp'] ?> <?php } ?></i></p>
        </div>
        <div class="contenthead" style="flex-direction: column;">
            <a class="basebutton"  href="/index.php">Semaine</a>
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
        <?php
         $useragent=$_SERVER['HTTP_USER_AGENT'];
         if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
         {
            $imgwidth = 650;
            $imgheight = 380;
          }
         else{
             $imgwidth = 720;
         }
          ?>
          
          <div class="center">
        <img class="edt" style="height: <?=$imgheight?>px" alt="edt" src="https://aderead.univ-orleans.fr/jsp/imageEt?identifier=<?= $identifier ?>&projectId=3&idPianoWeek=<?=$week ?>&idPianoDay=<?=$currday?>&idTree=<?=$val?>&width=<?=$imgwidth?>&height=700&lunchName=REPAS&displayMode=1057855&showLoad=false&ttl=1662920359936&displayConfId=169"></img>
    </div>
    </div>

</div>
<div class="centeritem">
<a href="https://github.com/LeMustelide/EmploisDuTemps_Univ-Orleans" target="_blank" style="text-decoration:none;">
    <div class="cards">
        Eh ! Mais toi aussi tu dev ?!<br> Tu peux venir nous aider en nous soumettant tes idées et correctifs depuis le <u>GitHub du projet</u> !
    </div>
</a>
</div>
</body>
<footer class="center">
    <p>Réalisé avec <span class="red">❤</span> par <a href="https://marcvirgili.fr" target="_blank">Marc Virgili</a> & <a href="https://lykos.vortexdev.fr/" target="_blank">LyKøs</a></p>
</footer>
</html>
