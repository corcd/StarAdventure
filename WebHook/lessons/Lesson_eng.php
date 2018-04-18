<?php
    require("../function.php");
    $fl = file_get_contents("php://input");
    $lastintentName = file_get_contents('../../Info/LastIntent.mem');
    if($lastintentName === '课程选择'){
        //return true;
    }
    else{
        $resultObj->returnCode = "0";
        $resultObj->returnErrorSolution = "";
        $resultObj->returnMessage = "";
        $returnValue->reply= "不好意思哈，当前的阶段不提供这个功能呢";
        $returnValue->resultType= "CONFIRM";
        $resultValue->executeCode="SUCCESS";
        $resultValue->msgInfo="";
        $resultObj->returnValue=$returnValue;
        $resultJSON = json_encode($resultObj);
        echo $resultJSON;
        //return false;
        exit(0);
    }
    $jsonObj = json_decode($fl, true);
    //file_put_contents('./json.txt', print_r($jsonObj,true));
    //file_put_contents('./json_0.txt', print_r($jsonObj['slotEntities'][0]['intentParameterName'],true));

    // Parser Aligenie Skill JSON
    $intentName = $jsonObj['intentName'];
        file_put_contents('../../Info/LastIntent.mem', $intentName);  //Output The Lastest Intent Name
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
    $article_name = "";
    $poem_author = "";
    $desc = "";

    // Content Nexus
    if($originalValue_action === "无"){
        //
        switch ($originalValue_content) {
            case "看图识单词": 
                $desc = "这里有：颜色、数字、动物、水果和文具五个单词分类，小朋友你想选择哪个呢？";
                break;
            case "字母教学": 
                break;
            case "单词拼写": $desc ="";break;
            case "情景教学": $desc ="";break;
            case "复合拼读": $desc ="";break;
            case "简单句子": $desc ="";break;
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
            $actions->name= "audioPlayGenieSource";
                $properties->audioGenieId= $audioGenieId;
            $actions->properties= $properties;
        $returnValue->actions[0]= $actions;
        //$returnValue->askedInfos=$askedInfos;
        $resultValue->executeCode= "SUCCESS";
        $resultValue->msgInfo="";
    $resultObj->returnValue=$returnValue;
    $resultJSON = json_encode($resultObj);
    file_put_contents('./replyJson.txt', print_r($resultObj,true));
    echo $resultJSON;
?>