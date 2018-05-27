<?php
    $fl = file_get_contents("php://input");
    $jsonObj = json_decode($fl, true);

    // Parser Aligenie Skill JSON
    $intentName = $jsonObj['intentName'];
    $utterance = $jsonObj['utterance'];
    $Value = "";
    foreach($jsonObj['slotEntities'] as $k=>$v){
        if ($v['intentParameterName'] === 'action'){
            $Value = $v['standardValue'];
            break;
        }
    }
    $reply = "";

    // Content Nexus
    if($Value == "介绍"){
        $reply = "《枫桥夜泊》是唐朝安史之乱后，诗人张继途经寒山寺时，写下的一首羁旅诗。在这首诗中，诗人精确而细腻地讲述了一个客船夜泊者对江南深秋夜景的观察和感受，勾画了月落乌啼、霜天寒夜、江枫渔火、孤舟客子等景象，有景有情有声有色。";
    }
    else if($Value == "解释"){
        $reply = "这首诗句句形象鲜明，可感可画，句与句之间逻辑关系又非常清晰合理，内容晓畅易解。不仅是中国历代各种唐诗选本和别集选入此诗，连亚洲一些国家的小学课本也曾收录此诗。寒山寺也因此诗的广为传诵而成为游览胜地。";
    }
    else if($Value == "作者"){
        $reply = "这首诗的作者是张继，字懿孙，是一名唐代诗人.他写过的的最著名的诗，就是《枫桥夜泊》啦。";
    }

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