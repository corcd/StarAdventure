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
    foreach($jsonObj['slotEntities'] as $k=>$v){
        if ($v['intentParameterName'] === 'eng_word_kinds'){
            $originalValue = $v['originalValue'];
            break;
        }
    }
    $reply = "";

    // Content Nexus
    if($originalValue == "颜色"){
        //$reply = "小朋友，仔细，请";
    }
    else if($originalValue == "数字"){
        //$reply = "";
    }
    else if($originalValue == "动物"){
        //$reply = "";
        $audioGenieId = "4210";
    }
    switch ($originalValue_content) {
        case "颜色": 
            $desc = "这里有：颜色、数字、动物、水果和文具五个单词分类，小朋友你想选择哪个呢？";
            break;
        case "数字": 
                break;
        case "动物": $desc ="";break;
        case "水果": $desc ="";break;
        case "文具": $desc ="";break;
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
        $resultValue->executeCode="SUCCESS";
        $resultValue->msgInfo="";
    $resultObj->returnValue=$returnValue;
    $resultJSON = json_encode($resultObj);
    echo $resultJSON;
?>