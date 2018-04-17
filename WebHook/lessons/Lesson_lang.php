<?php
    require("../function.php");
    $fl = file_get_contents("php://input");
    $lastintentName = file_get_contents('../../Info/LastIntent.mem');
    if($lastintentName === '课程选择'){
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
    //file_put_contents('./json.txt', print_r($jsonObj,true));
    //file_put_contents('./json_0.txt', print_r($jsonObj['slotEntities'][0]['intentParameterName'],true));

    // Parser Aligenie Skill JSON
    $intentName = $jsonObj['intentName'];
        file_put_contents('../../Info/LastIntent.mem', $intentName);  //Output The Lastest Intent Name
    $utterance = $jsonObj['utterance'];
    $intentId = $jsonObj['intentId'];
    $originalValue_content = "";
    $originalValue_action = "";
    // foreach($jsonObj['slotEntities'] as $k=>$v){
    //     if ($v['intentParameterName'] === 'lang_content'){
    //         $originalValue = $v['originalValue'];
    //         break;
    //     }
    // }
    $temp = array(
        'lang_content' => '0', 
        'poem_action' => '0'
    );

    if ($jsonObj['slotEntities'][0]['intentParameterName'] === 'lang_content'){
        //$temp['intentParameterName'] = $v['intentParameterName'];
        //$temp['originalValue'] = $v['originalValue'];
        $temp['lang_content'] = $jsonObj['slotEntities'][0]['originalValue'];
        $originalValue_content = $jsonObj['slotEntities'][0]['originalValue'];
        //$temp['standardValue'] = $v['standardValue'];
        //$temp['liveTime'] = $v['liveTime'];
        //$temp['createTimeStamp'] = $v['createTimeStamp'];
        }
    if ($jsonObj['slotEntities'][1]['intentParameterName'] === 'poem_action'){
        $temp['poem_action'] = $jsonObj['slotEntities'][1]['originalValue'];
        $originalValue_action = $jsonObj['slotEntities'][1]['originalValue'];
    }
    //file_put_contents('./log.txt', print_r($temp,true));
    $reply = $originalValue_content."".$originalValue_action;
    $index = "";
    $poem_name = "";
    $article_name = "";
    $poem_author = "";
    $desc = "";

    // Content Nexus
    if($originalValue_action === "无"){
        //
        switch ($originalValue_content) {
            case "古诗词": 
                //$index = rand(1,3);
                $index = 2;
                switch ($index) {
                    case 1: 
                        $poem_name ="《静夜思》";
                        $poem_author = "李白";
                        break;
                    case 2: 
                        $poem_name ="《枫桥夜泊》";
                        $poem_author = "张继";
                        break;
                    case 3: 
                        $poem_name ="《黄鹤楼》";
                        $poem_author = "崔颢";
                        break;
                }
                $reply = "我们首先来学习".$poem_author."的".$poem_name."，请跟我读，";
                switch ($poem_name) {
                    case "《静夜思》": $desc ="床前看月光，疑是地上霜。抬头望山月，低头思故乡。";break;
                    case "《枫桥夜泊》": $desc ="月落乌啼霜满天，江枫渔火对愁眠。姑苏城外寒山寺，夜半钟声到客船。";break;
                    case "《黄鹤楼》": $desc ="昔人已乘黄鹤去，此地空余黄鹤楼。黄鹤一去不复返，白云千载空悠悠。晴川历历汉阳树，芳草萋萋鹦鹉洲。日暮乡关何处是？烟波江上使人愁。";break;
                }
                //$reply = $reply."".$desc;
                break;
            case "课文": 
                $index = 2;
                switch ($index) {
                    case 1: 
                        $article_name ="";
                        $poem_author = "";
                        break;
                    case 2: 
                        $article_name ="《故乡》";
                        $article_author = "鲁迅";
                        break;
                    case 3: 
                        $article_name ="";
                        $article_author = "";
                        break;
                }
                $reply = "我们首先来学习".$article_author."的".$article_name."吧，";
                switch ($article_name) {
                    case "《故乡》": $desc ="我冒着严寒，回到相隔二千余里，别了二十余年的故乡去。时候既然是深冬；渐近故乡时，天气又阴晦了，冷风吹进船舱中，呜呜的响，从篷隙向外一望，苍黄的天底下，远近横着几个萧索的荒村，没有一些活气。我的心禁不住悲凉起来了。阿！这不是我二十年来时时记得的故乡？我所记得的故乡全不如此。我的故乡好得多了。但要我记起他的美丽，说出他的佳处来，却又没有影像，没有言辞了。仿佛也就如此。于是我自己解释说：故乡本也如此，——虽然没有进步，也未必有如我所感的悲凉，这只是我自己心情的改变罢了，因为我这次回乡，本没有什么好心绪 ";break;
                    //case "枫桥夜泊": $desc ="月落乌啼霜满天，江枫渔火对愁眠。姑苏城外寒山寺，夜半钟声到客船。";break;
                    //case "黄鹤楼": $desc ="昔人已乘黄鹤去，此地空余黄鹤楼。黄鹤一去不复返，白云千载空悠悠。晴川历历汉阳树，芳草萋萋鹦鹉洲。日暮乡关何处是？烟波江上使人愁。";break;
                }
                $reply = $reply."".$desc;
                break;
            case "拼音": $desc ="";break;
            case "作文": $desc ="";break;
        }
    }
    else if($originalValue_action === "介绍"){
       $reply = "这首诗的背景是";
    }
    else if($originalValue_action === "解释"){
       $reply = "这首诗讲述了";
    }


	// Echo Result to Aligenie
    $resultObj->returnCode = "0";
    $resultObj->returnErrorSolution = "";
    $resultObj->returnMessage = "";
        $returnValue->reply= $reply;
        $returnValue->resultType= "CONFIRM";
        $returnValue->actions[0]= $actions;
            $actions->name= "audioPlayGenieSource";
            $actions->properties= $properties;
                $properties->audioGenieId= "4208";
        //$returnValue->askedInfos=$askedInfos;
        $resultValue->executeCode= "SUCCESS";
        $resultValue->msgInfo="";
    $resultObj->returnValue=$returnValue;
    $resultJSON = json_encode($resultObj);
    //file_put_contents('./replyJson.txt', print_r($resultObj,true));
    echo $resultJSON;
?>