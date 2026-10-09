<?php

ob_start();
session_start();
$pageTitle = "update";

include "init.php";
include $temp. "nav.php";
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        echo '<div class= "container text-start">';

        $name       = filter_var($_POST['userName'], FILTER_SANITIZE_STRING);
        $fullN      = filter_var($_POST['fullName'], FILTER_SANITIZE_STRING);
        $phone      = filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT);
        $type       = $_POST['type'];
        $b_date     = filter_var($_POST['b-date'], FILTER_SANITIZE_NUMBER_INT);
        $placeDate  = filter_var($_POST['place_date'], FILTER_SANITIZE_STRING);
        $state      = $_POST['state'];
        $city       = $_POST['city'];
        $school     = $_POST['school'];
        $status     = $_POST['status'];
        $kids       = $_POST['kids'];
        $computer   = $_POST['computer'];
        $program    = $_POST['program'];

        if($status == 0){
            $status = "أعذب / عزباء";
        }elseif($status == 1){
            $status = "متزوج / ة";

        }elseif($status == 2){
            $status = "مطلق / ة";

        }elseif($status == 3){
            $status = "أرمل /ة";
        }

        $pass= (empty($_POST['new_password'])) ? $_POST['old_password'] : sha1($_POST['new_password']);


        // Validate The Form
        $formError = array();

        if(strlen($name) > 20 OR strlen($name) < 11 ){
            $formError[]= ' الرقم الوطني يجب ان لايقل عن  <strong> 11 رقم </strong> ولا يزيد عن  <strong> 20 رقم </strong>';
        }
        if(empty($fullN)){
            $formError[]= ' الاسم الشخصي لايمكن ان يكون <strong> خالي </strong>';
        }
        if(strlen($fullN) > 80 OR strlen($fullN) < 20 ){
            $formError[]= ' الاسم الشخصي لايمكن ان يكون اقل من  <strong> 20 حروف </strong> ولا اكبر من <strong> 80 حرف </strong>';
        }
        if(empty($phone)){
            $formError[]= '   رقم الهاتف يجب ان لا يكون <strong> خالي </strong>';
        }
        if(! empty($formError)){
            foreach($formError as $error){
                echo '<div class= "alert alert-danger">' . $error . '</div>';
            }
        }else{
       
            $stmt = $con-> prepare("SELECT
                                        * 
                                    FROM
                                        information
                                        
                                    WHERE
                                        Person_ID = ?
                                    ");
            $stmt-> execute(array($name));
            $count = $stmt->rowCount();
            
            if($count == 0){
                $theMsg= '<div class= "alert alert-danger">هذا المستخدم غير موجود </div>';
                redirectHome($theMsg, 4, "back");
            }else {
                $stmt = $con-> prepare("UPDATE 
                                            information
                                        SET 
                                            Person_Password = ?,
                                            Person_Name     = ?,
                                            Person_Date     = ?,
                                            Person_P_D      = ?,
                                            Gander          = ?, 
                                            Person_State    = ?,
                                            Person_City     = ?,
                                            Person_School   = ?, 
                                            Person_Phone    = ?,
                                            Person_Status   = ?,
                                            Person_Kids     = ?,
                                            Person_Computer = ?,
                                            Person_Program  = ?
                                        WHERE
                                            Person_ID = ?
                                        ");
                $stmt->execute(array($pass, $fullN, $b_date, $placeDate,
                                    $type, $state, $city, $school, $phone,
                                    $status, $kids, $computer, $program, $name));

                

                $theMsg= '<div class= "alert alert-success">' . $stmt-> rowCount() . ' تعديلات تمت </div>';
                redirectHome($theMsg, 6, 'main.php');
            }
        }


    } else {
        $theMsg= '<div class= "alert alert-danger"> لايمكن الدخول الي هذه الصفحة مباشرة </div>';
        redirectHome($theMsg, 6);
    }
    echo '</div>';

?>