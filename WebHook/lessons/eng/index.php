<?php
    $fl = file_get_contents("php://input");
    $jsonObj = json_decode($fl, true);


    // Parser Aligenie Skill JSON
    $intentName = $jsonObj['intentName'];
        file_put_contents('../../Info/LastIntent.mem', $intentName);  //Output The Lastest Intent Name
    $utterance = $jsonObj['utterance'];
    $intentId = $jsonObj['intentId'];
    $originalValue_content = "";

    if ($jsonObj['slotEntities'][0]['intentParameterName'] === 'eng_content'){
        $originalValue_content = $jsonObj['slotEntities'][0]['originalValue'];
    }
    $reply = "";
    $index = "";
    $desc = "";

    // Content Nexus
    switch ($originalValue_content) {
        case "看图识单词": 
            $desc = "这里有：颜色分类、数字分类、动物分类、水果分类和文具分类五个单词分类，小朋友你想选择哪个呢？";
            break;
        case "字母教学": 
                break;
        case "单词拼写": $desc ="";break;
        case "情景教学": $desc ="";break;
        case "复合拼读": $desc ="";break;
        case "简单句子": $desc ="";break;
    }
    $reply = $reply."".$desc;

	// Echo Result to Aligenie
    $resultObj->returnCode = "0";
    $resultObj->returnErrorSolution = "";
    $resultObj->returnMessage = "";
        $returnValue->reply= $reply;
        $returnValue->resultType="CONFIRM";
        $resultValue->executeCode="SUCCESS";
        $resultValue->msgInfo="";
    $resultObj->returnValue=$returnValue;
    $resultJSON = json_encode($resultObj);
    file_put_contents('./replyJson.txt', print_r($resultObj,true));
    echo $resultJSON;
?>