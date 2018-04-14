<?php
    require("../function.php");
    $fl = file_get_contents("php://input");
    $lastintentName = file_get_contents('../../Info/LastIntent.mem',FILE_USE_INCLUDE_PATH);
    if($lastintentName != 'Lessons'){
        $resultObj->returnCode = "0";
        $resultObj->returnErrorSolution = "";
        $resultObj->returnMessage = "";
        $returnValue->reply= "不好意思哈，当前的阶段不提供这个功能呢";
        $returnValue->resultType= "CONFIRM";
            //$askedInfos->parameterName="test";
            //$askedInfos->intentId=$intentId;
        //$returnValue->askedInfos=$askedInfos;
        $resultValue->executeCode="SUCCESS";
        $resultValue->msgInfo="";
        $resultObj->returnValue=$returnValue;
        $resultJSON = json_encode($resultObj);
        echo $resultJSON;
        exit;
    }
    $jsonObj = json_decode($fl, true);
    //file_put_contents('./json.txt', print_r($jsonObj,true));
    //file_put_contents('./json_0.txt', print_r($jsonObj['slotEntities'][0]['intentParameterName'],true));

    // Parser Aligenie Skill JSON
    $intentName = $jsonObj['intentName'];
        file_put_contents('../../Info/LastIntent.mem', print_r($intentName,true));  //Output The Lastest Intent Name
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
    $temp = array(
        'lang_content' => '0', 
        'poem_action' => '0'
    );

    if ($jsonObj['slotEntities'][0]['intentParameterName'] === 'lang_content'){
        //$temp['intentParameterName'] = $v['intentParameterName'];
        //$temp['originalValue'] = $v['originalValue'];
        $temp['lang_content'] = $jsonObj['slotEntities'][0]['originalValue'];
        $originalValue_content = $jsonObj['slotEntities'][0]['originalValue'];
        //$temp['standardValue'] = $v['standardValue'];
        //$temp['liveTime'] = $v['liveTime'];
        //$temp['createTimeStamp'] = $v['createTimeStamp'];
        }
    if ($jsonObj['slotEntities'][1]['intentParameterName'] === 'poem_action'){
        $temp['poem_action'] = $jsonObj['slotEntities'][1]['originalValue'];
        $originalValue_action = $jsonObj['slotEntities'][1]['originalValue'];
    }
    //file_put_contents('./log.txt', print_r($temp,true));
    $reply = $originalValue_content."".$originalValue_action;
    $index = "";
    $poem_name = "";
    $poem_author = "";
    $desc = "";

    // Content Nexus
    if($originalValue_action === "无"){
        //
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
                $reply = "我们首先来学习".$poem_name.",请跟我读:";
                switch ($poem_name) {
                    case "静夜思": $desc ="床前看月光，疑是地上霜。抬头望山月，低头思故乡。";break;
                    case "枫桥夜泊": $desc ="月落乌啼霜满天，江枫渔火对愁眠。姑苏城外寒山寺，夜半钟声到客船。";break;
                    case "黄鹤楼": $desc ="昔人已乘黄鹤去，此地空余黄鹤楼。黄鹤一去不复返，白云千载空悠悠。晴川历历汉阳树，芳草萋萋鹦鹉洲。日暮乡关何处是？烟波江上使人愁。";break;
                }
                $reply = $reply."".$desc;
                break;
            case "拼音": $desc ="";break;
            case "作文": $desc ="";break;
        }
    }
    else if($originalValue_action === "介绍"){
       $reply = "这首诗的背景是";
    }
    else if($originalValue_action === "解释"){
       $reply = "这首诗讲述了";
    }


	// Echo Result to Aligenie
    $resultObj->returnCode = "0";
    $resultObj->returnErrorSolution = "";
    $resultObj->returnMessage = "";
        $returnValue->reply= $reply;
        $returnValue->resultType= "CONFIRM";
            //$askedInfos->parameterName="test";
            //$askedInfos->intentId=$intentId;
        //$returnValue->askedInfos=$askedInfos;
        $resultValue->executeCode="SUCCESS";
        $resultValue->msgInfo="";
    $resultObj->returnValue=$returnValue;
    $resultJSON = json_encode($resultObj);
    //file_put_contents('./replyJson.txt', print_r($resultObj,true));
    echo $resultJSON;
?>