<?php
    $fl = file_get_contents("php://input");
    $jsonObj = json_decode($fl, true);

    // Parser Aligenie Skill JSON
    $intentName = $jsonObj['intentName'];
        file_put_contents('../../Info/LastIntent.mem', $intentName);  //Output The Lastest Intent Name
        
    $utterance = $jsonObj['utterance'];
    $intentId = $jsonObj['intentId'];
    $Value_content = "";
    $Value_action = "";
    foreach($jsonObj['slotEntities'] as $k=>$v){
        if ($v['intentParameterName'] === 'lang_content'){
            $Value_content = $v['standardValue'];
            break;
        }
    }

    // if ($jsonObj['slotEntities'][0]['intentParameterName'] === 'lang_content'){
    //     //$temp['intentParameterName'] = $v['intentParameterName'];
    //     //$temp['Value'] = $v['Value'];
    //     $temp['lang_content'] = $jsonObj['slotEntities'][0]['standardValue'];
    //     $Value_content = $jsonObj['slotEntities'][0]['standardValue'];
    //     //$temp['standardValue'] = $v['standardValue'];
    //     //$temp['liveTime'] = $v['liveTime'];
    //     //$temp['createTimeStamp'] = $v['createTimeStamp'];
    //     }
    // if ($jsonObj['slotEntities'][1]['intentParameterName'] === 'poem_action'){
    //     $temp['poem_action'] = $jsonObj['slotEntities'][1]['standardValue'];
    //     $Value_action = $jsonObj['slotEntities'][1]['standardValue'];
    // }

    //file_put_contents('./log.txt', print_r($temp,true));
    $reply = "";
    $resultType="RESULT";
    $index = "";
    $poem_name = "";
    $article_name = "";
    $poem_author = "";
    $desc = "";

    // Content Nexus
    switch ($Value_content) {
        case "古诗": 
            //$index = rand(1,3);
            $index = 2;
            switch ($index) {
                case 1: 
                    $poem_name ="《静夜思》";
                    $poem_author = "李白";
                    $audioGenieId = "";
                    break;
                case 2: 
                    $poem_name ="《枫桥夜泊》";
                    $poem_author = "张继";
                    $audioGenieId = "4208";
                    break;
                case 3: 
                    $poem_name ="《黄鹤楼》";
                    $poem_author = "崔颢";
                    $audioGenieId = "";
                    break;
            }
            $reply = "这首诗是".$poem_author."的".$poem_name."，小朋友请跟读";
            break;
        case "课文": 
            $index = 2;
            switch ($index) {
                case 1: 
                    $article_name ="";
                    $poem_author = "";
                    $audioGenieId = "";
                    break;
                case 2: 
                    $article_name ="《故乡》";
                    $article_author = "鲁迅";
                    $audioGenieId = "4209";
                    break;
                case 3: 
                    $article_name ="";
                    $article_author = "";
                    $audioGenieId = "";
                    break;
            }
            $reply = "这篇课文".$article_author."的".$article_name."，小朋友请跟读";
            break;
        case "拼音": $desc ="";break;
        case "作文": $desc ="";break;
    }


	// Echo Result to Aligenie
    $resultObj->returnCode = "0";
    $resultObj->returnErrorSolution = "";
    $resultObj->returnMessage = "";
        $returnValue->reply= $reply;
        $returnValue->resultType= $resultType;
            $actions->name= "audioPlayGenieSource";
                $properties->audioGenieId= $audioGenieId;
            $actions->properties= $properties;
        $returnValue->actions[0]= $actions;
        //$returnValue->askedInfos=$askedInfos;
        $resultValue->executeCode= "SUCCESS";
        $resultValue->msgInfo="";
    $resultObj->returnValue=$returnValue;
    $resultJSON = json_encode($resultObj);
    //file_put_contents('./replyJson.txt', print_r($resultObj,true));
    echo $resultJSON;
?>