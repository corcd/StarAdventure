<?php   
    function mb_str_split( $string ) {    // /u表示把字符串当作utf-8处理，并把字符串开始和结束之前所有的字符串分割成数组
        return preg_split('/(?<!^)(?!$)/u', $string ); 
    }

    $fl = file_get_contents("php://input");
    $jsonObj = json_decode($fl, true);

    // Parser Aligenie Skill JSON
    $intentName = $jsonObj['intentName'];
        file_put_contents('../../../Info/LastIntent.mem', $intentName);  //Output The Lastest Intent Name
        
    $utterance = $jsonObj['utterance'];
    $intentId = $jsonObj['intentId'];

    $Value_content = "";
    $Value_answer = "";

    if ($jsonObj['slotEntities'][0]['intentParameterName'] === 'lang_content'){
        $Value_content = $jsonObj['slotEntities'][0]['standardValue'];
    }
    else if($jsonObj['slotEntities'][0]['intentParameterName'] === 'poem_word_answer'){
        $Value_answer = $jsonObj['slotEntities'][0]['standardValue'];
    }

    if ($jsonObj['slotEntities'][1]['intentParameterName'] === 'poem_word_answer'){
        $Value_answer = $jsonObj['slotEntities'][1]['standardValue'];
    }
    else if($jsonObj['slotEntities'][1]['intentParameterName'] === 'lang_content'){
        $Value_content = $jsonObj['slotEntities'][1]['standardValue'];
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
    $sentences= "";
    $word = "";
    $poem_name = "";
    $article_name = "";
    $poem_author = "";
    $desc = "";

    // Content Nexus
    switch ($Value_content) {
        case "古诗": 
            //$index = rand(1,3);
            $index = 1;
            switch ($index) {
                case 1: 
                    $poem_name ="《静夜思》";
                    $poem_author = "李白";
                    $audioGenieId = "4455";
                    $sentences = "床前明月光疑是地上霜举头望明月低头思故乡";
                    break;
                case 2: 
                    $poem_name ="《枫桥夜泊》";
                    $poem_author = "张继";
                    $audioGenieId = "4208";
                    $sentences = "月落乌啼霜满天江枫渔火对愁眠姑苏城外寒山寺夜半钟声到客船";
                    break;
                case 3: 
                    $poem_name ="《黄鹤楼》";
                    $poem_author = "崔颢";
                    $audioGenieId = "";
                    $sentences = "";
                    break;
            }
            if($Value_answer == "N/A"){
                $ret = array();
                foreach (mb_str_split($sentences) as $c){
                    $ret[] = $c;
                }
                //$word = $ret[rand(0,count($ret))];
                $word = "望";
                file_put_contents("word.mem", $word);  //外部存储
                $reply = "这首诗是".$poem_author."的".$poem_name."，接下来让我们看看小朋友你认识多少生字吧！请跟我读,".$word;
                $resultType = "ASK_INF";
                    $actions->name= "audioPlayGenieSource";
                        $properties->audioGenieId= $audioGenieId;
                    $actions->properties= $properties;
                $returnValue->actions[0]= $actions;
                    $askedInfos->parameterName= "poem_word_answer";
                    $askedInfos->intentId= $intentId;
                $returnValue->askedInfos[0]= $askedInfos;
            }
            else if($Value_answer != "N/A"){
                $word = file_get_contents("word.mem");
                if($Value_answer == $word){
                    $reply = "好棒，恭喜你答对啦！";
                    $resultType = "RESULT";
                }
                else{
                    $reply = "好可惜，请再来一遍吧！";
                    $resultType = "ASK_INF";
                        $askedInfos->parameterName= "poem_word_answer";
                        $askedInfos->intentId= $intentId;
                    $returnValue->askedInfos[0]= $askedInfos;
                }
            }
            else{
                $reply = "错误信息,V2:".$Value2.",V3:".$Value3;
                $resultType = "RESULT";
            }
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
        $resultValue->executeCode= "SUCCESS";
        $resultValue->msgInfo="";
    $resultObj->returnValue=$returnValue;
    $resultJSON = json_encode($resultObj);
    //file_put_contents('./replyJson.txt', print_r($resultObj,true));
    echo $resultJSON;
?>