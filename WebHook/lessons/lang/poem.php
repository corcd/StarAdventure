<?php
    $fl = file_get_contents("php://input");
    $jsonObj = json_decode($fl, true);
    file_put_contents('../log.txt', print_r($jsonObj,true));

    // $lastintentName = file_get_contents('../../Info/LastIntent.mem');
    // if($lastintentName == "语文"){
    //     //return true;
    // }
    // else{
    //     $resultObj->returnCode = "0";
    //     $resultObj->returnErrorSolution = "";
    //     $resultObj->returnMessage = "";
    //     $returnValue->reply= "未定义的前置参数";
    //     $returnValue->resultType= "RESULT";
    //     $resultValue->executeCode="PARAMS_ERROR";
    //     $resultValue->msgInfo="";
    //     $resultObj->returnValue=$returnValue;
    //     $resultJSON = json_encode($resultObj);
    //     echo $resultJSON;
    //     //return false;
    //     exit(0);
    // }

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
                $reply = "《枫桥夜泊》是唐朝安史之乱后，诗人张继途经寒山寺时，写下的一首羁旅诗。在这首诗中，诗人精确而细腻地讲述了一个客船夜泊者对江南深秋夜景的观察和感受，勾画了月落乌啼、霜天寒夜、江枫渔火、孤舟客子等景象，有景有情有声有色。";
                $resultType = "RESULT";
            }
            else if($Value1 == "解释"){
                $reply = "这首诗句句形象鲜明，可感可画，句与句之间逻辑关系又非常清晰合理，内容晓畅易解。不仅是中国历代各种唐诗选本和别集选入此诗，连亚洲一些国家的小学课本也曾收录此诗。寒山寺也因此诗的广为传诵而成为游览胜地。";
                $resultType = "RESULT";
            }
            else if($Value1 == "作者"){
                $reply = "这首诗的作者是张继，字懿孙，是一名唐代诗人.他写过的的最著名的诗，就是《枫桥夜泊》啦。";
                $resultType = "RESULT";
            }
            else if($Value1 == "检测"){
                $reply = "看来小朋友你已经掌握了这首诗的学习内容啦，那就让我们来做个小小的测试吧。你准备好了吗？";
                $resultType = "CONFIRM";
            }
            break;
        case "古诗词属性":
            
            break;
        // case "古诗词检测":
        //     if($ready){
        //         foreach($jsonObj['slotEntities'] as $k=>$v){
        //             if ($v['intentParameterName'] === 'poem_test_answer'){
        //                 $Value2 = $v['standardValue'];
        //                 break;
        //             }
        //         }
        //         if($Value2 == "明月光"){
        //             $reply = "好棒，恭喜你答对啦！";
        //             $resultType = "RESULT";
        //         }
        //         else{
        //             $reply = "好可惜，请再来一遍吧！";
        //             $resultType = "ASK_INF";
        //         }
        //     }
        //     break;
        case "准备判断":
            if ($jsonObj['slotEntities'][0]['intentParameterName'] === 'ready_status'){
                $Value3 = $jsonObj['slotEntities'][0]['standardValue'];
            }
            if ($jsonObj['slotEntities'][1]['intentParameterName'] === 'poem_test_answer'){
                $Value2 = $jsonObj['slotEntities'][1]['standardValue'];
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
                    $reply = "好棒，恭喜你答对啦！";
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