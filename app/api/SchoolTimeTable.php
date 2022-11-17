<?php

namespace app\api;

use app\core\Auth;
use app\stockage\CookieStockage;
use http\Cookie;

class SchoolTimeTable
{

    private Curl $sessionId;
    private Curl $fetchTimeTable;
    public function __construct()
    {
        $this->sessionId = new Curl("https://ade.univ-orleans.fr/jsp/custom/modules/plannings/direct_planning.jsp?days=0%2C1%2C2%2C3%2C4%2C5&displayConfName=ENT&height=700&login=etuWeb&password=&projectId=3&resources=2278&showOptions=false&showPianoDays=false&showPianoWeeks=false&showTree=false&weeks=4");
        $this->fetchTimeTable = new Curl("https://ade.univ-orleans.fr/jsp/custom/modules/plannings/imagemap.jsp?clearTree=true&width=150&height=150");
    }

    public function fetchTimeTable() : ?String
    {
        $certificate = getcwd()."/cacert.pem";
        $this->sessionId->setOpt(CURLOPT_RETURNTRANSFER, true);
        $this->sessionId->setOpt(CURLOPT_HEADER, 1);
        $this->sessionId->setOpt(CURLOPT_CAINFO, $certificate);
        $this->sessionId->setOpt(CURLOPT_CAPATH, $certificate);
        $response = $this->sessionId->exec();
        $header_size = $this->sessionId->getHeaderSize();
        $header = substr($response, 0, $header_size);
        $this->sessionId->close();
        $JSESSIONID = explode("=", explode(":", explode(";", $header)[3])[2])[1];
        $this->fetchTimeTable->setOpt(CURLOPT_HTTPHEADER, array(
            'Cookie: JSESSIONID='.$JSESSIONID
        ));
        $this->fetchTimeTable->setOpt(CURLOPT_RETURNTRANSFER, true);
        $this->fetchTimeTable->setOpt(CURLOPT_CAINFO, $certificate);
        $this->fetchTimeTable->setOpt(CURLOPT_CAPATH, $certificate);
        $response = $this->fetchTimeTable->exec();
        return explode("&", explode("identifier=",$response)[1])[0];
    }

    public function getGroupId()
    {
        $val= "68881%2C";
        if (Auth::isAuth()) {
            switch(CookieStockage::get('td')) {
                case 0:
                    $val .= "37172%2C37171%2C31260%2C31223%2C69178%2C31339";
                    break;
                case 1:
                    $val .= "37171%2C31260%2C31223%2C69178%2C31339";
                    break;
                case 2:
                    $val .= "37172%2C31260%2C31223%2C69178%2C31339";
                    break;
            }
            switch(CookieStockage::get('tp')) {
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
        } else {
            $val .= "37171%2C37172%2C50166%2C50167%2C26013%2C34655%2C31260%2C31223%2C69178%2C31339";
        }
        return $val;
    }

}