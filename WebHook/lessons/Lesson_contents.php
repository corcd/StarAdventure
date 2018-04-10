<?php
    $fl = file_get_contents("php://input");
    $jsonObj = json_decode($fl, true);

    // Parser Aligenie Skill JSON
    $intentName = $jsonObj['intentName'];
    $utterance = $jsonObj['utterance'];
    $originalValue = "";
    foreach($jsonObj['slotEntities'] as $k=>$v){
        if ($v['intentParameterName'] === ''){
            $originalValue = $v['originalValue'];
            break;
        }
    }

    // Content Nexus
    switch ($originalValue) {
        case "古诗词": $desc ="优美的诗歌，你想学习哪一首呢？";break;
        case "拼音": $desc ="";break;
        case "作文": $desc ="";break;
        default: $desc = "";break;
    }
    $reply = $desc;

	// Echo Result to Aligenie
    $resultObj->returnCode = "0";
    $resultObj->returnErrorSolution = "";
    $resultObj->returnMessage = "";
        $returnValue->reply= $reply;
        $returnValue->resultType= "RESULT";
        $resultValue->executeCode="SUCCESS";
        $resultValue->msgInfo="";
    $resultObj->returnValue=$returnValue;
    $resultJSON = json_encode($resultObj);
    echo $resultJSON;
?>