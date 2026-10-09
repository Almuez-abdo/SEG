<?php 
    ob_start();

    session_start();
    $pageTitle = "Boss";

    if(isset($_SESSION['user'])){
        $sUser = $_SESSION['user'];
        include "init.php";
        include $temp . "nav.php";

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            echo '<div class= "container text-start">';
            if(isset($_POST['quez_0'])){    
                $state_n     = $_POST['state_n'];
                $city_n      = $_POST['city_n'];
                $school_n    = $_POST['school_n'];
                $sub_1       = filter_var($_POST['type_1'], FILTER_SANITIZE_STRING);
                $num_1       = filter_var($_POST['num_1'], FILTER_SANITIZE_NUMBER_INT);
                $sub_2       = filter_var($_POST['type_2'], FILTER_SANITIZE_STRING);
                $num_2       = filter_var($_POST['num_2'], FILTER_SANITIZE_NUMBER_INT);
                $sub_3       = filter_var($_POST['type_3'], FILTER_SANITIZE_STRING);
                $num_3       = filter_var($_POST['num_3'], FILTER_SANITIZE_NUMBER_INT);
                $sub_4       = filter_var($_POST['type_4'], FILTER_SANITIZE_STRING);
                $num_4       = filter_var($_POST['num_4'], FILTER_SANITIZE_NUMBER_INT);
                $sub_5       = filter_var($_POST['type_5'], FILTER_SANITIZE_STRING);
                $num_5       = filter_var($_POST['num_5'], FILTER_SANITIZE_NUMBER_INT);
                $sub_6       = filter_var($_POST['type_6'], FILTER_SANITIZE_STRING);
                $num_6       = filter_var($_POST['num_6'], FILTER_SANITIZE_NUMBER_INT);
                $anther      = filter_var($_POST['another_r'], FILTER_SANITIZE_STRING);

                $sumSub = ("$sub_1 $sub_2 $sub_3 $sub_4 $sub_5 $sub_6");
                $numSub = ("$num_1 $num_2 $num_3 $num_4 $num_5 $num_6");
                
                $stmt = $con-> prepare("INSERT INTO 
                                            school_needs(info_id, state_id, area_id, school_id, Need_Tea, Num_Tea, Other_Need, Need_Date)
                                        VALUES(:id, :state, :city, :school, :subject, :num_sub, :other, now())");
                $stmt->execute(array(
                                'id'        => $sUser,
                                'state'     => $state_n,
                                'city'      => $city_n,
                                'school'    => $school_n,
                                'subject'   => $sumSub,
                                'num_sub'   => $numSub,
                                'other'    => $anther
                ));
                        
                $theMsg= '<div class= "alert alert-success">' . $stmt->rowCount() . ' تم أضافتها</div>';
                redirectHome($theMsg, 4, "main.php");

            }elseif(isset($_POST['quez_1'])){
                $type_p     = $_POST['type_Preak'];
                $time_p     = filter_var($_POST['time_q'], FILTER_SANITIZE_NUMBER_INT);
                $start_p    = $_POST['start_q'];
                $end_p      = $_POST['end_q'];
                $reson_p    = filter_var($_POST['ruson_q'], FILTER_SANITIZE_STRING);
                $place_p    = filter_var($_POST['place_q'], FILTER_SANITIZE_STRING);
                $phone_p    = filter_var($_POST['phone_q'], FILTER_SANITIZE_NUMBER_INT);
                
                $stmt = $con-> prepare("INSERT INTO 
                                            preak(info_id, Preak_Type, Preak_Num, Date_Start, Date_End, Preak_Reson, Preak_Addres, Preak_Phone, Preak_Date)
                                        VALUES(:id, :prType, :prNum, :prStart, :prEnd, :prReson, :prAddres, :prPhone, now())");
                $stmt->execute(array(
                                'id'        => $sUser,
                                'prType'    => $type_p,
                                'prNum'     => $time_p,
                                'prStart'   => $start_p,
                                'prEnd'     => $end_p,
                                'prReson'   => $reson_p,
                                'prAddres'  => $place_p,
                                'prPhone'   => $phone_p
                ));
                        
                $theMsg= '<div class= "alert alert-success">' . $stmt->rowCount() . ' تم أضافتها</div>';
                redirectHome($theMsg, 4, "main.php");

            }elseif(isset($_POST['quez_2'])){
                $start_ser  = $_POST['date_start'];
                $num_ser    = filter_var($_POST['num_serv'], FILTER_SANITIZE_NUMBER_INT);
                $reson_t    = filter_var($_POST['ruson_end'], FILTER_SANITIZE_STRING);
                
                $stmTk = $con-> prepare("INSERT INTO 
                                            pension(info_id, Date_Start, Num_Service, Pension_Reson, Pension_Date)
                                        VALUES(:id, :stDate, :tkNum, :tkReson, now())");
                $stmTk->execute(array(
                                'id'        => $sUser,
                                'stDate'    => $start_ser,
                                'tkNum'     => $num_ser,
                                'tkReson'   => $reson_t
                ));
                        
                $theMsg= '<div class= "alert alert-success">' . $stmTk->rowCount() . ' تم أضافتها</div>';
                redirectHome($theMsg, 4, "main.php");
            }elseif(isset($_POST['quez_3'])){
                $main_P         = filter_var($_POST['place_D'], FILTER_SANITIZE_STRING);
                $second_P       = filter_var($_POST['place_m'], FILTER_SANITIZE_STRING);
                $num_Ser        = filter_var($_POST['yaer_q'], FILTER_SANITIZE_NUMBER_INT);
                $city_Move      = $_POST['city'];
                $subject_tea    = filter_var($_POST['subject_q'], FILTER_SANITIZE_STRING);
                $class_tea      = filter_var($_POST['class_q'], FILTER_SANITIZE_STRING);
                $reson_M        = filter_var($_POST['ruson_m'], FILTER_SANITIZE_STRING);

    
                $stmMove = $con-> prepare("INSERT INTO 
                                            `move`(info_id, Old_Place, New_Place, Years_Service, area_id, Subject_T, Class_T, Move_Reson, Move_Date)
                                        VALUES(:id, :old, :new, :years, :city_m, :sub, :class, :rMove, now())");
                $stmMove->execute(array(
                                'id'        => $sUser,
                                'old'       => $main_P,
                                'new'       => $second_P,
                                'years'     => $num_Ser,
                                'city_m'    => $city_Move,
                                'sub'       => $subject_tea,
                                'class'     => $class_tea,
                                'rMove'     => $reson_M
                ));
                        
                $theMsg= '<div class= "alert alert-success">' . $stmMove->rowCount() . ' تم أضافتها</div>';
                redirectHome($theMsg, 4, "main.php");


            }elseif(isset($_POST['quez_4'])){
                $firstTa    = $_POST['date_start_f'];
                $date_tk    = $_POST['date_end_f'];
                $reson_end  = filter_var($_POST['ruson_end_f'], FILTER_SANITIZE_STRING);
               

    
                $stExt = $con-> prepare("INSERT INTO 
                                            extended_servce(info_id, First_Date, Last_Date, Extended_Reson, Extended_Date)
                                        VALUES(:id, :firstT, :lastTk, :reEx, now())");
                $stExt->execute(array(
                                'id'        => $sUser,
                                'firstT'    => $firstTa,
                                'lastTk'    => $date_tk,
                                'reEx'      => $reson_end,
                                
                ));
                        
                $theMsg= '<div class= "alert alert-success">' . $stExt->rowCount() . ' تم أضافتها</div>';
                redirectHome($theMsg, 4, "main.php");
            }
            
            echo '</div>';
        }
        
    }


    include $temp . "footer.php";
    ob_end_flush();
?>