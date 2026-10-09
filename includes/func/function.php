<?php

    // Select All From Table
    function getAll($table, $where = NULL){
        global $con;
        $stAll = $con->prepare("SELECT * FROM $table $where");
        $stAll->execute();
        $all = $stAll->fetchAll();
        return $all;
    }





    // CHeck To User Activate

    function userActive($user){
        global $con;
        $stmtU = $con->prepare("SELECT
                                    Person_ID, Reg_Status
                                FROM
                                    information
                                WHERE
                                    Person_ID = ?
                                AND
                                Reg_Status = 0");

        $stmtU->execute(array($user));
        $statusU= $stmtU->rowCount();

        return $statusU;
    }


      // CHeck To User manger

      function userManger($user){
        global $con;
        $stManger = $con->prepare("SELECT
                                    Person_ID, Person_Job
                                FROM
                                    information
                                WHERE
                                    Person_ID = ?
                                AND
                                Person_Job = 'مدير'");

        $stManger->execute(array($user));
        $mag= $stManger->rowCount();

        return $mag;
    }


      // CHeck To User Boss

    function userBoss($user){
        global $con;
        $stBoss = $con->prepare("SELECT Person_ID, Person_Job FROM information WHERE Person_ID = ? AND Person_Job = 'شؤون الموظفين'");
        $stBoss->execute(array($user));
        $boss = $stBoss->rowCount();

        return $boss;
    }

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
            $url = 'main.php';
            $link = 'الصفحة الرئيسية';
        }elseif($url === 'back'){
            if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){
                $url = $_SERVER['HTTP_REFERER'];
                $link = 'الصفحة السابقة';
            }
        }elseif($url == $url){
            $url = $url;
            $link = ' الصفحة الرئيسية '; 
        }
     
    

        echo '<div class= "container text-end">';
            echo $theMsg ;
            echo '<div class= "alert alert-info">سوف يتم تحويلك الي  ' .  $link . ' بعد ' . $sec . ' ثواني </div>';
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






        
    