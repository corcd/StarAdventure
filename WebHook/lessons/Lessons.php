<?php
    require("../function.php");
    $fl = file_get_contents("php://input");
    //intentCheck('../../Info/LastIntent.mem','选择项目','不好意思哈，当前的阶段不提供这个功能呢');
    $lastintentName = file_get_contents('../../Info/LastIntent.mem');
    if($lastintentName === '选择项目'){
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
        file_put_contents('../../Info/LastIntent.mem', $intentName);  //Output The Lastest Intent Name
    $utterance = $jsonObj['utterance'];
    $originalValue = "";
    foreach($jsonObj['slotEntities'] as $k=>$v){
        if ($v['intentParameterName'] === 'lesson_item'){
            $originalValue = $v['originalValue'];
            break;
        }
    }

    // Content Nexus
    switch ($originalValue) {
        case "文学瀚海": $desc ="来到浩瀚无垠的文学海洋，你可以在这里捕获到无穷无尽新鲜的知识，你可以学习古诗词、也可以学习拼音，甚至还能学习作文";break;
        case "数理高峰": $desc ="";break;
        case "外语星辰": $desc ="";break;
    }
    $reply = $desc;

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