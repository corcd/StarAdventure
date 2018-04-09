<?php
    require("Info.php");
    $fl = file_get_contents("php://input");
    $jsonObj = json_decode($fl, true);

    // Parser Aligenie Skill JSON
    $intentName = $jsonObj['intentName'];
    $utterance = $jsonObj['utterance'];
    $originalValue_ans = "";
    $originalValue_num = "";
    foreach($jsonObj['slotEntities'] as $k=>$v){
        if ($v['intentParameterName'] === 'answer'){
            $originalValue_ans = $v['originalValue'];
            break;
        }
        else if ($v['intentParameterName'] === 'number'){
            $originalValue_num = $v['originalValue'];
            break;
        }
    }

    // Content Nexus
    if($originalValue_ans == "" && $originalValue_num == ""){
        $reply = rep(0);
    }
    else{
        if($originalValue_ans == Lesson_Poem1($originalValue_num)){
            $reply = rep(11);
        }
        else{
            $reply = rep(22);
        }
    }

	// Echo Result to Aligenie
    $resultObj->returnCode = "0";
    $resultObj->returnErrorSolution = "";
    $resultObj->returnMessage = "";
        $returnValue->reply= $reply + Lesson_Poem1(rand(0,2));
        $returnValue->resultType= "RESULT";
        $resultValue->executeCode="SUCCESS";
        $resultValue->msgInfo="";
    $resultObj->returnValue=$returnValue;
    $resultJSON = json_encode($resultObj);
    echo $resultJSON;
?>