<?php
    $fl = file_get_contents("php://input");
    $jsonObj = json_decode($fl, true);
    file_put_contents('../log.txt', print_r($jsonObj,true));

    $lastintentName = file_get_contents('../../../Info/LastIntent.mem');
    if($lastintentName == "语文"){
        //return true;
    }
    else{
        $resultObj->returnCode = "0";
        $resultObj->returnErrorSolution = "";
        $resultObj->returnMessage = "";
        $returnValue->reply= "未定义的前置参数";
        $returnValue->resultType= "RESULT";
        $resultValue->executeCode="PARAMS_ERROR";
        $resultValue->msgInfo="";
        $resultObj->returnValue=$returnValue;
        $resultJSON = json_encode($resultObj);
        echo $resultJSON;
        //return false;
        exit(0);
    }

    // Parser Aligenie Skill JSON
    $intentName = $jsonObj['intentName'];
    $utterance = $jsonObj['utterance'];
    $intentId = $jsonObj['intentId'];

    $ready = "false";
    $Value1 = "";
    $Value2 = "";
    $Value3 = "";
    $reply = "";
    $resultType = "";

    // Content Nexus
    switch ($intentName) {
        case "古诗词操作":
            foreach($jsonObj['slotEntities'] as $k=>$v){
                if ($v['intentParameterName'] === 'poem_action'){
                    $Value1 = $v['standardValue'];
                    break;
                }
            }
            if($Value1 == "介绍"){
                $reply = "这首诗是唐代诗人李白所作的一首五言古诗。这首小诗用简单平实的叙述来抒发远客的思乡之情，情真意切，耐人回味，成为传诵千载的佳作。";
                $resultType = "RESULT";
            }
            else if($Value1 == "解释"){
                $reply = "这是一首写思乡之情的诗，诗人很久都没有回家了。当到了夜深人静的时候，明亮的月光照在诗人的床前，白白的，就好像冬天里地面上结的霜一样……诗人抬着头，看着明亮圆圆的月亮，又不由想念着自己遥远的家。他真想与家人团圆在一起呀！";
                $resultType = "RESULT";
            }
            else if($Value1 == "检测"){
                $reply = "看来小朋友你已经掌握了这首诗的学习内容啦，那就让我们来做个小小的测试吧。你准备好了吗？";
                $resultType = "CONFIRM";
            }
            break;
        case "古诗词属性":
            foreach($jsonObj['slotEntities'] as $k=>$v){
                if ($v['intentParameterName'] === 'poem_property'){
                    $Value_property = $v['standardValue'];
                    break;
                }
            }
            if($Value_property == "作者"){
                $reply = "这首诗的作者是唐代诗人李白";
                $resultType = "RESULT";
            }
            else if($Value_property == "朝代"){
                $reply = "这首诗是五言绝句唐诗";
                $resultType = "RESULT";
            }
            break;
        case "古诗词检测":
            // foreach($jsonObj['slotEntities'] as $k=>$v){
            //     if ($v['intentParameterName'] === 'poem_test_answer'){
            //         $Value2 = $v['standardValue'];
            //         break;
            //     }
            // }
            if ($jsonObj['slotEntities'][0]['intentParameterName'] === 'ready_status'){
                $Value3 = $jsonObj['slotEntities'][0]['standardValue'];
            }
            else if($jsonObj['slotEntities'][0]['intentParameterName'] === 'poem_test_answer'){
                $Value2 = $jsonObj['slotEntities'][0]['standardValue'];
            }

            if ($jsonObj['slotEntities'][1]['intentParameterName'] === 'poem_test_answer'){
                $Value2 = $jsonObj['slotEntities'][1]['standardValue'];
            }
            else if($jsonObj['slotEntities'][1]['intentParameterName'] === 'ready_status'){
                $Value3 = $jsonObj['slotEntities'][1]['standardValue'];
            }

            if($Value2 == "N/A"){
                if($Value3 == "YES"){
                    $reply = "请听题：李白的《静夜思》的第一句中，“床前”之后是什么内容，小朋友请填空，说出你的答案";
                    $resultType = "ASK_INF";
                        $askedInfos->parameterName= "poem_test_answer";
                        $askedInfos->intentId= $intentId;
                    $returnValue->askedInfos[0]= $askedInfos;
                }
                else{
                    $reply = "那等你准备好了，我们再来测验吧";
                    $resultType = "RESULT";
                }
            }
            else if($Value2 != "N/A"){
                if($Value2 == "明月光"){
                    $reply = "好棒，恭喜你答对啦！奖励你小星星！";
                    $resultType = "RESULT";
                }
                else{
                    $reply = "好可惜，请再来一遍吧！";
                    $resultType = "ASK_INF";
                        $askedInfos->parameterName= "poem_test_answer";
                        $askedInfos->intentId= $intentId;
                    $returnValue->askedInfos[0]= $askedInfos;
                }
            }
            else{
                $reply = "错误信息,V2:".$Value2.",V3:".$Value3;
                $resultType = "RESULT";
            }
            break;
    }
	// Echo Result to Aligenie
    $resultObj->returnCode = "0";
    $resultObj->returnErrorSolution = "";
    $resultObj->returnMessage = "";
        $returnValue->reply= $reply;
        $returnValue->resultType= $resultType;
        $resultValue->executeCode="SUCCESS";
        $resultValue->msgInfo="";
    $resultObj->returnValue=$returnValue;
    $resultJSON = json_encode($resultObj);
    echo $resultJSON;
?>