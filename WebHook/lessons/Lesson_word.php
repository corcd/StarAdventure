<?php
    $fl = file_get_contents("php://input");
    $lastintentName = file_get_contents('../../Info/LastIntent.mem');
    if($lastintentName === '外语星球'){
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

    // Parser Aligenie Skill JSON
    $intentName = $jsonObj['intentName'];
    $utterance = $jsonObj['utterance'];
    $originalValue = "";
    if ($jsonObj['slotEntities'][0]['intentParameterName'] === 'eng_word_kinds'){
        $originalValue = $jsonObj['slotEntities'][0]['originalValue'];
    }
    $reply = "";

    // Content Nexus
    switch ($originalValue) {
        case "颜色": 
            $desc = "";
            break;
        case "数字": 
            $desc = "";
            break;
        case "动物": 
            $desc = "";
            $audioGenieId = "4210";
            break;
        case "水果": $desc ="";break;
        case "文具": $desc ="";break;
    }
    $reply = $reply."".$desc;

	// Echo Result to Aligenie
    $resultObj->returnCode = "0";
    $resultObj->returnErrorSolution = "";
    $resultObj->returnMessage = "";
        $returnValue->reply= $reply;
        $returnValue->resultType= "CONFIRM";
            $actions->name = "audioPlayGenieSource";
                $properties->audioGenieId = $audioGenieId;
            $actions->properties= $properties;
        $returnValue->actions[0]= $actions;
        $resultValue->executeCode="SUCCESS";
        $resultValue->msgInfo="";
    $resultObj->returnValue=$returnValue;
    $resultJSON = json_encode($resultObj);
    file_put_contents('./replyJson.txt', print_r($resultObj,true));
    echo $resultJSON;
?>