<?php
    $fl = file_get_contents("php://input");
    $jsonObj = json_decode($fl, true);

    // Parser Aligenie Skill JSON
    $intentName = $jsonObj['intentName'];
    $utterance = $jsonObj['utterance'];
    $originalValue = "";
    foreach($jsonObj['slotEntities'] as $k=>$v){
        if ($v['intentParameterName'] === 'market_decision'){
            $originalValue = $v['originalValue'];
            break;
        }
    }

    // Content Nexus
    if($originalValue == "是" && $originalValue == "是的" && $originalValue == "好的" && $originalValue = "确定"){
        if(1){
            $reply = "购买成功！";
        }
        else{
            $reply = "哎呀，购买失败了。请检查你的账户里是否有足够的余额";
        }
    }
    else{
        $reply = "希望你下次还能来看看";
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