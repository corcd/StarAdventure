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
?>