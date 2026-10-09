<?php

    ob_start();
    session_start();
    $pageTitle = "boss";

    include 'init.php';

    if(isset($_SESSION['user'])){
        $sUser = $_SESSION['user'];
?>

        <nav class="navbar navbar-expand-md header_title">
            <div class="container">
                <a class="navbar-brand" href= "boss.php"><img src="layout/images/logo.png" alt="no Service"></a>     
                <button
                class="navbar-toggler" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#mainmune">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mainmune">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item"><a href="boss.php" class="nav-link active">شؤون الموظفين</a></li>
                        <li class="nav-item"><a href="adver.php" class="nav-link">الأعلانات</a></li>
                        <li class="nav-item"><a href="logout.php" class="nav-link">تسجيل الخروج </a></li>
                    </ul>
                </div>
            </div>
        </nav>


    <?php
        if($_SESSION['uID'] == 2){ // Height School  ?>
            
            <div class= "container">
                <h2>متابعة الطلبات</h2>
                <div>
                    <!-- School Needs -->
                    <h4> أحتياجات المدارس :</h4>
                    <span class= "need_t">
                    <?php 
                    $stNeed = $con->prepare("SELECT 
                                                school_needs.*,
                                                school.*
                                            FROM 
                                                school_needs 
                                            INNER JOIN
                                                school
                                            ON
                                                school.School_ID = school_needs.school_id 
                                            WHERE
                                                Des_Bos = 0 AND School_Part = 2
                                            ");
                    $stNeed->execute();
                    $nCount = $stNeed->rowCount();
                    $needs = $stNeed->fetchAll();

                    if($nCount > 0){
                    ?>
                        <div class= "container text-start">
                            <div class= "table-responsive">
                                <table class= "table table-bordered text-center">
                                    <tr class="bg-dark text-light">
                                        <td>الرقم</td>      
                                        <td>أسم المدرسة</td> 
                                        <td>تخصص المعلمين</td>
                                        <td>عدد المعلمين</td>      
                                        <td>الاحتياجات الاخري</td>      
                                        <td>تاريخ الطلب</td>           
                                        <td>القرار الوزارة</td>      
                                    </tr>
                                <?php
                                foreach($needs as $need){
                                    echo"<tr>";
                                        echo "<td>" . $need['Need_ID'] . "</td>";
                                        echo "<td>" . $need['School_Name'] . "</td>";
                                        echo "<td>" . str_replace(" ", "<br />", $need['Need_Tea']) . "</td>";
                                        echo "<td>" . str_replace(" ", "<br />", $need['Num_Tea']) . "</td>";
                                        echo "<td>" . str_replace(" ", "<br />", $need['Other_Need']) . "</td>";
                                        echo "<td>" . $need['Need_Date'] . "</td>"; ?>
                                            <td>
                                                <form class= "form-horizontal" action= "manger_cont.php" method= 'POST'>
                                                    <input type= 'submit' value= 'أوافق' name= 'boss' class= 'btn btn-success'>
                                                    <input type= 'submit' value= 'لا أوافق' name= 'boss' class= 'btn btn-danger'>
                                                    <input type= 'hidden' value = "<?php echo $need['Need_ID'];?>" name= 'sch_need' />
                                                </form>
                                            </td>
                                        </tr>
                                <?php } ?>
                                </table>
                            </div>
                        </div>
                    <?php }else{
                            echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                        }?>
                </div>

                <div>
                    <!-- Teatshers Request -->
                    <h4>طلبات الاساتذة : </h4>

                    <!-- Preak -->
                    <div>
                        <h5>الأجازات :-</h5>
                        <?php
                        $stAll = $con->prepare("SELECT preak.*, information.*, school.*
                                                FROM 
                                                    preak
                                                INNER JOIN
                                                    information
                                                ON
                                                    information.Person_ID = preak.info_id
                                                INNER JOIN
                                                    school
                                                ON
                                                    school.School_ID = preak.school_id 
                                                WHERE 
                                                    Des_Manger = 2 AND Des_Bos = 0 AND School_Part = 2");
                        $stAll->execute();
                        $prCount = $stAll->rowCount();
                        $prAll = $stAll->fetchAll();
                        if($prCount > 0){ 
                        ?>
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
                                                    <input type= 'submit' value= 'نعم' name= 'boss' class= 'btn btn-success'>
                                                    <input type= 'submit' value= 'لا' name= 'boss' class= 'btn btn-danger'>
                                                    <input type= 'hidden' value = "<?php echo $pe['Preak_ID'];?>" name= 'prID' />
                                                </form>
                                            </td>
                                        </tr>
                                <?php } ?>
                                    </table>
                                </div>
                            </div>
                        <?php }else{
                            echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                        } ?>
                    </div>

                    <!-- Move -->
                    <div>
                        <h5>النقليات :-</h5>
                        <?php
                        $stMove = $con->prepare("SELECT move.*, information.*, area.*, school.*
                                                FROM 
                                                    move
                                                INNER JOIN
                                                    information
                                                ON
                                                    information.Person_ID = move.info_id
                                                INNER JOIN
                                                    area
                                                ON
                                                    area.Area_ID = move.area_id 
                                                INNER JOIN
                                                    school
                                                ON
                                                    school.School_ID = move.school_id 
                                                WHERE 
                                                    Des_Manger = 2 AND Des_Bos = 0 AND School_Part = 2");
                        $stMove->execute();
                        $moCount = $stMove->rowCount();
                        $moves = $stMove->fetchAll();
                        if($moCount > 0){
                        ?>
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
                                foreach($moves as $move){
                                    echo"<tr>";
                                        echo "<td>" . $move['Move_ID'] . "</td>";
                                        echo "<td><a href= 'profile.php?userID= " . $move['info_id'] . "'>"
                                        . $move['Person_Name'] . "</a></td>";
                                        echo "<td>" . $move['Old_Place'] . "</td>";
                                        echo "<td>" . $move['New_Place'] . "</td>";
                                        echo "<td>" . $move['Years_Service'] . "</td>";
                                        echo "<td>" . $move['Area_Name'] . "</td>";
                                        echo "<td>" . $move['Subject_T'] . "</td>";
                                        echo "<td>" . $move['Class_T'] . "</td>";
                                        echo "<td>" . $move['Move_Reson'] . "</td>";
                                        echo "<td>" . $move['Move_Date'] . "</td>";
                                        ?>
                                            <td>
                                                <form class= "form-horizontal" action= "manger_cont.php" method= 'POST'>
                                                    <input type= 'submit' value= 'نعم' name= 'boss_Move' class= 'btn btn-success'>
                                                    <input type= 'submit' value= 'لا' name= 'boss_Move' class= 'btn btn-danger'>
                                                    <input type= 'hidden' value = "<?php echo $move['Move_ID'];?>" name= 'moID' />
                                                </form>
                                            </td>
                                        </tr>
                                <?php } ?>
                                    </table>
                                </div>
                            </div>
                        <?php }else{
                            echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                        } ?>
                    </div>
                    
                    <!-- Tka3d -->
                    <div>
                        <h5>التقاعد :-</h5>
                        <?php
                        $stTkaod = $con->prepare("SELECT 
                                                        pension.*, information.*, school.*
                                                    FROM 
                                                        pension
                                                    INNER JOIN
                                                        information
                                                    ON
                                                        information.Person_ID = pension.info_id
                                                    INNER JOIN
                                                        school
                                                    ON
                                                        school.School_ID = pension.school_id  
                                                    WHERE 
                                                        Des_Manger = 2 AND Des_Bos = 0 AND School_Part = 2
                                                    ");
                        $stTkaod->execute();
                        $tkCount = $stTkaod->rowCount();
                        $tkaods = $stTkaod->fetchAll();
                        if($tkCount > 0) {?>
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
                                        . $tkaod['Person_Name'] . "</a></td>";                                                echo "<td>" . $tkaod['Date_Start'] . "</td>";
                                        echo "<td>" . $tkaod['Num_Service'] . "</td>";
                                        echo "<td>" . $tkaod['Pension_Reson'] . "</td>";
                                        echo "<td>" . $tkaod['Pension_Date'] . "</td>";
                                        echo "<td>"; ?>
                                        
                                                <form class= "form-horizontal" action= "manger_cont.php" method= 'POST'>
                                                    <input type= 'submit' value= 'نعم' name= 'boss_tkaod' class= 'btn btn-success'>
                                                    <input type= 'submit' value= 'لا' name= 'boss_tkaod' class= 'btn btn-danger'>
                                                    <input type= 'hidden' value = "<?php echo $tkaod['Pension_ID'];?>" name= 'tkID' />
                                                </form>
                                            
                                            </td>
                                        </tr>
                                <?php } ?>
                                    </table>
                                </div>
                            </div>
                        <?php }else{
                            echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                        } ?>
                    </div>

                    <!-- Tmdid -->
                    <div>
                        <h5> تمديد الخدمة :- </h5>
                        <?php
                        $stExt = $con->prepare("SELECT 
                                                        extended_servce.*, information.Person_Name, school.*
                                                    FROM 
                                                        extended_servce
                                                    INNER JOIN
                                                        information
                                                    ON
                                                        information.Person_ID = extended_servce.info_id
                                                    INNER JOIN
                                                        school
                                                    ON
                                                        school.school_ID = extended_servce.school_id 
                                                    WHERE 
                                                        Des_Bos = 0 AND School_Part = 2
                                                    ");
                        $stExt->execute();
                        $exCount = $stExt->rowCount();
                        $extens = $stExt->fetchAll();
                        if($exCount > 0){?>
                            <div class= "container text-start">
                                <div class= "table-responsive">
                                    <table class= "table table-bordered text-center">
                                        <tr class="bg-dark text-light">
                                            <td>الرقم</td>      
                                            <td>مقدم الطلب</td>      
                                            <td>تاريخ التعيين</td>      
                                            <td>تاريخ التقاعد</td>      
                                            <td>سبب أنهاء الخدمة</td>  
                                            <td>تاريخ الأضافة</td>      
                                            <td>القرار</td>      
                                        </tr>
                            <?php
                                foreach($extens as $exten){
                                    echo"<tr>";
                                        echo "<td>" . $exten['Extended_ID'] . "</td>";
                                        echo "<td><a href= 'profile.php?userID= " . $exten['info_id'] . "'>"
                                        . $exten['Person_Name'] . "</a></td>";    
                                        echo "<td>" . $exten['First_Date'] . "</td>";
                                        echo "<td>" . $exten['Last_Date'] . "</td>";
                                        echo "<td>" . $exten['Extended_Reson'] . "</td>";
                                        echo "<td>" . $exten['Extended_Date'] . "</td>";
                                        echo "<td>"; ?>
                                                <form class= "form-horizontal" action= "manger_cont.php" method= 'POST'>
                                                    <input type= 'submit' value= 'نعم' name= 'bos_ext' class= 'btn btn-success'>
                                                    <input type= 'submit' value= 'لا' name= 'bos_ext' class= 'btn btn-danger'>
                                                    <input type= 'hidden' value = "<?php echo $exten['Extended_ID'];?>" name= 'extID' />
                                                </form>
                                            </td>
                                        </tr>
                                <?php } ?>
                                    </table>
                                </div>
                            </div>
                        <?php }else{
                            echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                        } ?>
                    </div> 

                    <!-- T3inat -->
                    <div>
                        <h4>طلبات التوظيف :-</h4>
                        <?php
                            $stPeople = $con->prepare("SELECT people.*, state.State_Name, area.Area_Name
                                                        FROM people
                                                        INNER JOIN
                                                            state
                                                        ON
                                                            state.State_ID = people.People_state
                                                        INNER JOIN
                                                            area
                                                        ON
                                                            area.Area_ID = people.People_area
                                                        WHERE Des_Bos = 0 AND School_Level = 'الثانوية'");
                            $stPeople->execute();
                            $peCount = $stPeople->rowCount();
                            $people = $stPeople->fetchAll();
                            if($peCount > 0){
                                foreach($people as $person){
                            ?>
                            <div class= "container text-start">
                                <form action= "manger_cont.php" method= "POST">
                                    <div class= "table-responsive">
                                        <table class= "table table-bordered text-center">
                                            <tr class="bg-dark text-light">
                                                <td>الرقم الوطني</td>      
                                                <td>مقدم الطلب</td>      
                                                <td>المؤهل الدراسي</td>      
                                                <td>الجامعة</td>      
                                                <td>سنة التخرج</td> 
                                                <td>التخصص</td>      
                                                <td>تعيين في مدرسة</td>      
                                                <td>المراجعة</td>      
                                            </tr>
                                <?php
                                    foreach($people as $person){
                                        echo"<tr>";
                                            echo '<td> <input type= "text" value= "' . $person['People_ID'] . '" ></td>';
                                            echo '<td> <input type= "text" value= "' . $person['People_Name'] . '" ></td>';
                                            echo '<td> <input type= "text" value= "' . $person['Grad_Type'] . '" ></td>';
                                            echo '<td> <input type= "text" value= "' . $person['Grad_Univ'] . '" ></td>';
                                            echo '<td> <input type= "text" value= "' . $person['Date_Grad'] . '" ></td>';
                                            echo '<td> <input type= "text" value= "' . $person['Univ_Part'] . '" ></td>';
                                            echo "<td>";
                                            echo "<div class='mb-3 text-center'>";
                                            echo "<select name= 'school'  id= 'schID'>"; 
                    
                                                    $stmt5= $con->prepare("SELECT * FROM school WHERE School_Part = 2");
                                                    $stmt5->execute();
                                                    $schools = $stmt5->fetchAll();
                                                    foreach($schools as $school){
                                                        echo "<option value='" . $school['School_ID'] . "'>"  . $school['School_Name'] . "</option>" ;
                                                    }
                                                    ?>
                                            </select>
                                        </div>
                                            </td>
                                            <td>
                                                <form class= "form-horizontal" action= "manger_cont.php" method= 'POST'>
                                                    <input type= 'submit' value= 'تعيين' name= 'bos_requ' class= 'btn btn-success'>
                                                    <input type= 'submit' value= 'رفض' name= 'bos_requ' class= 'btn btn-danger'>
                                                    <input type= 'hidden' value = "<?php echo $person['People_ID'];?>" name= 'peoID' />
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                        </table>
                                    </div>
                                </form>
                            </div>
                        <?php }
                            }else{
                                echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                            } ?>
                    </div> 

                    </div>
                </div>
            </div>

        <?php
        }elseif($_SESSION['uID'] == 1){ // Medil School ?>
            <div class= "container">
                <h2>متابعة الطلبات</h2>
                <div>
                    <!-- School Needs -->
                    <h4> أحتياجات المدارس :</h4>
                    <span class= "need_t">
                    <?php 
                    $stNeed = $con->prepare("SELECT 
                                                school_needs.*,
                                                school.*
                                            FROM 
                                                school_needs 
                                            INNER JOIN
                                                school
                                            ON
                                                school.School_ID = school_needs.school_id 
                                            WHERE
                                                Des_Bos = 0 AND School_Part = 1
                                            ");
                    $stNeed->execute();
                    $nCount = $stNeed->rowCount();
                    $needs = $stNeed->fetchAll();

                    if($nCount > 0){?>
                        <div class= "container text-start">
                            <div class= "table-responsive">
                                <table class= "table table-bordered text-center">
                                    <tr class="bg-dark text-light">
                                        <td>الرقم</td>      
                                        <td>أسم المدرسة</td> 
                                        <td>تخصص المعلمين</td>
                                        <td>عدد المعلمين</td>      
                                        <td>الاحتياجات الاخري</td>      
                                        <td>تاريخ الطلب</td>           
                                        <td>القرار الوزارة</td>      
                                    </tr>
                                <?php
                                foreach($needs as $need){
                                    echo"<tr>";
                                        echo "<td>" . $need['Need_ID'] . "</td>";
                                        echo "<td>" . $need['School_Name'] . "</td>";
                                        echo "<td>" . str_replace(" ", "<br />", $need['Need_Tea']) . "</td>";
                                        echo "<td>" . str_replace(" ", "<br />", $need['Num_Tea']) . "</td>";
                                        echo "<td>" . str_replace(" ", "<br />", $need['Other_Need']) . "</td>";
                                        echo "<td>" . $need['Need_Date'] . "</td>"; ?>
                                            <td>
                                                <form class= "form-horizontal" action= "manger_cont.php" method= 'POST'>
                                                    <input type= 'submit' value= 'أوافق' name= 'boss' class= 'btn btn-success'>
                                                    <input type= 'submit' value= 'لا أوافق' name= 'boss' class= 'btn btn-danger'>
                                                    <input type= 'hidden' value = "<?php echo $need['Need_ID'];?>" name= 'sch_need' />
                                                </form>
                                            </td>
                                        </tr>
                                <?php } ?>
                                </table>
                            </div>
                        </div>
                    <?php }else{
                            echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                        }?>
                </div>

                <div>
                    <!-- Teatshers Request -->
                    <h4>طلبات الاساتذة : </h4>

                    <!-- Preak -->
                    <div>
                        <h5>الأجازات :-</h5>
                        <?php
                        $stAll = $con->prepare("SELECT preak.*, information.*, school.*
                                                FROM 
                                                    preak
                                                INNER JOIN
                                                    information
                                                ON
                                                    information.Person_ID = preak.info_id
                                                INNER JOIN
                                                    school
                                                ON
                                                    school.School_ID = preak.school_id 
                                                WHERE 
                                                    Des_Manger = 2 AND Des_Bos = 0 AND School_Part = 1");
                        $stAll->execute();
                        $prCount = $stAll->rowCount();
                        $prAll = $stAll->fetchAll();
                        if($prCount > 0){ 
                        ?>
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
                                                    <input type= 'submit' value= 'نعم' name= 'boss' class= 'btn btn-success'>
                                                    <input type= 'submit' value= 'لا' name= 'boss' class= 'btn btn-danger'>
                                                    <input type= 'hidden' value = "<?php echo $pe['Preak_ID'];?>" name= 'prID' />
                                                </form>
                                            </td>
                                        </tr>
                                <?php } ?>
                                    </table>
                                </div>
                            </div>
                        <?php }else{
                            echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                        } ?>
                    </div>

                    <!-- Move -->
                    <div>
                        <h5>النقليات :-</h5>
                        <?php
                        $stMove = $con->prepare("SELECT move.*, information.*, area.*, school.*
                                                FROM 
                                                    move
                                                INNER JOIN
                                                    information
                                                ON
                                                    information.Person_ID = move.info_id
                                                INNER JOIN
                                                    area
                                                ON
                                                    area.Area_ID = move.area_id 
                                                INNER JOIN
                                                    school
                                                ON
                                                    school.School_ID = move.school_id 
                                                WHERE 
                                                    Des_Manger = 2 AND Des_Bos = 0 AND School_Part = 1");
                        $stMove->execute();
                        $moCount = $stMove->rowCount();
                        $moves = $stMove->fetchAll();
                        if($moCount > 0){
                        ?>
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
                                foreach($moves as $move){
                                    echo"<tr>";
                                        echo "<td>" . $move['Move_ID'] . "</td>";
                                        echo "<td><a href= 'profile.php?userID= " . $move['info_id'] . "'>"
                                        . $move['Person_Name'] . "</a></td>";
                                        echo "<td>" . $move['Old_Place'] . "</td>";
                                        echo "<td>" . $move['New_Place'] . "</td>";
                                        echo "<td>" . $move['Years_Service'] . "</td>";
                                        echo "<td>" . $move['Area_Name'] . "</td>";
                                        echo "<td>" . $move['Subject_T'] . "</td>";
                                        echo "<td>" . $move['Class_T'] . "</td>";
                                        echo "<td>" . $move['Move_Reson'] . "</td>";
                                        echo "<td>" . $move['Move_Date'] . "</td>";
                                        ?>
                                            <td>
                                                <form class= "form-horizontal" action= "manger_cont.php" method= 'POST'>
                                                    <input type= 'submit' value= 'نعم' name= 'boss_Move' class= 'btn btn-success'>
                                                    <input type= 'submit' value= 'لا' name= 'boss_Move' class= 'btn btn-danger'>
                                                    <input type= 'hidden' value = "<?php echo $move['Move_ID'];?>" name= 'moID' />
                                                </form>
                                            </td>
                                        </tr>
                                <?php } ?>
                                    </table>
                                </div>
                            </div>
                        <?php }else{
                            echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                        } ?>
                    </div>
                    
                    <!-- Tka3d -->
                    <div>
                        <h5>التقاعد :-</h5>
                        <?php
                        $stTkaod = $con->prepare("SELECT 
                                                        pension.*, information.*, school.*
                                                    FROM 
                                                        pension
                                                    INNER JOIN
                                                        information
                                                    ON
                                                        information.Person_ID = pension.info_id
                                                    INNER JOIN
                                                        school
                                                    ON
                                                        school.School_ID = pension.school_id  
                                                    WHERE 
                                                        Des_Manger = 2 AND Des_Bos = 0 AND School_Part = 1
                                                    ");
                        $stTkaod->execute();
                        $tkCount = $stTkaod->rowCount();
                        $tkaods = $stTkaod->fetchAll();
                        if($tkCount > 0) {?>
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
                                                    <input type= 'submit' value= 'نعم' name= 'boss_tkaod' class= 'btn btn-success'>
                                                    <input type= 'submit' value= 'لا' name= 'boss_tkaod' class= 'btn btn-danger'>
                                                    <input type= 'hidden' value = "<?php echo $tkaod['Pension_ID'];?>" name= 'tkID' />
                                                </form>
                                            
                                            </td>
                                        </tr>
                                <?php } ?>
                                    </table>
                                </div>
                            </div>
                        <?php }else{
                            echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                        } ?>
                    </div>

                    <!-- Tmdid -->
                    <div>
                        <h5> تمديد الخدمة :- </h5>
                        <?php
                        $stExt = $con->prepare("SELECT 
                                                        extended_servce.*, information.Person_Name, school.*
                                                    FROM 
                                                        extended_servce
                                                    INNER JOIN
                                                        information
                                                    ON
                                                        information.Person_ID = extended_servce.info_id
                                                    INNER JOIN
                                                        school
                                                    ON
                                                        school.school_ID = extended_servce.school_id 
                                                    WHERE 
                                                        Des_Bos = 0 AND School_Part = 1
                                                    ");
                        $stExt->execute();
                        $exCount = $stExt->rowCount();
                        $extens = $stExt->fetchAll();
                        if($exCount > 0){?>
                            <div class= "container text-start">
                                <div class= "table-responsive">
                                    <table class= "table table-bordered text-center">
                                        <tr class="bg-dark text-light">
                                            <td>الرقم</td>      
                                            <td>مقدم الطلب</td>      
                                            <td>تاريخ التعيين</td>      
                                            <td>تاريخ التقاعد</td>      
                                            <td>سبب أنهاء الخدمة</td>  
                                            <td>تاريخ الأضافة</td>      
                                            <td>القرار</td>      
                                        </tr>
                            <?php
                                foreach($extens as $exten){
                                    echo"<tr>";
                                        echo "<td>" . $exten['Extended_ID'] . "</td>";
                                        echo "<td><a href= 'profile.php?userID= " . $exten['info_id'] . "'>"
                                        . $exten['Person_Name'] . "</a></td>";    
                                        echo "<td>" . $exten['First_Date'] . "</td>";
                                        echo "<td>" . $exten['Last_Date'] . "</td>";
                                        echo "<td>" . $exten['Extended_Reson'] . "</td>";
                                        echo "<td>" . $exten['Extended_Date'] . "</td>";
                                        echo "<td>"; ?>
                                                <form class= "form-horizontal" action= "manger_cont.php" method= 'POST'>
                                                    <input type= 'submit' value= 'نعم' name= 'bos_ext' class= 'btn btn-success'>
                                                    <input type= 'submit' value= 'لا' name= 'bos_ext' class= 'btn btn-danger'>
                                                    <input type= 'hidden' value = "<?php echo $exten['Extended_ID'];?>" name= 'extID' />
                                                </form>
                                            </td>
                                        </tr>
                                <?php } ?>
                                    </table>
                                </div>
                            </div>
                        <?php }else{
                            echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                        } ?>
                    </div> 

                    <!-- T3inat -->
                    <div>
                        <h4>طلبات التوظيف :-</h4>
                        <?php
                            $stPeople = $con->prepare("SELECT people.*, state.State_Name, area.Area_Name
                                                        FROM people
                                                        INNER JOIN
                                                            state
                                                        ON
                                                            state.State_ID = people.People_state
                                                        INNER JOIN
                                                            area
                                                        ON
                                                            area.Area_ID = people.People_area
                                                        WHERE Des_Bos = 0 AND School_Level = 'المتوسطة'");
                            $stPeople->execute();
                            $peCount = $stPeople->rowCount();
                            $people = $stPeople->fetchAll();
                            if($peCount > 0){
                                foreach($people as $person){
                            ?>
                            <div class= "container text-start">
                                <form action= "manger_cont.php" method= "POST">
                                    <div class= "table-responsive">
                                        <table class= "table table-bordered text-center">
                                            <tr class="bg-dark text-light">
                                                <td>الرقم الوطني</td>      
                                                <td>مقدم الطلب</td>      
                                                <td>المؤهل الدراسي</td>      
                                                <td>الجامعة</td>      
                                                <td>سنة التخرج</td> 
                                                <td>التخصص</td>      
                                                <td>تعيين في مدرسة</td>      
                                                <td>المراجعة</td>      
                                            </tr>
                                <?php
                                        echo"<tr>";
                                            echo '<td> <input type= "text" value= "' . $person['People_ID'] . '" ></td>';
                                            echo '<td> <input type= "text" value= "' . $person['People_Name'] . '" ></td>';
                                            echo '<td> <input type= "text" value= "' . $person['Grad_Type'] . '" ></td>';
                                            echo '<td> <input type= "text" value= "' . $person['Grad_Univ'] . '" ></td>';
                                            echo '<td> <input type= "text" value= "' . $person['Date_Grad'] . '" ></td>';
                                            echo '<td> <input type= "text" value= "' . $person['Univ_Part'] . '" ></td>';
                                            echo "<td>";
                                            echo "<div class='mb-3 text-center'>";
                                            echo "<select name= 'school'  id= 'schID'>"; 
                    
                                                    $stmt5= $con->prepare("SELECT * FROM school WHERE School_Part = 1");
                                                    $stmt5->execute();
                                                    $schools = $stmt5->fetchAll();
                                                    foreach($schools as $school){
                                                        echo "<option value='" . $school['School_ID'] . "'>"  . $school['School_Name'] . "</option>" ;
                                                    }
                                                    ?>
                                            </select>
                                        </div>
                                            </td>
                                            <td>
                                                <form class= "form-horizontal" action= "manger_cont.php" method= 'POST'>
                                                    <input type= 'submit' value= 'تعيين' name= 'bos_requ' class= 'btn btn-success'>
                                                    <input type= 'submit' value= 'رفض' name= 'bos_requ' class= 'btn btn-danger'>
                                                    <input type= 'hidden' value = "<?php echo $person['People_ID'];?>" name= 'peoID' />
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                        </table>
                                    </div>
                                </form>
                            </div>
                        <?php }else{
                                echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                            } ?>
                    </div> 

                    </div>
                </div>
            </div>

        <?php
            
        }elseif($_SESSION['uID'] == 0){ // Primary School ?>
            <div class= "container">
                <h2>متابعة الطلبات</h2>
                <div>
                    <!-- School Needs -->
                    <h4> أحتياجات المدارس :</h4>
                    <span class= "need_t">
                    <?php 
                    $stNeed = $con->prepare("SELECT 
                                                school_needs.*,
                                                school.*
                                            FROM 
                                                school_needs 
                                            INNER JOIN
                                                school
                                            ON
                                                school.School_ID = school_needs.school_id 
                                            WHERE
                                                Des_Bos = 0 AND School_Part = 0
                                            ");
                    $stNeed->execute();
                    $nCount = $stNeed->rowCount();
                    $needs = $stNeed->fetchAll();

                    if($nCount > 0){
                    ?>
                        <div class= "container text-start">
                            <div class= "table-responsive">
                                <table class= "table table-bordered text-center">
                                    <tr class="bg-dark text-light">
                                        <td>الرقم</td>      
                                        <td>أسم المدرسة</td> 
                                        <td>تخصص المعلمين</td>
                                        <td>عدد المعلمين</td>      
                                        <td>الاحتياجات الاخري</td>      
                                        <td>تاريخ الطلب</td>           
                                        <td>القرار الوزارة</td>      
                                    </tr>
                                <?php
                                foreach($needs as $need){
                                    echo"<tr>";
                                        echo "<td>" . $need['Need_ID'] . "</td>";
                                        echo "<td>" . $need['School_Name'] . "</td>";
                                        echo "<td>" . str_replace(" ", "<br />", $need['Need_Tea']) . "</td>";
                                        echo "<td>" . str_replace(" ", "<br />", $need['Num_Tea']) . "</td>";
                                        echo "<td>" . str_replace(" ", "<br />", $need['Other_Need']) . "</td>";
                                        echo "<td>" . $need['Need_Date'] . "</td>"; ?>
                                            <td>
                                                <form class= "form-horizontal" action= "manger_cont.php" method= 'POST'>
                                                    <input type= 'submit' value= 'أوافق' name= 'boss' class= 'btn btn-success'>
                                                    <input type= 'submit' value= 'لا أوافق' name= 'boss' class= 'btn btn-danger'>
                                                    <input type= 'hidden' value = "<?php echo $need['Need_ID'];?>" name= 'sch_need' />
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
                    <!-- Teatshers Request -->
                    <h4>طلبات الاساتذة : </h4>

                    <!-- Preak -->
                    <div>
                        <h5>الأجازات :-</h5>
                        <?php
                        $stAll = $con->prepare("SELECT preak.*, information.*, school.*
                                                FROM 
                                                    preak
                                                INNER JOIN
                                                    information
                                                ON
                                                    information.Person_ID = preak.info_id
                                                INNER JOIN
                                                    school
                                                ON
                                                    school.School_ID = preak.school_id 
                                                WHERE 
                                                    Des_Manger = 2 AND Des_Bos = 0 AND School_Part = 0");
                        $stAll->execute();
                        $prCount = $stAll->rowCount();
                        $prAll = $stAll->fetchAll();
                        if($prCount > 0){ 
                        ?>
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
                                                    <input type= 'submit' value= 'نعم' name= 'boss' class= 'btn btn-success'>
                                                    <input type= 'submit' value= 'لا' name= 'boss' class= 'btn btn-danger'>
                                                    <input type= 'hidden' value = "<?php echo $pe['Preak_ID'];?>" name= 'prID' />
                                                </form>
                                            </td>
                                        </tr>
                                <?php } ?>
                                    </table>
                                </div>
                            </div>
                        <?php }else{
                            echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                        } ?>
                    </div>

                    <!-- Move -->
                    <div>
                        <h5>النقليات :-</h5>
                        <?php
                        $stMove = $con->prepare("SELECT move.*, information.*, area.*, school.*
                                                FROM 
                                                    move
                                                INNER JOIN
                                                    information
                                                ON
                                                    information.Person_ID = move.info_id
                                                INNER JOIN
                                                    area
                                                ON
                                                    area.Area_ID = move.area_id 
                                                INNER JOIN
                                                    school
                                                ON
                                                    school.School_ID = move.school_id 
                                                WHERE 
                                                    Des_Manger = 2 AND Des_Bos = 0 AND School_Part = 0");
                        $stMove->execute();
                        $moCount = $stMove->rowCount();
                        $moves = $stMove->fetchAll();
                        if($moCount > 0){
                        ?>
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
                                foreach($moves as $move){
                                    echo"<tr>";
                                        echo "<td>" . $move['Move_ID'] . "</td>";
                                        echo "<td><a href= 'profile.php?userID= " . $move['info_id'] . "'>"
                                        . $move['Person_Name'] . "</a></td>";
                                        echo "<td>" . $move['Old_Place'] . "</td>";
                                        echo "<td>" . $move['New_Place'] . "</td>";
                                        echo "<td>" . $move['Years_Service'] . "</td>";
                                        echo "<td>" . $move['Area_Name'] . "</td>";
                                        echo "<td>" . $move['Subject_T'] . "</td>";
                                        echo "<td>" . $move['Class_T'] . "</td>";
                                        echo "<td>" . $move['Move_Reson'] . "</td>";
                                        echo "<td>" . $move['Move_Date'] . "</td>";
                                        ?>
                                            <td>
                                                <form class= "form-horizontal" action= "manger_cont.php" method= 'POST'>
                                                    <input type= 'submit' value= 'نعم' name= 'boss_Move' class= 'btn btn-success'>
                                                    <input type= 'submit' value= 'لا' name= 'boss_Move' class= 'btn btn-danger'>
                                                    <input type= 'hidden' value = "<?php echo $move['Move_ID'];?>" name= 'moID' />
                                                </form>
                                            </td>
                                        </tr>
                                <?php } ?>
                                    </table>
                                </div>
                            </div>
                        <?php }else{
                            echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                        } ?>
                    </div>
                    
                    <!-- Tka3d -->
                    <div>
                        <h5>التقاعد :-</h5>
                        <?php
                        $stTkaod = $con->prepare("SELECT 
                                                        pension.*, information.*, school.*
                                                    FROM 
                                                        pension
                                                    INNER JOIN
                                                        information
                                                    ON
                                                        information.Person_ID = pension.info_id
                                                    INNER JOIN
                                                        school
                                                    ON
                                                        school.School_ID = pension.school_id  
                                                    WHERE 
                                                        Des_Manger = 2 AND Des_Bos = 0 AND School_Part = 0
                                                    ");
                        $stTkaod->execute();
                        $tkCount = $stTkaod->rowCount();
                        $tkaods = $stTkaod->fetchAll();
                        if($tkCount > 0) {?>
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
                                        . $tkaod['Person_Name'] . "</a></td>";                                                echo "<td>" . $tkaod['Date_Start'] . "</td>";
                                        echo "<td>" . $tkaod['Num_Service'] . "</td>";
                                        echo "<td>" . $tkaod['Pension_Reson'] . "</td>";
                                        echo "<td>" . $tkaod['Pension_Date'] . "</td>";
                                        echo "<td>"; ?>
                                        
                                                <form class= "form-horizontal" action= "manger_cont.php" method= 'POST'>
                                                    <input type= 'submit' value= 'نعم' name= 'boss_tkaod' class= 'btn btn-success'>
                                                    <input type= 'submit' value= 'لا' name= 'boss_tkaod' class= 'btn btn-danger'>
                                                    <input type= 'hidden' value = "<?php echo $tkaod['Pension_ID'];?>" name= 'tkID' />
                                                </form>
                                            
                                            </td>
                                        </tr>
                                <?php } ?>
                                    </table>
                                </div>
                            </div>
                        <?php }else{
                            echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                        } ?>
                    </div>

                    <!-- Tmdid -->
                    <div>
                        <h5> تمديد الخدمة :- </h5>
                        <?php
                        $stExt = $con->prepare("SELECT 
                                                        extended_servce.*, information.Person_Name, school.*
                                                    FROM 
                                                        extended_servce
                                                    INNER JOIN
                                                        information
                                                    ON
                                                        information.Person_ID = extended_servce.info_id
                                                    INNER JOIN
                                                        school
                                                    ON
                                                        school.school_ID = extended_servce.school_id 
                                                    WHERE 
                                                        Des_Bos = 0 AND School_Part = 0
                                                    ");
                        $stExt->execute();
                        $exCount = $stExt->rowCount();
                        $extens = $stExt->fetchAll();
                        if($exCount > 0){?>
                            <div class= "container text-start">
                                <div class= "table-responsive">
                                    <table class= "table table-bordered text-center">
                                        <tr class="bg-dark text-light">
                                            <td>الرقم</td>      
                                            <td>مقدم الطلب</td>      
                                            <td>تاريخ التعيين</td>      
                                            <td>تاريخ التقاعد</td>      
                                            <td>سبب أنهاء الخدمة</td>  
                                            <td>تاريخ الأضافة</td>      
                                            <td>القرار</td>      
                                        </tr>
                            <?php
                                foreach($extens as $exten){
                                    echo"<tr>";
                                        echo "<td>" . $exten['Extended_ID'] . "</td>";
                                        echo "<td><a href= 'profile.php?userID= " . $exten['info_id'] . "'>"
                                        . $exten['Person_Name'] . "</a></td>";    
                                        echo "<td>" . $exten['First_Date'] . "</td>";
                                        echo "<td>" . $exten['Last_Date'] . "</td>";
                                        echo "<td>" . $exten['Extended_Reson'] . "</td>";
                                        echo "<td>" . $exten['Extended_Date'] . "</td>";
                                        echo "<td>"; ?>
                                                <form class= "form-horizontal" action= "manger_cont.php" method= 'POST'>
                                                    <input type= 'submit' value= 'نعم' name= 'bos_ext' class= 'btn btn-success'>
                                                    <input type= 'submit' value= 'لا' name= 'bos_ext' class= 'btn btn-danger'>
                                                    <input type= 'hidden' value = "<?php echo $exten['Extended_ID'];?>" name= 'extID' />
                                                </form>
                                            </td>
                                        </tr>
                                <?php } ?>
                                    </table>
                                </div>
                            </div>
                        <?php }else{
                            echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                        } ?>
                    </div> 

                    <!-- T3inat -->
                    <div>
                        <h4>طلبات التوظيف :-</h4>
                        <?php
                            $stPeople = $con->prepare("SELECT people.*, state.State_Name, area.Area_Name
                                                        FROM people
                                                        INNER JOIN
                                                            state
                                                        ON
                                                            state.State_ID = people.People_state
                                                        INNER JOIN
                                                            area
                                                        ON
                                                            area.Area_ID = people.People_area
                                                        WHERE Des_Bos = 0 AND School_Level = 'الابتدائية'");
                            $stPeople->execute();
                            $peCount = $stPeople->rowCount();
                            $people = $stPeople->fetchAll();
                            if($peCount > 0){
                                foreach($people as $person){
                            ?>
                            <div class= "container text-start">
                                <form action= "manger_cont.php" method= "POST">
                                    <div class= "table-responsive">
                                        <table class= "table table-bordered text-center">
                                            <tr class="bg-dark text-light">
                                                <td>الرقم الوطني</td>      
                                                <td>مقدم الطلب</td>      
                                                <td>المؤهل الدراسي</td>      
                                                <td>الجامعة</td>      
                                                <td>سنة التخرج</td> 
                                                <td>التخصص</td>      
                                                <td>تعيين في مدرسة</td>      
                                                <td>المراجعة</td>      
                                            </tr>
                                <?php
                                    foreach($people as $person){
                                        echo"<tr>";
                                            echo '<td> <input type= "text" value= "' . $person['People_ID'] . '" ></td>';
                                            echo '<td> <input type= "text" value= "' . $person['People_Name'] . '" ></td>';
                                            echo '<td> <input type= "text" value= "' . $person['Grad_Type'] . '" ></td>';
                                            echo '<td> <input type= "text" value= "' . $person['Grad_Univ'] . '" ></td>';
                                            echo '<td> <input type= "text" value= "' . $person['Date_Grad'] . '" ></td>';
                                            echo '<td> <input type= "text" value= "' . $person['Univ_Part'] . '" ></td>';
                                            echo "<td>";
                                            echo "<div class='mb-3 text-center'>";
                                            echo "<select name= 'school'  id= 'schID'>"; 
                    
                                                    $stmt5= $con->prepare("SELECT * FROM school WHERE School_Part = 0");
                                                    $stmt5->execute();
                                                    $schools = $stmt5->fetchAll();
                                                    foreach($schools as $school){
                                                        echo "<option value='" . $school['School_ID'] . "'>"  . $school['School_Name'] . "</option>" ;
                                                    }
                                                    ?>
                                            </select>
                                        </div>
                                            </td>
                                            <td>
                                                <form class= "form-horizontal" action= "manger_cont.php" method= 'POST'>
                                                    <input type= 'submit' value= 'تعيين' name= 'bos_requ' class= 'btn btn-success'>
                                                    <input type= 'submit' value= 'رفض' name= 'bos_requ' class= 'btn btn-danger'>
                                                    <input type= 'hidden' value = "<?php echo $person['People_ID'];?>" name= 'peoID' />
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                        </table>
                                    </div>
                                </form>
                            </div>
                        <?php }
                            }else{
                                echo '<div class= "alert alert-success">لا توجد طلبات</div>';
                            } ?>
                    </div> 

                </div>
            </div>

        <?php 
        }else{
            header('location: logout.php');
            exit();
        }
}
    include $temp . 'footer.php';
    ob_end_flush();
?>