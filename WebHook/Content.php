<?php
    require("Info.php");
    $fl = file_get_contents("php://input");
    $jsonObj = json_decode($fl, true);

    // Parser Aligenie Skill JSON
    $intentName = $jsonObj['intentName'];
    $utterance = $jsonObj['utterance'];
    $Value = "";
    foreach($jsonObj['slotEntities'] as $k=>$v){
        if ($v['intentParameterName'] === 'content'){
            $Value = $v['standardValue'];
            break;
        }
    }

    // Content Nexus
    if($Value === "英语"){
        $reply = getContentString(0);
    }
    else if($Value === "语文"){
        $reply = getContentString(1);
    }
    else if($Value === "数学"){
        $reply = getContentString(2);
    }

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