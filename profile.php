<?php
    ob_start();
    session_start();
    $pageTitle = "profile";

    if(isset($_SESSION['user'])){
        $sUser = $_SESSION['user'];
        include 'init.php';
        include $temp .'nav.php';

        $userId = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0;
            
        $stFile = $con-> prepare("SELECT
                                        information.*,
                                        `state`.State_Name,
                                        area.Area_Name,
                                        school.School_Name
                                    FROM
                                        information
                                    INNER JOIN
                                        `state`
                                    ON
                                        `state`.State_ID = information.Person_State
                                    INNER JOIN
                                        area
                                    ON
                                        area.Area_ID = information.Person_City
                                    INNER JOIN
                                        school
                                    ON
                                        school.School_ID = information.Person_School
                                    WHERE Person_ID = ?");
        $stFile-> execute(array($userId));
        $proFiles = $stFile->fetch();
        $count = $stFile-> rowCount();
        if($count > 0){?>

            <div class= "pro">
                <div class="container">
                    <div class="row">
                        <div class="col-md-2 col-sm-4 py-3 bg-dark text-light">
                            <div class= "panel panel-success">
                                <div class= "panel-heading">
                                    <a href= "update.php">
                                        <?php
                                            if(! empty($my['Person_Avatar'])){
                                                echo '<img src="upload/avatar/' . $my['Person_Avatar'] . '" alt="" class="card-img-top">';
                                            }else{
                                                echo '<img src="layout/images/d-1-7.png" alt="" class="card-img-top">';
                                            }
                                        ?>                    
                                    </a>            
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 col-sm-4 py-3 bg-dark text-light">
                            <h2>المعلومات الشخصية :-</h2>
                            <hr>
                            <div>
                                <h5>الـــــرقم الـــــوطني : <span><?php echo $proFiles['Person_ID']; ?></span></h5>
                                <h5>الاســــــــــــــــــم : <?php echo $proFiles['Person_Name']; ?></span></h5>
                                <h5>تـــــاريخ المـــــيلاد : <?php echo $proFiles['Person_Date']; ?></span></h5>
                                <h5>مــــــكان المـــــيلاد : <?php echo $proFiles['Person_P_D']; ?></span></h5>
                                <h5>الـــــــــــــــــجنس : <?php if($proFiles['Gander'] == '1'){echo 'ذكر';}else{ echo 'أنثي';} ?></span></h5>
                                <h5>رقـــــم الـــــــهاتف : <?php echo $proFiles['Person_Phone']; ?></span></h5>
                                <h5>الـــحالة الاجـــتماعية : <?php echo $proFiles['Person_Status']; ?></span></h5>
                                <h5>عـــــــدد الاطفـــــال : <?php if($proFiles['Person_Kids'] == 0) {echo 'لايوجد';}else{echo $proFiles['Person_Kids'];} ?></span></h5>
                            </div>
                        </div>

                        <div class="col-md-5 col-sm-4 py-3 bg-dark text-light">
                            <h2>معلومات العمل :-</h2>
                            <hr>
                            <div>
                                <h5>الــــــــــــــــولاية : <?php echo $proFiles['State_Name']; ?></span></h5>
                                <h5>الـــــــــــــــمحلية : <?php echo $proFiles['Area_Name']; ?></span></h5>
                                <h5>الـــــــــــــــمدرسة : <?php echo $proFiles['School_Name']; ?></span></h5>
                                <h5>الــمعرفة بالــكمبيوتر : <?php if($proFiles['Person_Computer'] == '1'){echo 'نعم';}else{ echo 'لا';} ?></span></h5>
                                <h5>مهــــــارات آخـــــري : <?php echo $proFiles['Person_Program']; ?></span></h5>
                            </div>
                        <div>


                    </div>
                </div>

                <div class = "container py-3">
                    <div>
                        <h5>الطلبات السابقة :-</h5>
                        <hr>
                        
                        <div>    
                            <h4> الأجازات :- </h4>
                            <?php
                            $preakPro = $con->prepare("SELECT information.*,
                                                            preak.*
                                                        FROM
                                                            information
                                                        INNER JOIN
                                                            preak
                                                        ON
                                                            preak.info_id = information.Person_ID
                                                        WHERE
                                                            Person_ID = ?");
                            $preakPro->execute(array($userId));
                            $prcount = $preakPro->rowCount();
                            $preaks = $preakPro->fetchAll(); 
                            if($prcount > 0){ ?>
                                <div class= "container text-start">
                                    <div class= "table-responsive">
                                        <table class= "table table-bordered text-center">
                                            <tr class="bg-dark text-light">
                                                <td>الرقم</td>      
                                                <td>نوع الأجازة</td>      
                                                <td>عدد الايام</td>      
                                                <td>تاريخ البداية</td>      
                                                <td>تاريخ النهاية</td>      
                                                <td>سبب طلب الاجازة</td>  
                                                <td>تاريخ الطلب</td>      
                                            </tr>
                                    <?php        
                                    foreach($preaks as $preak){
                                        echo '<tr>';
                                            echo "<td>" . $preak['Preak_ID'] ."</td>";
                                            echo "<td>" . $preak['Preak_Type'] ."</td>";
                                            echo "<td>" . $preak['Preak_Num'] ."</td>";
                                            echo "<td>" . $preak['Date_Start'] ."</td>";
                                            echo "<td>" . $preak['Date_End'] ."</td>";
                                            echo "<td>" . $preak['Preak_Reson'] ."</td>";
                                            echo "<td>" . $preak['Preak_Date'] ."</td>";
                                        echo "</tr>";
                                    }
                                
                                        echo '</table>';
                                    echo '</div>';
                                echo '</div>';
                            }else{
                                echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                            } ?>

                            
                        </div>
                        <hr>

                        <div>
                            <h4> النقليات :- </h4>
                            <?php
                            $movePro = $con->prepare("SELECT information.*,
                                                            move.*
                                                        FROM
                                                            information
                                                        INNER JOIN
                                                            move
                                                        ON
                                                            move.info_id = information.Person_ID
                                                        WHERE
                                                            Person_ID = ?");
                            $movePro->execute(array($userId));
                            $moCount = $movePro->rowCount();
                            $moves = $movePro->fetchAll(); 
                            if($moCount > 0){ ?>
                                <div class= "container text-start">
                                    <div class= "table-responsive">
                                        <table class= "table table-bordered text-center">
                                            <tr class="bg-dark text-light">
                                                <td>الرقم</td>  
                                                <td>السكن الدائم</td>      
                                                <td>السكن الحالي</td>      
                                                <td>سنين الخدمة</td>      
                                                <td>سبب الأنتقال</td>      
                                                <td>تاريخ تقديم الطلب</td>
                                            </tr>
                                    <?php        
                                    foreach($moves as $move){
                                        echo '<tr>';
                                            echo "<td>" . $move['Move_ID'] ."</td>";
                                            echo "<td>" . $move['Old_Place'] ."</td>";
                                            echo "<td>" . $move['New_place'] ."</td>";
                                            echo "<td>" . $move['Years_Service'] ."</td>";
                                            echo "<td>" . $move['Move_Reson'] ."</td>";
                                            echo "<td>" . $move['Move_Date'] ."</td>";                                  
                                        echo "</tr>";
                                }
                                
                                        echo '</table>';
                                    echo '</div>';
                                echo '</div>';
                            }else{
                                echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                            } ?>
                        </div>
                        <hr>

                        <div>
                            <h4> التقاعد :- </h4>
                            <?php
                            $tkaodPro = $con->prepare("SELECT information.*,
                                                            pension.*
                                                        FROM
                                                            information
                                                        INNER JOIN
                                                            pension
                                                        ON
                                                            Pension.info_id = information.Person_ID
                                                        WHERE
                                                            Person_ID = ?");
                            $tkaodPro->execute(array($userId));
                            $tkCount = $tkaodPro->rowCount();
                            $tkaods = $tkaodPro->fetchAll();
                            if($tkCount > 0){ ?>
                                <div class= "container text-start">
                                    <div class= "table-responsive">
                                        <table class= "table table-bordered text-center">
                                            <tr class="bg-dark text-light">
                                                <td>الرقم</td>      
                                                <td>تاريخ التعيين</td>      
                                                <td>سنين الخدمة</td>      
                                                <td>سبب طلب التقاعد</td>
                                                <td>تاريخ الأضافة</td>
                                            </tr>
                                    <?php        
                                    foreach($tkaods as $tkaod){
                                        echo '<tr>';
                                            echo "<td>" . $tkaod['Pension_ID'] ."</td>";
                                            echo "<td>" . $tkaod['Date_Start'] ."</td>";
                                            echo "<td>" . $tkaod['Num_Service'] ."</td>";
                                            echo "<td>" . $tkaod['Pension_Reson'] ."</td>";
                                            echo "<td>" . $tkaod['Pension_Date'] ."</td>";                                  
                                        echo "</tr>";
                                }
                            
                                        echo '</table>';
                                    echo '</div>';
                                echo '</div>';
                            }else{
                                echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                            } ?>
                        </div>
                        <hr>

                        <div>
                            <h4> تمديد الخدمة :- </h4>
                            <?php
                            $extendedPro = $con->prepare("SELECT information.*,
                                                            extended_servce.*
                                                        FROM
                                                            information
                                                        INNER JOIN
                                                            extended_servce
                                                        ON
                                                            extended_servce.info_id = information.Person_ID
                                                        WHERE
                                                            Person_ID = ?");
                            $extendedPro->execute(array($userId));
                            $extCount = $extendedPro->rowCount();
                            $extended = $extendedPro->fetchAll(); 
                            if($extCount > 0){ ?>
                                <div class= "container text-start">
                                    <div class= "table-responsive">
                                        <table class= "table table-bordered text-center">
                                            <tr class="bg-dark text-light">
                                                <td>الرقم</td>      
                                                <td>تاريخ التعيين</td>      
                                                <td>تاريخ التقاعد</td>      
                                                <td>سبب أنهاء الخدمة</td>  
                                                <td>تاريخ الأضافة</td>
                                            </tr>
                                    <?php        
                                    foreach($extended as $extend){
                                        echo '<tr>';
                                            echo "<td>" . $tkaod['Extended_ID'] ."</td>";
                                            echo "<td>" . $tkaod['First_Date'] ."</td>";
                                            echo "<td>" . $tkaod['Last_Date'] ."</td>";
                                            echo "<td>" . $tkaod['Extended_Reson'] ."</td>";
                                            echo "<td>" . $tkaod['Extended_Date'] ."</td>";                                  
                                        echo "</tr>";
                                }
                                        echo '</table>';
                                    echo '</div>';
                                echo '</div>';
                            }else{
                                echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                            } ?>
                        </div>                            
                    </div>
                </div>
    <?php }else {
            $theMsg= '<div class= "alert alert-danger"> لاتوجد صفحة بهذا الرقم </div>';
            redirectHome($theMsg, 5, "back");
    }
    

    }else{
        header('location:log.php');
    }

    include $temp . 'footer.php';
?>