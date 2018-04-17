<?php
    require("function.php");
    require("skill_info.php");
    $fl = file_get_contents("php://input");
    $jsonObj = json_decode($fl, true);

    // Parser Aligenie Skill JSON
    $intentName = $jsonObj['intentName'];
        file_put_contents('../Info/LastIntent.mem', $intentName);  //Output The Lastest Intent Name
    $utterance = $jsonObj['utterance'];
    $originalValue = "";
    foreach($jsonObj['slotEntities'] as $k=>$v){
        if ($v['intentParameterName'] === 'index_variable'){
            $originalValue = $v['originalValue'];
            break;
        }
    }

    // Content Nexus
    $reply = "这就为你打开".$originalValue;
    switch ($originalValue) {
        case "今日推荐": $desc ="，今天为你找到了许多适合你的项目，先来了解一下吧";break;
        case "订阅商城": $desc ="，你可以在这里采购你所需要的额外资料与扩展内容";break;
        case "课程": $desc ="，你现在拥有语文星球、英语星球、科学星球、数学星球和故事星球五个神秘星球可以探险，你想去哪个地方一探究竟呢？";break;
        case "探索": $desc ="，在这里你可以领略冰霜星球、炽热星球和奇异星球这三个风景迥异的异世界";break;
    }
    $reply = $reply.$desc;

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