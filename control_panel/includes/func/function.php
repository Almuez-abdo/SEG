<?php

    //title function

    function getTitle(){
        global $pageTitle;
        if(isset($pageTitle)){
            echo $pageTitle;
        }else{
            echo 'No Title';
        }
    };

    // Redirect To Home
    
    function redirectHome($theMsg, $sec = 3, $url= NULL){
        if($url === NULL){
            $url = 'homePage.php';
            $link = 'الصفحة الرئيسية';
        }elseif($url === 'back'){
            if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){
                $url = $_SERVER['HTTP_REFERER'];
                $link = 'الصفحة السابقة';
            }
        }elseif($url == $url){
            $url = $url;
            $link = 'صفحة التحكم '; 
        }
     
    

        echo '<div class= "container text-end">';
            echo $theMsg ;
            echo '<div class= "alert alert-info">سوف يتم تحويلك الي  ' .  $link . ' بعد ' . $sec . ' ثانية </div>';
        echo '</div>';
        header("refresh:$sec;URL= $url");
        exit();
    };

    // Check Items

    function checkItem($select, $from, $value){
        global $con;

        $statmenet= $con->prepare("SELECT $select FROM $from WHERE $select= ?");
        $statmenet->execute(array($value));
        $count = $statmenet->rowCount();
        return $count;
    };



    // Count items

    function contItems($item, $from){
        global $con;

        $stmt2= $con->prepare("SELECT COUNT($item) FROM $from");
        $stmt2->execute();

        return $stmt2->fetchColumn();
    };
