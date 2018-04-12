<?php
    require("../function.php");
    $fl = file_get_contents("php://input");
    $jsonObj = json_decode($fl, true);

    // Parser Aligenie Skill JSON
    $intentName = $jsonObj['intentName'];
    $utterance = $jsonObj['utterance'];
    $originalValue = "";
    // foreach($jsonObj['slotEntities'] as $k=>$v){
    //     if ($v['intentParameterName'] === 'lang_content'){
    //         $originalValue = $v['originalValue'];
    //         break;
    //     }
    // }
    $logPath = './log.txt';
    $temp = [
        'intentParameterName' => '', 
        'originalValue' => '', 
        'standardValue' => '',
        'liveTime' => '',
        'createTimeStamp' => ''
    ];
    foreach($jsonObj['slotEntities'] as $k=>$v){
        if ($v['intentParameterName'] === 'lang_content'){
            $temp['intentParameterName'] = $v['intentParameterName'];
            $temp['originalValue'] = $v['originalValue'];
            $originalValue = $v['originalValue'];
            $temp['standardValue'] = $v['standardValue'];
            $temp['liveTime'] = $v['liveTime'];
            $temp['createTimeStamp'] = $v['createTimeStamp'];
            break;
        }
    }
    $fout = '触发:'.var_export($temp, true).';';   
    file_put_content(__DIR__.'/log.txt', $fout);


    // Content Nexus
    switch ($originalValue) {
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
            $reply = "我们首先来学习".$poem_name.",请跟我读：";
            switch ($poem_name) {
                case "静夜思": $desc ="床前看月光，疑是地上霜。抬头望山月，低头思故乡。";break;
                case "枫桥夜泊": $desc ="月落乌啼霜满天，江枫渔火对愁眠。姑苏城外寒山寺，夜半钟声到客船。";break;
                case "黄鹤楼": $desc ="昔人已乘黄鹤去，此地空余黄鹤楼。黄鹤一去不复返，白云千载空悠悠。晴川历历汉阳树，芳草萋萋鹦鹉洲。日暮乡关何处是？烟波江上使人愁。";break;
            }
            $reply = $reply."".$desc;
            ;break;
        case "拼音": $desc ="";break;
        case "作文": $desc ="";break;
    }


	// Echo Result to Aligenie
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
?>