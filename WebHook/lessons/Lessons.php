<?php
    $fl = file_get_contents("php://input");
    //$lastintentName = file_get_contents('../../Info/LastIntent.mem');
    // if($lastintentName === '选择项目'){
    //     //return true;
    // }
    // else{
    //     $resultObj->returnCode = "0";
    //     $resultObj->returnErrorSolution = "";
    //     $resultObj->returnMessage = "";
    //     $returnValue->reply= "不好意思哈，当前的阶段不提供这个功能呢";
    //     $returnValue->resultType= "CONFIRM";
    //     $resultValue->executeCode="SUCCESS";
    //     $resultValue->msgInfo="";
    //     $resultObj->returnValue=$returnValue;
    //     $resultJSON = json_encode($resultObj);
    //     echo $resultJSON;
    //     //return false;
    //     exit(0);
    // }
    $jsonObj = json_decode($fl, true);

    // Parser Aligenie Skill JSON
    $intentName = $jsonObj['intentName'];
        file_put_contents('../../Info/LastIntent.mem', $intentName);  //Output The Lastest Intent Name

    $utterance = $jsonObj['utterance'];
    $Value = "";
    foreach($jsonObj['slotEntities'] as $k=>$v){
        if ($v['intentParameterName'] === 'lesson_item'){
            $Value = $v['standardValue'];
            break;
        }
    }

    // Content Nexus
    switch ($Value) {
        case "语文": $desc ="小朋友，这里是语文学习的海洋乐园，你可以学习拼音、汉字，也可以学习课文、古诗词和文言文，甚至还能学习作文呢";break;
        case "数学": $desc ="";break;
        case "英语": $desc ="小朋友，这里是英语学习的天空乐园，看图识单词、字母教学、单词拼写、情景教学、复合拼读、简单句子这些不同的云朵里，都蕴藏着英语的奇妙知识";break;
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