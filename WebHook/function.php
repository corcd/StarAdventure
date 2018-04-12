<?php
function resolveLog($jsonObj,$intentname){
    $temp = array (
        'intentParameterName' => '', 
        'originalValue' => '', 
        'standardValue' => '',
        'liveTime' => '',
        'createTimeStamp' => ''
    );
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
?>