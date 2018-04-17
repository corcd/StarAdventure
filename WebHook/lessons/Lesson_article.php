<?php
    $fl = file_get_contents("php://input");
    $lastintentName = file_get_contents('../../Info/LastIntent.mem');
    if($lastintentName === '语文星球'){
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
        if ($v['intentParameterName'] === 'action'){
            $originalValue = $v['originalValue'];
            break;
        }
    }
    $reply = "";

    // Content Nexus
    if($originalValue == "背诵"){
        $reply = "背诵《故乡》第 12 段：还有闰土，他每到我家来时，总问起你，很想见你一面。我已经将你到家的大约日期通知他，他也许就要来了。
        （小朋友请背诵下一段）";
    }
    else if($originalValue == "修辞"){
        $reply = "这篇文章里运用了比喻、拟物和借代等修辞手法。";
    }
    else if($originalValue == "作者信息"){
        $reply = "鲁迅，本名周树人，原名樟寿，字豫才，以笔名鲁迅闻名于世，浙江绍兴人，为中国的近代著名作家，新文化运动的领导人之一，中国现代文学的奠基人和开山巨匠，在西方世界享有盛誉的中国近代文学家、思想家。";
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