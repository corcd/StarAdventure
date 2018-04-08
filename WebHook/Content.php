<?php
    require("Info.php");
    $fl = file_get_contents("php://input");
    $jsonObj = json_decode($fl, true);

    // Parser Aligenie Skill JSON
    $intentName = $jsonObj['intentName'];
    $utterance = $jsonObj['utterance'];
    $originalValue = "";
    foreach($jsonObj['slotEntities'] as $k=>$v){
        if ($v['intentParameterName'] === 'content'){
            $originalValue = $v['originalValue'];
            break;
        }
    }

    // Content Nexus
    if($originalValue === "英语"){
        $reply = "让我们开始今天的英语课程；你可以学习单词跟读、字母认知";
    }
    else if($originalValue === "语文"){
        $reply = "让我们开始今天的语文课程；你可以学习古诗词、作文、拼音";
    }
    else if($originalValue === "数学"){
        $reply = "让我们开始今天的数学课程；你可以学习加减法、乘法口诀";
    }
    
	// Echo Result for Aligenie
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