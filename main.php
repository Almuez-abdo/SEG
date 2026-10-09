<?php
    ob_start();
    session_start();
    $pageTitle = "Main";

    include 'init.php';
    include $temp .'nav.php';


    if(isset($_SESSION['user'])){

        $sUser = $_SESSION['user'];
        
        $actUser = userActive($sUser);

        $manger = userManger($sUser);

        $boss = userBoss($sUser);

        if($boss){
            header('location: boss.php');
            exit();
        }
        
        $stmt12 = $con->prepare("SELECT
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
        $stmt12->execute(array($sUser));

        $my = $stmt12->fetch();


        if($actUser == 1){
            $theMsg = '<div class= "alert alert-success"> مرحبا ' . $my['Person_Name'] . ' حسابك لم يفعل بعد </div>';
            redirectHome($theMsg, 5, 'logout.php');
            
            }else{ 
                ?>
        



        <div class= "pro">
            <div class="container">
                <div class="row">
                    <div class="col-md-2 col-sm-4 py-3 dash-side">
                        <div class= "panel panel-success">
                            <div class= "panel-heading">
                                <?php
                                    if(! empty($my['Person_Avatar'])){
                                        echo '<img src="upload/avatar/' . $my['Person_Avatar'] . '" alt="" class="card-img-top">';
                                    }else{
                                        echo '<img src="layout/images/d-1-7.png" alt="" class="card-img-top">';
                                    }
                                ?>
                            </div>

                            <div class= "panel-body">
                                <h5 class="panel-name"><?php echo $my['Person_Name'] ;?></h5>
                                <h5>الوظيفة : <span class="text-success"><?php echo $my['Person_Job']; ?></span></h5>
                                <h5>الولاية : <span class="text-success"><?php echo $my['State_Name']; ?></span></h5>
                                <h5>المدرسة : <span class="text-success"><?php echo $my['School_Name']; ?></span></h5>
                            </div>
                        </div>
                        <?php
                        if($manger){?>
                            <div class="card req-card text-dark mb-2">
                                <h4>أحتياجات المدرسة</h4>
                                <button class="btn btn-success"><a href="quez.php?do=quez0"> تقديم الطلب</a></button>
                            </div>

                        <?php }
                        ?>
                        <div class="card req-card text-dark mb-2">
                            <h4>طلب أجازة</h4>
                            <button class="btn btn-success"><a href="quez.php?do=quez1"> تقديم الطلب</a></button>
                        </div>
                        <div class="card req-card text-dark mb-2">
                            <h4>طلب تقاعد</h4>
                            <button class="btn btn-success"><a href="quez.php?do=quez2">تقديم الطلب</a></button>
                        </div>
                        <div class="card req-card text-dark mb-2">
                            <h4>طلب نقل</h4>  
                            <button class="btn btn-success"><a href="quez.php?do=quez3">تقديم الطلب</a></button>
                        </div>
                        <div class="card req-card text-dark mb-2">
                            <h4>طلب تمديد خدمة</h4>
                            <button class="btn btn-success"><a href="quez.php?do=quez4">تقديم الطلب</a></button>
                        </div>
                        
                    </div>
                    <div class="col-md-10 col-sm-8 py-3 dash-main">
                        <div class= "myRequst dash-section">
                            <h2> متابعة طلباتي </h2>
                                <!-- preak Part -->
                            <div>
                            <?php
                                $stPreak = $con->prepare("SELECT * FROM preak WHERE info_id = ? ");
                                $stPreak->execute(array($_SESSION['user']));
                                $preakC = $stPreak->rowCount();
                                $preaks = $stPreak->fetchAll(); 
                                    echo '<h4> الأجازة :- </h4>';
                                    if($preakC > 0){?>
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
                                                    <td>تاريخ الأضافة</td>      
                                                    <td>قرار المدير</td>
                                                    <?php
                                            foreach($preaks as $preak){
                                                    if($preak['Des_Manger'] == 2){echo '<td>قرار الوزارة</td>';}
                                            echo '</tr>';
                                            echo "<tr>";
                                                echo "<td>" . $preak['Preak_ID'] . "</td>";
                                                echo "<td>" . $preak['Preak_Type'] . "</td>";
                                                echo "<td>" . $preak['Preak_Num'] . "</td>";
                                                echo "<td>" . $preak['Date_Start'] . "</td>";
                                                echo "<td>" . $preak['Date_End'] . "</td>";
                                                echo "<td>" . $preak['Preak_Reson'] . "</td>";
                                                echo "<td>" . $preak['Preak_Date'] . "</td>";
                                                echo "<td>";
                                                if(!($manger)){
                                                        if($preak['Des_Manger'] == 0){
                                                            echo "في أنتظار قرار المدير";
                                                        }elseif($preak['Des_Manger'] == 1){
                                                            echo "تم رفض الطلب";
                                                            
                                                        }else{
                                                            echo "تم قبول الطلب";
                                                        }
                                                }else{
                                                    echo 'تم قبول الطلب';
                                                    $is_manger = $con->prepare("UPDATE preak SET Des_Manger = 2 WHERE info_id = ?");
                                                    $is_manger->execute(array($sUser));
                                                }
                                                echo "</td>";
                                                if($preak['Des_Manger'] == 2){
                                                    echo "<td>";
                                                        if($preak['Des_Bos'] == 0){
                                                            echo "في أنتظار قرار الوزارة";
                                                        }elseif($preak['Des_Bos'] == 1){
                                                            echo "تم رفض الطلب";
                                                        }else{
                                                            echo "تم قبول الطلب";
                                                        }
                                                    echo "</td>";
                                                }
                                            ?>
                                                </tr>
                                    <?php }
                                        echo '</table>';
                                    echo '</div>';
                                echo '</div>';
                                        }else{
                                            echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                                        } ?>
                            </div>

                            <!-- Move Part -->
                            <div>
                            <?php
                                $stMove = $con->prepare("SELECT 
                                                                `move`.*, area.Area_Name
                                                            FROM 
                                                                `move`
                                                            INNER JOIN
                                                                area
                                                            ON
                                                                area.Area_ID = move.area_id
                                                            WHERE 
                                                                info_id = ?
                                                            ");
                                $stMove->execute(array($_SESSION['user']));
                                $moCount = $stMove->rowCount();
                                $moves = $stMove->fetchAll();
                                    echo '<h4> النقليات :- </h4>';
                                    if($moCount > 0){?>
                                    <div class= "container text-start">
                                        <div class= "table-responsive">
                                            <table class= "table table-bordered text-center">
                                                <tr class="bg-dark text-light">
                                                    <td>الرقم</td>  
                                                    <td>السكن الدائم</td>      
                                                    <td>السكن الحالي</td>      
                                                    <td>سنين الخدمة</td>      
                                                    <td>الانتقال الي</td>  
                                                    <td>المادة</td>
                                                    <td>الفصول</td> 
                                                    <td>سبب الأنتقال</td>      
                                                    <td>تاريخ تقديم الطلب</td>
                                                    <td>قرار المدير</td>
                                                    <?php
                                                foreach($moves as $move){
                                                    if($move['Des_Manger'] == 2){echo '<td>قرار الوزارة</td>';}
                                                echo '</tr>';
                                            echo"<tr>";
                                                echo "<td>" . $move['Move_ID'] . "</td>";
                                                echo "<td>" . $move['Old_Place'] . "</td>";
                                                echo "<td>" . $move['New_Place'] . "</td>";
                                                echo "<td>" . $move['Years_Service'] . "</td>";
                                                echo "<td>" . $move['Area_Name'] . "</td>";
                                                echo "<td>" . $move['Subject_T'] . "</td>";
                                                echo "<td>" . $move['Class_T'] . "</td>";
                                                echo "<td>" . $move['Move_Reson'] . "</td>";
                                                echo "<td>" . $move['Move_Date'] . "</td>";
                                                echo "<td>";
                                                if(!($manger)){
                                                        if($move['Des_Manger'] == 0){
                                                            echo "في أنتظار قرار المدير";
                                                        }elseif($move['Des_Manger'] == 1){
                                                            echo "تم رفض الطلب";
                                                            
                                                        }else{
                                                            echo "تم قبول الطلب";
                                                        }
                                                }else{
                                                    echo 'تم قبول الطلب';
                                                    $is_manger = $con->prepare("UPDATE `move` SET Des_Manger = 2 WHERE info_id = ?");
                                                    $is_manger->execute(array($sUser));
                                                }
                                                echo "</td>";
                                                if($move['Des_Manger'] == 2){
                                                    echo "<td>";
                                                        if($move['Des_Bos'] == 0){
                                                            echo "في أنتظار قرار الوزارة";
                                                        }elseif($move['Des_Bos'] == 1){
                                                            echo "تم رفض الطلب";
                                                        }else{
                                                            echo "تم قبول الطلب";
                                                        }
                                                    echo "</td>";
                                                }
                                            ?>
                                                </tr>
                                    <?php }
                                        echo '</table>';
                                    echo '</div>';
                                echo '</div>';
                                        }else{
                                            echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                                        } ?>
                            </div>


                            <!-- Tkaod Page -->
                            <div>
                            <?php
                                $stTkaod = $con->prepare("SELECT * FROM pension WHERE info_id = ? ");
                                $stTkaod->execute(array($sUser));
                                $tkCount = $stTkaod->rowCount();
                                $tkaods = $stTkaod->fetchAll();
                                    echo '<h4> التقاعد :- </h4>';
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
                                                    <td>قرار المدير</td>
                                                    <?php
                                                foreach($tkaods as $tkaod){
                                                    if($tkaod['Des_Manger'] == 2){echo '<td>قرار الوزارة</td>';} 
                                            echo '</tr>';               
                                            echo "<tr>";
                                                echo "<td>" . $tkaod['Pension_ID'] . "</td>";
                                                echo "<td>" . $tkaod['Date_Start'] . "</td>";
                                                echo "<td>" . $tkaod['Num_Service'] . "</td>";
                                                echo "<td>" . $tkaod['Pension_Reson'] . "</td>";
                                                echo "<td>" . $tkaod['Pension_Date'] . "</td>";
                                                echo "<td>";
                                                if(!($manger)){
                                                        if($tkaod['Des_Manger'] == 0){
                                                            echo "في أنتظار قرار المدير";
                                                        }elseif($tkaod['Des_Manger'] == 1){
                                                            echo "تم رفض الطلب";
                                                            
                                                        }else{
                                                            echo "تم قبول الطلب";
                                                        }
                                                }else{
                                                    echo 'تم قبول الطلب';
                                                    $tk_manger = $con->prepare("UPDATE tkaod SET Des_Manger = 2 WHERE info_id = ?");
                                                    $tk_manger->execute(array($sUser));
                                                }
                                                echo "</td>";
                                                if($tkaod['Des_Manger'] == 2){
                                                    echo "<td>";
                                                        if($tkaod['Des_Bos'] == 0){
                                                            echo "في أنتظار قرار الوزارة";
                                                        }elseif($tkaod['Des_Bos'] == 1){
                                                            echo "تم رفض الطلب";
                                                        }else{
                                                            echo "تم قبول الطلب";
                                                        }
                                                    echo "</td>";
                                                }
                                            ?>
                                                </tr>
                                    <?php }
                                        echo '</table>';
                                    echo '</div>';
                                echo '</div>';
                                        }else{
                                            echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                                        } ?>
                            </div>

                            <!-- Tamded page -->
                            <div>
                            <?php
                                $stExt = $con->prepare("SELECT * FROM extended_servce WHERE info_id = ? ");
                                $stExt->execute(array($sUser));
                                $extC = $stExt->rowCount();
                                $extens = $stExt->fetchAll();
                                    echo '<h4> تمديد الخدمة :- </h4>';
                                    if($extC > 0){ ?>
                                    <div class= "container text-start">
                                        <div class= "table-responsive">
                                            <table class= "table table-bordered text-center">
                                                <tr class="bg-dark text-light">
                                                    <td>الرقم</td>      
                                                    <td>تاريخ التعيين</td>      
                                                    <td>تاريخ التقاعد</td>      
                                                    <td>سبب أنهاء الخدمة</td>  
                                                    <td>تاريخ الأضافة</td>      
                                                    <td>قرار الوزارة</td>      
                                                </tr>
                                    <?php
                                        foreach($extens as $exten){
                                            echo"<tr>";
                                                echo "<td>" . $exten['Extended_ID'] . "</td>";    
                                                echo "<td>" . $exten['First_Date'] . "</td>";
                                                echo "<td>" . $exten['Last_Date'] . "</td>";
                                                echo "<td>" . $exten['Extended_Reson'] . "</td>";
                                                echo "<td>" . $exten['Extended_Date'] . "</td>";
                                                echo "<td>";
                                                        if($exten['Des_Bos'] == 0){
                                                            echo "في أنتظار قرار الوزارة";
                                                        }elseif($exten['Des_Bos'] == 1){
                                                            echo "تم رفض الطلب";
                                                        }else{
                                                            echo "تم قبول الطلب";
                                                        }
                                                echo "</td>";
                                            ?>
                                                </tr>
                                    <?php }
                                        echo '</table>';
                                    echo '</div>';
                                echo '</div>';
                                        }else{
                                            echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                                        } ?>
                            </div>          
                        </div>
                    
                        <div class= "request dash-section">
                    <!-- Requested reviow -->
                        <?php if($manger){ ?>
                            <h2>متابعة الطلبات</h2>
                            <div>
                                <!-- School Needs -->
                                <h4> أحتياجات المدارس :</h4>
                                <span class= "need_t">
                                <?php 
                                $stmt1 = $con->prepare("SELECT * FROM school_needs WHERE info_id = ?");
                                $stmt1->execute(array($sUser));
                                $needC = $stmt1->rowCount();
                                $needs = $stmt1->fetchAll();
                                if($needC > 0){ ?>
                                    <div class= "container text-start">
                                        <div class= "table-responsive">
                                            <table class= "table table-bordered text-center">
                                                <tr class="bg-dark text-light">
                                                    <td>الرقم</td>      
                                                    <td>أسم المادة</td>      
                                                    <td>عدد المعلمين المطلوب</td>      
                                                    <td>الاحتياجات الاخري</td>      
                                                    <td>تاريخ الطلب</td>           
                                                    <td>قرار الوزارة</td>      
                                                </tr>
                                            <?php
                                            foreach($needs as $need){
                                                echo"<tr>";
                                                    echo "<td>" . $need['Need_ID'] . "</td>";
                                                    echo "<td>" . str_replace(" ", "<br />", $need['Need_Tea']) . "</td>";
                                                    echo "<td>" . str_replace(" ", "<br />", $need['Num_Tea']) . "</td>";
                                                    echo "<td>" . str_replace(" ", "<br />", $need['Other_Need']) . "</td>";
                                                    echo "<td>" . $need['Need_Date'] . "</td>";
                                                    echo "<td>";
                                                            if($need['Des_Bos'] == 0){
                                                                echo "في أنتظار قرار الوزارة";
                                                            }elseif($need['Des_Bos'] == 2){
                                                                echo "تم قبول الطلب";
                                                            }else{
                                                                echo "تم رفض الطلب";
                                                            }
                                                    echo "</td>";
                                                echo "</tr>"; 
                                                    }?>

                                            </table>
                                        </div>
                                    </div>
                                <?php }else{
                                            echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                                        }
                                        ?>
                            </div>
                                  
                            <div>
                                <!-- Teatshers Request -->
                                <h4>طلبات الاساتذة : </h4>
                                <?php
                                $stMang = $con->prepare("SELECT school.*, information.*
                                                        FROM school
                                                        INNER JOIN
                                                            information
                                                        ON
                                                            information.Person_School = school.school_ID
                                                        WHERE school_manger = ?
                                                        ");
                                $stMang ->execute(array($sUser));
                                $mang = $stMang->fetch();
                                $isManger = $mang['School_ID'];
                                ?>
                                <div>
                                    <h5>الأجازات :-</h5>
                                    
                                    <?php
                                    $stAll = $con->prepare("SELECT 
                                                                preak.*, 
                                                                information.*,
                                                                school.*
                                                            FROM 
                                                                preak
                                                            INNER JOIN
                                                                information
                                                            ON
                                                                information.Person_ID = preak.info_id
                                                            INNER JOIN
                                                                school
                                                            ON
                                                                school.School_ID = information.Person_School
                                                            
                                                            WHERE Des_Manger = 0 AND school_manger = ?");
                                    $stAll->execute(array($sUser));
                                    $prCount = $stAll->rowCount();
                                    $prAll = $stAll->fetchAll(); 
                                    if($prCount > 0){ ?>
                                        <div class= "container text-start">
                                            <div class= "table-responsive">
                                                <table class= "table table-bordered text-center">
                                                    <tr class="bg-dark text-light">
                                                        <td>الرقم</td>      
                                                        <td>مقدم الطلب</td>      
                                                        <td>نوع الأجازة</td>      
                                                        <td>عدد الايام</td>      
                                                        <td>تاريخ البداية</td>      
                                                        <td>تاريخ النهاية</td>      
                                                        <td>سبب طلب الاجازة</td>  
                                                        <td>تاريخ الأضافة</td>      
                                                        <td>القرار</td>      
                                                    </tr>
                                            <?php
                                            foreach($prAll as $pe){
                                                echo"<tr>";
                                                    echo "<td>" . $pe['Preak_ID'] . "</td>";
                                                    echo "<td><a href= 'profile.php?userID= " . $pe['info_id'] . "'>"
                                                    . $pe['Person_Name'] . "</a></td>";
                                                    echo "<td>" . $pe['Preak_Type'] . "</td>";
                                                    echo "<td>" . $pe['Preak_Num'] . "</td>";
                                                    echo "<td>" . $pe['Date_Start'] . "</td>";
                                                    echo "<td>" . $pe['Date_End'] . "</td>";
                                                    echo "<td>" . $pe['Preak_Reson'] . "</td>";
                                                    echo "<td>" . $pe['Preak_Date'] . "</td>";
                                                    ?>
                                                        
                                                        <td>
                                                            <form class= "form-horizontal" action= "manger_cont.php" method= 'POST'>
                                                                <input type= 'submit' value= 'نعم' name= 'des' class= 'btn btn-success'>
                                                                <input type= 'submit' value= 'لا' name= 'des' class= 'btn btn-danger'>
                                                                <input type= 'hidden' value = "<?php echo $pe['Preak_ID']; ?>" name= 'numPreak' />
                                                            </form>
                                                        </td>
                                                    </tr>
                                            <?php } ?>
                                                </table>
                                            </div>
                                        </div>
                                <?php }else{
                                            echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                                        }
                                        ?>
                                </div>

                                <div>
                                    <h5>النقليات :-</h5>
                                    <?php
                                    $allMove = $con->prepare("SELECT 
                                                                    `move`.*, information.*, area.Area_Name
                                                                FROM 
                                                                    `move`
                                                                INNER JOIN
                                                                    information
                                                                ON
                                                                    information.Person_ID = move.info_id 
                                                                INNER JOIN
                                                                    area
                                                                ON
                                                                    area.Area_ID = move.area_id
                                                                WHERE 
                                                                    Des_Manger = 0 AND Person_School = $isManger ");
                                    $allMove->execute();
                                    $moCount = $allMove->rowCount();
                                    $movAll = $allMove->fetchAll();
                                    if($moCount == 1){ ?>                    
                                        <div class= "container text-start">
                                            <div class= "table-responsive">
                                                <table class= "table table-bordered text-center">
                                                    <tr class="bg-dark text-light">
                                                        <td>الرقم</td>  
                                                        <td>مقدم الطلب</td>      
                                                        <td>السكن الدائم</td>      
                                                        <td>السكن الحالي</td>      
                                                        <td>سنين الخدمة</td>      
                                                        <td>الانتقال الي</td>  
                                                        <td>المادة</td>
                                                        <td>الفصول</td> 
                                                        <td>سبب الأنتقال</td>      
                                                        <td>تاريخ تقديم الطلب</td>      
                                                        <td>القرار</td>      
                                                    </tr>
                                        <?php
                                            foreach($movAll as $mov){
                                                echo"<tr>";
                                                    echo "<td>" . $mov['Move_ID'] . "</td>";
                                                    echo "<td><a href= 'profile.php?userID= " . $mov['info_id'] . "'>"
                                                    . $mov['Person_Name'] . "</a></td>";
                                                    echo "<td>" . $mov['Old_Place'] . "</td>";
                                                    echo "<td>" . $mov['New_Place'] . "</td>";
                                                    echo "<td>" . $mov['Years_Service'] . "</td>";
                                                    echo "<td>" . $mov['Area_Name'] . "</td>";
                                                    echo "<td>" . $mov['Subject_T'] . "</td>";
                                                    echo "<td>" . $mov['Class_T'] . "</td>";
                                                    echo "<td>" . $mov['Move_Reson'] . "</td>";
                                                    echo "<td>" . $mov['Move_Date'] . "</td>";
                                                    echo "<td>"; ?>
                                                    
                                                            <form class= "form-horizontal" action= "manger_cont.php" method= 'POST'>
                                                                <input type= 'submit' value= 'نعم' name= 'des' class= 'btn btn-success'>
                                                                <input type= 'submit' value= 'لا' name= 'des' class= 'btn btn-danger'>
                                                                <input type= 'hidden' value = "<?php echo $mov['Move_ID']; ?>" name= 'move_ma' />
                                                            </form>
                                                
                                                        </td>
                                                    </tr>
                                            <?php } ?>
                                                </table>
                                            </div>
                                        </div>
                                <?php }else{
                                            echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                                        }
                                        ?>
                                </div>

                                <div>
                                    <h5>التقاعد :-</h5>
                                    <?php
                                    $stTkaod = $con->prepare("SELECT 
                                                                    pension.*, information.*
                                                                FROM 
                                                                    pension
                                                                INNER JOIN
                                                                    information
                                                                ON
                                                                    information.Person_ID = pension.info_id 
                                                                WHERE 
                                                                    Des_Manger = 0 AND Person_School = $isManger ");
                                    $stTkaod->execute();
                                    $tkCount = $stTkaod->rowCount();
                                    $tkaods = $stTkaod->fetchAll();
                                    if($tkCount == 1){ ?>                    
                                        <div class= "container text-start">
                                            <div class= "table-responsive">
                                                <table class= "table table-bordered text-center">
                                                    <tr class="bg-dark text-light">
                                                        <td>الرقم</td>      
                                                        <td>مقدم الطلب</td>      
                                                        <td>تاريخ التعيين</td>      
                                                        <td>سنين الخدمة</td>      
                                                        <td>سبب طلب التقاعد</td>
                                                        <td>تاريخ الأضافة</td>      
                                                        <td>القرار</td>      
                                                    </tr>
                                        <?php
                                            foreach($tkaods as $tkaod){
                                                echo"<tr>";
                                                    echo "<td>" . $tkaod['Pension_ID'] . "</td>";
                                                    echo "<td><a href= 'profile.php?userID= " . $tkaod['info_id'] . "'>"
                                                    . $tkaod['Person_Name'] . "</a></td>";                                                
                                                    echo "<td>" . $tkaod['Date_Start'] . "</td>";
                                                    echo "<td>" . $tkaod['Num_Service'] . "</td>";
                                                    echo "<td>" . $tkaod['Pension_Reson'] . "</td>";
                                                    echo "<td>" . $tkaod['Pension_Date'] . "</td>";
                                                    echo "<td>"; ?>
                                                    
                                                            <form class= "form-horizontal" action= "manger_cont.php" method= 'POST'>
                                                                <input type= 'submit' value= 'نعم' name= 'tk_manger' class= 'btn btn-success'>
                                                                <input type= 'submit' value= 'لا' name= 'tk_manger' class= 'btn btn-danger'>
                                                                <input type= 'hidden' value = "<?php echo $tkaod['Pension_ID']; ?>" name= 'tkaod_ma' />
                                                            </form>
                                                        
                                                        </td>
                                                    </tr>
                                            <?php } ?>
                                                </table>
                                            </div>
                                        </div>
                                <?php }else{
                                            echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                                        }
                                        ?>
                                </div>
                            </div>
                                
                            <div>
                                <!-- T3inat -->
                                <h5>تعينات الوزارة :- </h5>
                                <?php
                                $stTaeen = $con->prepare("SELECT 
                                                                *
                                                            FROM 
                                                            people
                                                            
                                                            WHERE 
                                                                Des_Bos = 2 AND People_school = $isManger ");
                                $stTaeen->execute();
                                $tCount = $stTaeen->rowCount();
                                $taeens = $stTaeen->fetchAll();
                                if($tCount > 0){ ?>                    
                                    <div class= "container text-start">
                                        <div class= "table-responsive">
                                            <table class= "table table-bordered text-center">
                                                <tr class="bg-dark text-light">
                                                    <td>الرقم</td>      
                                                    <td>الاسم</td>      
                                                    <td>الجامعة</td>      
                                                    <td>التخصص</td>      
                                                    <td>المادة</td>
                                                    <td>تاريخ التعيين</td>      
                                                </tr>
                                    <?php
                                        foreach($taeens as $taeen){
                                            echo"<tr>";
                                                echo "<td>" . $taeen['People_ID'] . "</td>";                                               
                                                echo "<td>" . $taeen['People_Name'] . "</td>";
                                                echo "<td>" . $taeen['Grad_Univ'] . "</td>";
                                                echo "<td>" . $taeen['Univ_Part'] . "</td>";
                                                echo "<td>" . $taeen['Subject_T'] . "</td>";
                                                echo "<td>" . $taeen['Point_Date'] . "</td>";
                                            echo "</tr>";
                                        } ?>
                                            </table>
                                        </div>
                                    </div>

                                    <?php }else{
                                            echo '<div class= "alert alert-success">لا توجد تعينات</div>';
                                        }
                                        ?>
                            </div>

                        <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <div class="adver">
                <h2>أعلانات</h2>
                <?php
                $stAdver = $con->prepare("SELECT * FROM adver ORDER BY Adver_Date DESC");
                $stAdver->execute();
                $advers = $stAdver->fetchAll(); ?>
                <div class="text-end text-light">
                    <ul>
                        <?php foreach($advers as $adver){ ?>
                        <li>
                            <h6><?php echo $adver['Adver_Subject'] ?> <span><?php echo $adver['Adver_Date'] ?></span> </h6>
                            <p><?php echo $adver['Adver_Text'] ?></p>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
    <?php 

        }
           
    }else{
            header('location:log.php');
    }


     include $temp . 'footer.php'; 
     ob_end_flush();   

?>