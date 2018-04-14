<?php
    $fl = file_get_contents("php://input");
    $lastintentName = file_get_contents('../../Info/LastIntent.mem');
    if($lastintentName === '商城购买'){
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
        file_put_contents('../../Info/LastIntent.mem', print_r($intentName,true));  //Output The Lastest Intent Name
    $utterance = $jsonObj['utterance'];
    $originalValue = "";
    $standardValue = "";
    foreach($jsonObj['slotEntities'] as $k=>$v){
        if ($v['intentParameterName'] === 'market_decision'){
            $originalValue = $v['originalValue'];
            $standardValue = $v['standardValue'];
            break;
        }
    }

    // Content Nexus
    if($originalValue == "是" || $originalValue == "是的" || $originalValue == "好的" || $originalValue = "确定"){
        if(1){
            $reply = "购买成功，赶快去试一试吧！";
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
        $returnValue->resultType= "CONFIRM";
        $resultValue->executeCode="SUCCESS";
        $resultValue->msgInfo="";
    $resultObj->returnValue=$returnValue;
    $resultJSON = json_encode($resultObj);
    echo $resultJSON;
?>