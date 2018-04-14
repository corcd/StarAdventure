<?php
function resolveLog($jsonObj,$intentname){
    $temp = [
        'intentParameterName' => '', 
        'originalValue' => '', 
        'standardValue' => '',
        'liveTime' => '',
        'createTimeStamp' => ''
    ];
    foreach($jsonObj['slotEntities'] as $k=>$v){
        if ($v['intentParameterName'] === $intentname){
            $temp['intentParameterName'] = $v['intentParameterName'];
            $temp['originalValue'] = $v['originalValue'];
            $temp['standardValue'] = $v['standardValue'];
            $temp['liveTime'] = $v['liveTime'];
            $temp['createTimeStamp'] = $v['createTimeStamp'];
            break;
        }
    }
    file_put_contents('log.txt', print_r($temp, true));
    return $temp['originalValue'];
}

function intentCheck($PATH,$intentName,$reply){
    $lastintentName = file_get_contents($PATH);
    if($lastintentName == $intentname){
        return true;
    }
    else{
        $resultObj->returnCode = "0";
        $resultObj->returnErrorSolution = "";
        $resultObj->returnMessage = "";
        $returnValue->reply= $reply;
        $returnValue->resultType= "CONFIRM";
        $resultValue->executeCode="SUCCESS";
        $resultValue->msgInfo="";
        $resultObj->returnValue=$returnValue;
        $resultJSON = json_encode($resultObj);
        echo $resultJSON;
        return false;
    }
}
?>