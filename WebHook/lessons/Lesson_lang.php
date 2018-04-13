<?php
    require("../function.php");
    $fl = file_get_contents("php://input");
    $jsonObj = json_decode($fl, true);

    // Parser Aligenie Skill JSON
    $intentName = $jsonObj['intentName'];
    $utterance = $jsonObj['utterance'];
    $intentId = $jsonObj['intentId'];
    $originalValue_content = "";
    $originalValue_action = "";
    // foreach($jsonObj['slotEntities'] as $k=>$v){
    //     if ($v['intentParameterName'] === 'lang_content'){
    //         $originalValue = $v['originalValue'];
    //         break;
    //     }
    // }
    $temp = [
        'intentParameterName' => '0', 
        'originalValue' => '0', 
        'standardValue' => '0',
        'liveTime' => '0',
        'createTimeStamp' => '0'
    ];
    foreach($jsonObj['slotEntities'][0] as $k=>$v){
        if ($v['intentParameterName'] === 'lang_content'){
            $temp['intentParameterName'] = $v['intentParameterName'];
            $temp['originalValue'] = $v['originalValue'];
            $originalValue_content = $v['originalValue'];
            $temp['standardValue'] = $v['standardValue'];
            $temp['liveTime'] = $v['liveTime'];
            $temp['createTimeStamp'] = $v['createTimeStamp'];
            break;
        }
    }
    foreach($jsonObj['slotEntities'][1] as $k=>$v){
        if ($v['intentParameterName'] === 'poem_action'){
            $originalValue_action = $v['originalValue'];
            break;
        }
    }
    file_put_contents('./log.txt', print_r($temp,true));


    // Content Nexus
    switch ($originalValue_content) {
        case "古诗词": 
            $index = rand(1,3);
            switch ($index) {
                case 1: 
                    $poem_name ="静夜思";
                    $poem_author = "李白";
                    break;
                case 2: 
                    $poem_name ="枫桥夜泊";
                    $poem_author = "张继";
                    break;
                case 3: 
                    $poem_name ="黄鹤楼";
                    $poem_author = "崔颢";
                    break;
            }
            $reply = "我们首先来学习".$poem_name."：";
            switch ($poem_name) {
                case "静夜思": $desc ="床前看月光，疑是地上霜。抬头望山月，低头思故乡。";break;
                case "枫桥夜泊": $desc ="月落乌啼霜满天，江枫渔火对愁眠。姑苏城外寒山寺，夜半钟声到客船。";break;
                case "黄鹤楼": $desc ="昔人已乘黄鹤去，此地空余黄鹤楼。黄鹤一去不复返，白云千载空悠悠。晴川历历汉阳树，芳草萋萋鹦鹉洲。日暮乡关何处是？烟波江上使人愁。";break;
            }
            $reply = $reply."".$desc."你也赶快来试一下吧！";
            break;
        case "拼音": $desc ="";break;
        case "作文": $desc ="";break;
    }
    $reply = $reply."".$originalValue_action;


	// Echo Result to Aligenie
    $resultObj->returnCode = "0";
    $resultObj->returnErrorSolution = "";
    $resultObj->returnMessage = "";
        $returnValue->reply= $reply;
        $returnValue->resultType= "COMFRIM";
            //$askedInfos->parameterName="test";
            //$askedInfos->intentId=$intentId;
        //$returnValue->askedInfos=$askedInfos;
        $resultValue->executeCode="SUCCESS";
        $resultValue->msgInfo="";
    $resultObj->returnValue=$returnValue;
    $resultJSON = json_encode($resultObj);
    echo $resultJSON;
?>