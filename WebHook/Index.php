<?php
    $fl = file_get_contents("php://input");
    $jsonObj = json_decode($fl, true);

    // Parser Aligenie Skill JSON
    $intentName = $jsonObj['intentName'];
        file_put_contents('../Info/LastIntent.mem', $intentName);  //Output The Lastest Intent Name
    $utterance = $jsonObj['utterance'];
    $Value = "";
    foreach($jsonObj['slotEntities'] as $k=>$v){
        if ($v['intentParameterName'] === 'index_variable'){
            $Value = $v['standardValue'];
            break;
        }
    }

    // Content Nexus
    $reply = "这就为你打开".$Value;
    switch ($Value) {
        case "今日推荐": $desc ="，小朋友，今天为你找到了许许多多适合你的项目，我们先来了解一下吧！";break;
        case "订阅商城": $desc ="，小朋友，你可以在这里购买你所需要的额外资料与扩展内容，不过千万要记得，不要随便乱花钱哟！";break;
        case "课程": $desc ="，小朋友，在这里，你可以随心所欲地选择学习语文或者学习英语，还不赶快做出你的决定！";break;
        case "探索": $desc ="，哇，这是一段全新奇妙的探险，小朋友，从冰霜星球、炽热星球和奇异星球中选择一个你最想了解的新世界吧！";break;
    }
    $reply = $reply."".$desc;

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