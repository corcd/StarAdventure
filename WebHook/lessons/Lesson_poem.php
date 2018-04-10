<?php
    $fl = file_get_contents("php://input");
    $jsonObj = json_decode($fl, true);

    // Parser Aligenie Skill JSON
    $intentName = $jsonObj['intentName'];
    $utterance = $jsonObj['utterance'];
    $originalValue = "";
    foreach($jsonObj['slotEntities'] as $k=>$v){
        if ($v['intentParameterName'] === 'lesson_poem'){
            $originalValue = $v['originalValue'];
            break;
        }
    }

    // Content Nexus
    switch ($originalValue) {
        case "静夜思": $desc ="床前看月光，疑是地上霜；抬头望山月，低头思故乡。";break;
        case "枫桥夜泊": $desc ="月落乌啼霜满天，江枫渔火对愁眠；姑苏城外寒山寺，夜半钟声到客船。";break;
        case "黄鹤楼": $desc ="昔人已乘黄鹤去，此地空余黄鹤楼。黄鹤一去不复返，白云千载空悠悠。晴川历历汉阳树，芳草萋萋鹦鹉洲。日暮乡关何处是？烟波江上使人愁。";break;
        default: $desc = "";break;
    }
    $reply = $desc."欣赏完古诗，你是否有所感触？";

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