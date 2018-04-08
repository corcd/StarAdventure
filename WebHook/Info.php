<?php
function getContentString($codeNum){
    $tmpString = "";
    switch ($codeNum) {
            case 0: $tmpString ="让我们开始今天的英语课程；你可以学习单词跟读、字母认知";break;
            case 1: $tmpString ="让我们开始今天的语文课程；你可以学习古诗词、作文、拼音";break;
            case 2: $tmpString ="让我们开始今天的数学课程；你可以学习加减法、乘法口诀";break;
    }
    return $tmpString;
}

function getLangString($codeNum){
    $tmpString = "";
    switch ($codeNum) {
            case 0: $tmpString ="让我们开始古诗词训练吧";break;
            case 1: $tmpString ="";break;
            case 2: $tmpString ="";break;
    }
    return $tmpString;
}

function rep($codeNum){
    $tmpString = "";
    switch ($codeNum) {
            case 0: $tmpString ="那就让我们开始训练吧，请跟我读：";break;
            case 11: $tmpString ="答对啦，好棒！";break;
            case 22: $tmpString ="好可惜答错了，没关系，下次继续努力";break;
    }
    return $tmpString;
}

function Lesson_Poem1($codeNum){
    $tmpString = "请跟读这个古诗：";
    switch ($codeNum) {
            case 0: $tmpString +="月落乌啼霜满天，江枫渔火对愁眠；姑苏城外寒山寺，夜半钟声到客船";break;
            case 1: $tmpString +="床前明月光，疑是地上霜；举头望明月，低头思故乡";break;
            case 2: $tmpString +="日照香炉生紫烟，遥看瀑布挂前川；飞流直下三千尺，疑是银河落九天";break;
    }
    return $tmpString;
}
?>