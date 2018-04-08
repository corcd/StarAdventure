<?php
    require("Info.php");
    $fl = file_get_contents("php://input");
    $jsonObj = json_decode($fl, true);
    // Parser Aligenie Skill JSON
    $intentName = $jsonObj['intentName'];
    $utterance = $jsonObj['utterance'];
    $original = "";
    foreach($jsonObj['slotEntities'] as $k=>$v){
        if ($v['intentParameterName']=== 'content'){
            $original = $v['originalValue'];
            $reply = $original;
            break;
        }
    }
    // Content Nexus

	// Echo Result for Aligenie
    $resultObj->returnCode = "0";
    $resultObj->returnErrorSolution = "";
    $resultObj->returnMessage = "";
        $returnValue->reply= $reply;
        $returnValue->resultType= "RESULT";
    $resultObj->returnValue=$returnValue;
    $resultObj->executeCode="SUCCESS";
    $resultObj->msgInfo="";
    $resultJSON = json_encode($resultObj);
    echo $resultJSON;
?>