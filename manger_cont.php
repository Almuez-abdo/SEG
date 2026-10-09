<?php
    ob_start();
    session_start();
    $pageTitle = "update";
    
    include "init.php";

    if($_SERVER['REQUEST_METHOD']== 'POST'){
        // School Needs Boss
        if(isset($_POST['sch_need'])){
            $num_need = $_POST['sch_need'];
       
            if($_POST['boss'] == "أوافق"){
                $numBoss = 2;
                $stBoss = $con->prepare("UPDATE school_needs SET Des_Bos = ? WHERE Need_ID = ? ");
                $stBoss->execute(array($numBoss, $num_need));

            }elseif($_POST['boss'] == "لا أوافق"){
                $numBoss = 1;
                $stBoss = $con->prepare("UPDATE school_needs SET Des_Bos = ? WHERE Need_ID = ? ");
                $stBoss->execute(array($numBoss, $num_need));
            }

            // Preak Request Manger
        }elseif(isset($_POST['numPreak'])){
            $num_pr = $_POST['numPreak'];
            if($_POST['des'] == "نعم"){
                $numDes = 2; 

                $des_m = $con->prepare("UPDATE preak SET Des_Manger = ? WHERE Preak_ID = ?");
                $des_m->execute(array($numDes, $num_pr));
        
            }elseif($_POST['des'] == "لا"){
                $numDes = 1;
                $stDes = $con->prepare("UPDATE preak SET Des_Manger = ? WHERE Preak_ID = ?");
                $stDes->execute(array($numDes, $num_pr));

            }

            // Preak Request Boss
        }elseif(isset($_POST['prID'])){
            $preakID = $_POST['prID'];
            if($_POST['boss'] == "نعم"){
                $num_preak = 2; 

                $des_pr = $con->prepare("UPDATE preak SET Des_Bos = ? WHERE Preak_ID = ?");
                $des_pr->execute(array($num_preak, $preakID));
        
            }elseif($_POST['boss'] == "لا"){
                $num_preak = 1;
                $des_pr = $con->prepare("UPDATE preak SET Des_Bos = ? WHERE Preak_ID = ?");
                $des_pr->execute(array($num_preak, $preakID));

            }

            // Move Request Manger
        }elseif(isset($_POST['move_ma'])){
            $moveID = $_POST['move_ma'];
            if($_POST['des'] == "نعم"){
                $num_move_M = 2; 

                $des_mo = $con->prepare("UPDATE move SET Des_Manger = ? WHERE Move_ID = ?");
                $des_mo->execute(array($num_move_M, $moveID));
        
            }elseif($_POST['des'] == "لا"){
                $num_move_M = 1;
                $des_mo = $con->prepare("UPDATE move SET Des_Manger = ? WHERE Move_ID = ?");
                $des_mo->execute(array($num_move_M, $moveID));

            }
            // Move Request Boss
        }elseif(isset($_POST['moID'])){
            $mo_Bos = $_POST['moID'];
            if($_POST['boss_Move'] == 'نعم'){
                $num_move_B = 2; 

                $boss_mo = $con->prepare("UPDATE `move` SET Des_Bos = ? WHERE Move_ID = ?");
                $boss_mo->execute(array($num_move_B, $mo_Bos));
        
            }elseif($_POST['boss_Move'] == 'لا'){
                $num_move_B = 1;
                $boss_mo = $con->prepare("UPDATE `move` SET Des_Bos = ? WHERE Move_ID = ?");
                $boss_mo->execute(array($num_move_B, $mo_Bos));

            }

            // Tkaod Request Manger
        }elseif(isset($_POST['tkaod_ma'])){
            $tkaodID = $_POST['tkaod_ma'];
            if($_POST['tk_manger'] == "نعم"){
                $num_tkaod_M = 2; 

                $des_tkaod = $con->prepare("UPDATE pension SET Des_Manger = ? WHERE Pension_ID = ?");
                $des_tkaod->execute(array($num_tkaod_M, $tkaodID));
        
            }elseif($_POST['tk_manger'] == "لا"){
                $num_tkaod_M = 1;
                $des_tkaod = $con->prepare("UPDATE pension SET Des_Manger = ? WHERE Pension_ID = ?");
                $des_tkaod->execute(array($num_tkaod_M, $tkaodID));

            }

            // Tkaod Request Boss
        }elseif(isset($_POST['tkID'])){
            $bos_ID = $_POST['tkID'];
            if($_POST['boss_tkaod'] == "نعم"){
                $num_tkaod_B = 2; 

                $bo_tkaod = $con->prepare("UPDATE pension SET Des_Bos = ? WHERE Pension_ID = ?");
                $bo_tkaod->execute(array($num_tkaod_B, $bos_ID));
        
            }elseif($_POST['boss_tkaod'] == "لا"){
                $num_tkaod_B = 1;
                $bo_tkaod = $con->prepare("UPDATE pension SET Des_Bos = ? WHERE Pension_ID = ?");
                $bo_tkaod->execute(array($num_tkaod_B, $bos_ID));

            }

            // Extend Request Boss
        }elseif(isset($_POST['extID'])){
            $ext_ID = $_POST['extID'];
            if($_POST['bos_ext'] == "نعم"){
                $num_extend_B = 2; 

                $bo_extend = $con->prepare("UPDATE extended_servce SET Des_Bos = ? WHERE Extended_ID  = ?");
                $bo_extend->execute(array($num_extend_B, $ext_ID));
        
            }elseif($_POST['bos_ext'] == "لا"){
                $num_extend_B = 1;
                $bo_extend = $con->prepare("UPDATE extended_servce SET Des_Bos = ? WHERE Extended_ID = ?");
                $bo_extend->execute(array($num_extend_B, $ext_ID));

            }

            //Request Boss Page
        }elseif(isset($_POST['peoID'])){
            $peo_ID = $_POST['peoID'];
            $school = $_POST['school'];
            if($_POST['bos_requ'] == "تعيين"){
                $num_request_B = 2; 
                $bo_requ = $con->prepare("UPDATE people SET People_school = ?, Des_Bos = ?, Point_Date = ? WHERE People_ID  = ?");
                $bo_requ->execute(array($school, $num_request_B, now(), $peo_ID));
        
            }elseif($_POST['bos_requ'] == "رفض"){
                $num_request_B = 1;
                $bo_requ = $con->prepare("UPDATE people SET Des_Bos = ? WHERE People_ID = ?");
                $bo_requ->execute(array($num_request_B, $peo_ID));

            }

        }


        $theMsg= '<div class= "alert alert-success"> تم معالجة الطلب</div>';
        redirectHome($theMsg, 4, 'main.php');
    }




    ob_end_flush();
    ?>