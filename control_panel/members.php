<?php
    ob_start();

    session_start();
    $pageTitle = "Members";

    if (isset($_SESSION['UserName'])){
        include 'init.php'; ?>

    <nav class="navbar navbar-expand-md header_title">
        <div class="container">
            <a class="navbar-brand" href= "homePage.php"><img src="layout/images/logo.png" alt="no Service"></a>     
            <button
             class="navbar-toggler" 
             type="button" 
             data-bs-toggle="collapse" 
             data-bs-target="#mainmune">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainmune">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a href="logout.php" class="nav-link">تسجيل الخروج </a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class= "container">

    <?php

        $do = isset($_GET['do']) ? $_GET['do'] : 'all';

        if($do == 'all'){ // all Member area 
        
            $stmt = $con->prepare("SELECT 
                                        information.*, state.State_Name, area.Area_Name, school.School_Name
                                    FROM information
                                    INNER JOIN 
                                        state
                                    ON
                                        state.State_ID = information.Person_State 
                                    INNER JOIN 
                                        area
                                    ON
                                        area.Area_ID = information.Person_City
                                    INNER JOIN 
                                        school
                                    ON
                                        school.School_ID = information.Person_School   
                                    WHERE Group_ID != 1");
            $stmt->execute();

            $rows = $stmt->fetchAll();
        ?>

            <h1 class= "text-center py-3">التحكم </h1>';
            <div class= "container text-start">
                <div class= "table-responsive">
                    <table class= "table table-bordered text-center">
                        <tr class="bg-dark text-light">
                            <td>الرقم</td>      
                            <td>الأسم</td>      
                            <td>الأيميل</td>      
                            <td>الهاتف</td>      
                            <td>الولاية</td>      
                            <td>المحلية</td>      
                            <td>المدرسة</td> 
                            <td>الوظيفة</td>     
                            <td>التحكم</td> 
                        </tr>

                <?php 
                    foreach($rows as $row){

                        echo"<tr>";
                            echo "<td>" . $row['Person_ID'] . "</td>";
                            echo "<td>" . $row['Person_Name'] . "</td>";
                            echo "<td>" . $row['Person_Email'] . "</td>";
                            echo "<td>" . $row['Person_Phone'] . "</td>";
                            echo "<td>" . $row['State_Name'] . "</td>";
                            echo "<td>" . $row['Area_Name'] . "</td>";
                            echo "<td>" . $row['School_Name'] . "</td>";
                            echo "<td>" . $row['Person_Job'] . "</td>";
                            echo "<td>
                                    <a href= 'members.php?do=Edit&userID=" . $row['Person_ID'] . " ' class= 'btn btn-success'>
                                    <i class= 'fa fa-edit fa-sm ms-1'></i>تعديل</a>
                                    <a href= 'members.php?do=Delete&userID=" . $row['Person_ID'] . " ' class= 'btn btn-danger confirm'>
                                    <i class= 'fa fa-close fa-sm ms-1'></i>حزف</a>";
                            if($row['Reg_Status'] == 0){
                                echo "<a href= 'members.php?do=Activate&userID=" . $row['Person_ID'] . " ' class= 'btn btn-info'>
                                <i class= 'fa fa-close fa-sm ms-1'></i>تفعيل</a>";
                            }
                            echo "</td>";
                        echo "</tr>";
                        
                            
                    }; ?>
                    
                        
                    </table>
                </div>

                <a href="members.php?do=Add" class= "btn btn-primary"><i class= "fa fa-plus ms-2"></i> مستخدم جديد</a>
            </div>
    <?php
        }if($do == 'boss'){ // Boss area 
        
            $stmt = $con->prepare("SELECT 
                                        information.*, state.State_Name, area.Area_Name, school.School_Name
                                    FROM information
                                    INNER JOIN 
                                        state
                                    ON
                                        state.State_ID = information.Person_State 
                                    INNER JOIN 
                                        area
                                    ON
                                        area.Area_ID = information.Person_City
                                    INNER JOIN 
                                        school
                                    ON
                                        school.School_ID = information.Person_School   
                                    WHERE Group_ID != 1 AND Person_Job = 'شؤون الموظفين'");
            $stmt->execute();

            $rows = $stmt->fetchAll();
        ?>

            <h1 class= "text-center py-3">التحكم </h1>';
            <div class= "container text-start">
                <div class= "table-responsive">
                    <table class= "table table-bordered text-center">
                        <tr class="bg-dark text-light">
                            <td>الرقم</td>      
                            <td>الأسم</td>      
                            <td>الأيميل</td>      
                            <td>الهاتف</td>      
                            <td>الولاية</td>      
                            <td>المحلية</td>      
                            <td>الوظيفة</td>     
                            <td>التحكم</td> 
                        </tr>

                <?php 
                    foreach($rows as $row){

                        echo"<tr>";
                            echo "<td>" . $row['Person_ID'] . "</td>";
                            echo "<td>" . $row['Person_Name'] . "</td>";
                            echo "<td>" . $row['Person_Email'] . "</td>";
                            echo "<td>" . $row['Person_Phone'] . "</td>";
                            echo "<td>" . $row['State_Name'] . "</td>";
                            echo "<td>" . $row['Area_Name'] . "</td>";
                            echo "<td>" . $row['Person_Job'] . "</td>";
                            echo "<td>
                                    <a href= 'members.php?do=Edit&userID=" . $row['Person_ID'] . " ' class= 'btn btn-success'>
                                    <i class= 'fa fa-edit fa-sm ms-1'></i>تعديل</a>
                                    <a href= 'members.php?do=Delete&userID=" . $row['Person_ID'] . " ' class= 'btn btn-danger confirm'>
                                    <i class= 'fa fa-close fa-sm ms-1'></i>حزف</a>";
                            if($row['Reg_Status'] == 0){
                                echo "<a href= 'members.php?do=Activate&userID=" . $row['Person_ID'] . " ' class= 'btn btn-info'>
                                <i class= 'fa fa-close fa-sm ms-1'></i>تفعيل</a>";
                            }
                            echo "</td>";
                        echo "</tr>";
                        
                            
                    }; ?>
                    
                        
                    </table>
                </div>

                <a href="members.php?do=Add" class= "btn btn-primary"><i class= "fa fa-plus ms-2"></i> مستخدم جديد</a>
            </div>
    <?php
        }elseif($do == 'Manger'){ // Manage area 
        
            $stmt = $con->prepare("SELECT 
                                        information.*, state.State_Name, area.Area_Name, school.School_Name
                                    FROM information
                                    INNER JOIN 
                                        state
                                    ON
                                        state.State_ID = information.Person_State 
                                    INNER JOIN 
                                        area
                                    ON
                                        area.Area_ID = information.Person_City
                                    INNER JOIN 
                                        school
                                    ON
                                        schoool.School_ID = information.Person_School   
                                    WHERE Group_ID != 1 AND Person_Job = 'مدير'");
            $stmt->execute();

            $rows = $stmt->fetchAll();
        ?>

            <h1 class= "text-center py-3">التحكم </h1>';
            <div class= "container text-start">
                <div class= "table-responsive">
                    <table class= "table table-bordered text-center">
                        <tr class="bg-dark text-light">
                            <td>الرقم</td>      
                            <td>الأسم</td>      
                            <td>الأيميل</td>      
                            <td>الهاتف</td>      
                            <td>الولاية</td>      
                            <td>المحلية</td>      
                            <td>المدرسة</td>      
                            <td>التحكم</td> 
                        </tr>

                <?php 
                    foreach($rows as $row){

                        echo"<tr>";
                            echo "<td>" . $row['Person_ID'] . "</td>";
                            echo "<td>" . $row['Person_Name'] . "</td>";
                            echo "<td>" . $row['Person_Email'] . "</td>";
                            echo "<td>" . $row['Person_Phone'] . "</td>";
                            echo "<td>" . $row['State_Name'] . "</td>";
                            echo "<td>" . $row['Area_Name'] . "</td>";
                            echo "<td>" . $row['School_Name'] . "</td>";
                            echo "<td>
                                    <a href= 'members.php?do=Edit&userID=" . $row['Person_ID'] . " ' class= 'btn btn-success'>
                                    <i class= 'fa fa-edit fa-sm ms-1'></i>تعديل</a>
                                    <a href= 'members.php?do=Delete&userID=" . $row['Person_ID'] . " ' class= 'btn btn-danger confirm'>
                                    <i class= 'fa fa-close fa-sm ms-1'></i>حزف</a>";
                            if($row['Reg_Status'] == 0){
                                echo "<a href= 'members.php?do=Activate&userID=" . $row['Person_ID'] . " ' class= 'btn btn-info'>
                                <i class= 'fa fa-close fa-sm ms-1'></i>تفعيل</a>";
                            }
                            echo "</td>";
                        echo "</tr>";
                        
                            
                    }; ?>
                    
                        
                    </table>
                </div>

                <a href="members.php?do=Add" class= "btn btn-primary"><i class= "fa fa-plus ms-2"></i> مستخدم جديد</a>';
            </div>
    <?php
        }elseif($do == 'teatcher'){ // Teatchers area 
        
            $stTea = $con->prepare("SELECT 
                                        information.*, state.State_Name, area.Area_Name, school.School_Name
                                    FROM information
                                    INNER JOIN 
                                        state
                                    ON
                                        state.State_ID = information.Person_State 
                                    INNER JOIN 
                                        area
                                    ON
                                        area.Area_ID = information.Person_City
                                    INNER JOIN 
                                        school
                                    ON
                                        school.School_ID = information.Person_School   
                                    WHERE Group_ID != 1 AND Person_Job = 'أستاذ'");
            $stTea->execute();

            $rows = $stTea->fetchAll();
        ?>

            <h1 class= "text-center py-3">التحكم </h1>';
            <div class= "container text-start">
                <div class= "table-responsive">
                    <table class= "table table-bordered text-center">
                        <tr class="bg-dark text-light">
                            <td>الرقم</td>      
                            <td>الأسم</td>      
                            <td>الأيميل</td>      
                            <td>الهاتف</td>      
                            <td>الولاية</td>      
                            <td>المحلية</td>      
                            <td>المدرسة</td>      
                            <td>التحكم</td> 
                        </tr>

                <?php 
                    foreach($rows as $row){

                        echo"<tr>";
                            echo "<td>" . $row['Person_ID'] . "</td>";
                            echo "<td>" . $row['Person_Name'] . "</td>";
                            echo "<td>" . $row['Person_Email'] . "</td>";
                            echo "<td>" . $row['Person_Phone'] . "</td>";
                            echo "<td>" . $row['State_Name'] . "</td>";
                            echo "<td>" . $row['Area_Name'] . "</td>";
                            echo "<td>" . $row['School_Name'] . "</td>";
                            echo "<td>
                                    <a href= 'members.php?do=Edit&userID=" . $row['Person_ID'] . " ' class= 'btn btn-success'>
                                    <i class= 'fa fa-edit fa-sm ms-1'></i>تعديل</a>
                                    <a href= 'members.php?do=Delete&userID=" . $row['Person_ID'] . " ' class= 'btn btn-danger confirm'>
                                    <i class= 'fa fa-close fa-sm ms-1'></i>حزف</a>";
                            if($row['Reg_Status'] == 0){
                                echo "<a href= 'members.php?do=Activate&userID=" . $row['Person_ID'] . " ' class= 'btn btn-info'>
                                <i class= 'fa fa-close fa-sm ms-1'></i>تفعيل</a>";
                            }
                            echo "</td>";
                        echo "</tr>";
                        
                            
                    }; ?>
                    
                        
                    </table>
                </div>

                <a href="members.php?do=Add" class= "btn btn-primary"><i class= "fa fa-plus ms-2"></i> مستخدم جديد</a>';
            </div>
    <?php
        }elseif($do == 'pending'){ // pending area 
        
            $stPen = $con->prepare("SELECT 
                                        information.*, state.State_Name, area.Area_Name, school.School_Name
                                    FROM information
                                    INNER JOIN 
                                        state
                                    ON
                                        state.State_ID = information.Person_State 
                                    INNER JOIN 
                                        area
                                    ON
                                        area.Area_ID = information.Person_City
                                    INNER JOIN 
                                        school
                                    ON
                                        school.School_ID = information.Person_School   
                                    WHERE Group_ID != 1 AND Reg_Status = 0");
            $stPen->execute();

            $rows = $stPen->fetchAll();
        ?>

            <h1 class= "text-center py-3">التحكم </h1>';
            <div class= "container text-start">
                <div class= "table-responsive">
                    <table class= "table table-bordered text-center">
                        <tr class="bg-dark text-light">
                            <td>الرقم</td>      
                            <td>الأسم</td>      
                            <td>الأيميل</td>      
                            <td>الهاتف</td>      
                            <td>الولاية</td>      
                            <td>المحلية</td>      
                            <td>المدرسة</td>      
                            <td>التحكم</td> 
                        </tr>

                <?php 
                    foreach($rows as $row){

                        echo"<tr>";
                            echo "<td>" . $row['Person_ID'] . "</td>";
                            echo "<td>" . $row['Person_Name'] . "</td>";
                            echo "<td>" . $row['Person_Email'] . "</td>";
                            echo "<td>" . $row['Person_Phone'] . "</td>";
                            echo "<td>" . $row['State_Name'] . "</td>";
                            echo "<td>" . $row['Area_Name'] . "</td>";
                            echo "<td>" . $row['School_Name'] . "</td>";
                            echo "<td>
                                    <a href= 'members.php?do=Edit&userID=" . $row['Person_ID'] . " ' class= 'btn btn-success'>
                                    <i class= 'fa fa-edit fa-sm ms-1'></i>تعديل</a>
                                    <a href= 'members.php?do=Delete&userID=" . $row['Person_ID'] . " ' class= 'btn btn-danger confirm'>
                                    <i class= 'fa fa-close fa-sm ms-1'></i>حزف</a>";
                            if($row['Reg_Status'] == 0){
                                echo "<a href= 'members.php?do=Activate&userID=" . $row['Person_ID'] . " ' class= 'btn btn-info'>
                                <i class= 'fa fa-close fa-sm ms-1'></i>تفعيل</a>";
                            }
                            echo "</td>";
                        echo "</tr>";
                        
                            
                    }; ?>
                    
                        
                    </table>
                </div>

                <a href="members.php?do=Add" class= "btn btn-primary"><i class= "fa fa-plus ms-2"></i> مستخدم جديد</a>';
            </div>
    <?php
        }elseif ($do == 'Add') { // Add area?>

            <h1 class= "text-center py-3"> أضافة مستخدم</h1>
            <div class="container add_members">
                <div class= "row">
                    <div class= "col-lg-offsit-3"> 
                        <form action= "members.php?do=Insert" method = "POST">
                            <div class= "input_cont">
                                <input class= "form-control" type= "text" name= "user" placeholder= "الرقم الوطني"
                                    required= "require" />
                                <span class= "asterisk">*</span>
                            </div>
                            <div class= "input_cont">
                                <input pattern= ".{10,80}" type= "text" name= "fullName" class= "form-control" autocomplete= "off" 
                                    required= "require" placeholder= "الاسم الشخصي" />                                
                                <span class= "asterisk">*</span>
                            </div>                        
                            <div class= "input_cont">
                                <input minlength= "4" type= "password" name= "new_password" class= "form-control" 
                                    autocomplete= "new-password" placeholder= "كلمة السر" />
                                <i class= "show-pass fa fa-eye"></i>
                                <span class= "asterisk">*</span>
                            </div> 
                            <div class= "input_cont">
                                <input type= "text" name= "phone" class= "form-control" 
                                required= "required" placeholder= "رقم الهاتف" />
                                <span class= "asterisk">*</span>
                            </div>

                            <div class="form-group mb-3">
                                <lable>الجنس</lable>
                                <div class= "pt-3">
                                    <input id="mail" type="radio" name= "type" value= "1" />
                                    <lable for="mail">ذكر</lable>
                                    <input id="femail" type="radio" name= "type" value= "0" />
                                    <lable for="femail">أنثي</lable>
                                </div>
                            </div>
                            <div class= "input_cont">
                                <lable>تاريخ الميلاد</lable><input type="date" name= "b-date" class= "form-control" />
                            </div>
                            <div class= "input_cont">
                                <input type="serch" name= "place_date" class= "form-control" placeholder= "مكان الميلاد" />
                            </div>
                            <div class= "input_cont">
                                <input type="email" name= "mail" class= "form-control" placeholder= "البريد الألكتروني" />
                            </div>
                            <div class="form-group mb-3">
                                <lable>الوظيفة</lable>
                                <div class= "pt-3">
                                    <input id="manger" type="radio" name= "job" value= "مدير" />
                                    <lable for="manger">مدير</lable>
                                    <input id="teatcher" type="radio" name= "job" value= "أستاذ" />
                                    <lable for="teatcher">أستاذ</lable>
                                </div>
                            </div>
                            <label class= "my-3">مكان العمل</label>
                            <div class= "work_place">
                                <div class="mb-3 text-center">
                                    <lable>الولاية</lable>
                                    <select name= "state" class= "form-control" required = "require">
                                        <?php
                                            $stmt3= $con->prepare("SELECT * FROM `State`");
                                            $stmt3->execute();
                                            $stats = $stmt3->fetchAll();
                                            foreach($stats as $state){
                                                echo "<option value='" . $state['State_ID'] . "'>"  . $state['State_Name'] . "</option>" ;

                                            }
                                            ?>
                                    </select>
                                </div>
                                <div class="mb-3 text-center">
                                    <lable>المنطقة التعليمية</lable>
                                    <select name= "city" class= "form-control" required = "require">
                                        <?php
                                            $stmt4= $con->prepare("SELECT * FROM area");
                                            $stmt4->execute();
                                            $citys = $stmt4->fetchAll();
                                            foreach($citys as $city){
                                                echo "<option value='" . $city['Area_ID'] . "'>"  . $city['Area_Name'] . "</option>" ;
                                            }
                                            ?>
                                    </select>
                                </div>
                                <div class="mb-3 text-center">
                                    <lable>المدرسة</lable>
                                    <select name= "school" class= "form-control" required = "require"> 
                                        <?php
                                            $stmt5= $con->prepare("SELECT * FROM school");
                                            $stmt5->execute();
                                            $schools = $stmt5->fetchAll();
                                            foreach($schools as $school){
                                                echo "<option value='" . $school['School_ID'] . "'>"  . $school['School_Name'] . "</option>" ;
                                            }
                                            ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <lable>الحالة الأجتماعية</lable>
                                <div class= "pt-3">
                                    <input id="single" type="radio" name= "status" />
                                    <lable for="single">أعذب / عذباء</lable>
                                    <input id="mared" type="radio" name= "status" />
                                    <lable for="mared">متزوج/ة</lable>
                                    <input id="deforst" type="radio" name= "status" />
                                    <lable for="deforst">مطلق/ة</lable>
                                    <input id="death" type="radio" name= "status" />
                                    <lable for="death">أرمل/ة</lable>
                                </div>
                            </div>

                            <div class= "input_cont">
                                <input type="number" name= "kids" class= "form-control" placeholder= "عدد الابناء" />
                            </div>

                            <div class="form-group mb-3">
                                <lable>معرفة بالكمبيوتر</lable>
                                <div class= "pt-3">
                                    <input id="yes" type="radio" name= "computer" value= "1" />
                                    <lable for="yes">نعم</lable>
                                    <input id="no" type="radio" name= "computer" value= "0" />
                                    <lable for="no">لا</lable>
                                </div>
                            </div>

                            <textarea name= "program" class= "form-control" placeholder= "المهارات الاضافية"></textarea>
                            <input class= "btn btn-primary" type= "submit" value= "أضافة" /> 
                        </form>
                    </div>
                </div>
            </div>
    <?php
        } elseif ($do == 'Insert'){ // Insert area
            $actived = (isset($_GET['page']) && $_GET['page'] == 'pending') ? " AND Reg_Status = 0" : "";
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                echo '<h1 class= "text-center py-3">أدخال البيانات</h1>';
                echo '<div class= "container text-start">';
                $id         = $_POST['user'];
                $name       = $_POST['fullName'];
                $gander     = $_POST['type'];
                $bDate      = $_POST['b-date'];
                $pDate      = $_POST['place_date'];
                $email      = $_POST['mail'];
                $job        = $_POST['job'];
                $state      = $_POST['state'];
                $city       = $_POST['city'];
                $school     = $_POST['school'];
                $phone      = $_POST['phone'];
                $status     = $_POST['status'];
                $kids       = $_POST['kids'];
                $computer   = $_POST['computer'];
                $program    = $_POST['program'];
                $pass       = $_POST['new_password'];
                $hashPass= sha1($pass);


                // Validate The Form
                $formError = array();

                if(strlen($id) > 20 OR strlen($id) < 11 ){
                    $formError[]= ' الرقم الوطني يجب ان لا يقل عن  <strong> 4 ارقام </strong> ولا يزيد عن  <strong> 20 رقم </strong>';
                }
                if(strlen($name) > 80 OR strlen($name) < 20 ){
                    $formError[]= ' الاسم يجب ان لا يقل عن <strong> 20 حرف </strong> ولا يزيد عن  <strong> 80 حرف </strong>';
                }
                if(strlen($pass) > 20 OR strlen($pass) < 8 ){
                    $formError[]= ' كلمة السر يجب ان لا يقل عن  <strong> 8 احرف </strong> ولا تزيد عن <strong> 20 حرف </strong>';
                }
                if(empty($email)){
                    $formError[]= '  البريد الالكتروني لايمكن ان يكون  <strong> خالي </strong>';
                }
                if(empty($phone)){
                    $formError[]= '  رقم الهاتف لايمكن ان يكون  <strong> خالي </strong>';
                }
                

                foreach($formError as $error){
                    echo '<div class= "alert alert-danger">' . $error . '</div>';
                }

                if(empty($formError)){

                    $check = checkItem("Person_ID", "information", $id);

                    if($check == 0){
                        $stmt2 = $con->prepare("INSERT INTO 
                                                    information(Person_ID, Person_Password, Person_Name, Person_Date, Person_P_D, Gander, Person_Email, Person_Job, Person_State, Person_City, Person_School, Person_Phone, Reg_Status)
                                                VALUES(:zid, :zpass, :zname, :zbDate, :zpDate, :zgander, :zmail, :zjob, :zstate, :zcity, :zschool, :zphone, 1)");
                        $stmt2->execute(array(
                            'zid'       => $id,
                            'zpass'     => $hashPass,
                            'zname'     => $name,
                            'zbDate'    => $bDate,
                            'zpDate'    => $pDate,
                            'zpDate'    => $pDate,
                            'zgander'   => $gander,
                            'zmail'     => $email,
                            'zjob'      => $job,
                            'zstate'    => $state,
                            'zcity'     =>$city,
                            'zschool'   => $school,
                            'zphone'    => $phone,
                        ));

                        $theMsg= '<div class= "alert alert-success"> تم الأضافة بنجاح</div>';
                        redirectHome($theMsg, 4, "members.php");
                        
                    } else {
                        $theMsg= '<div class= "alert alert-danger"> هذاالمستخدم موجود </div>';
                        redirectHome($theMsg, 4, "back");
                    }

                }

            } else {
                $theMsg= '<div class= "alert alert-danger"> لايمكن الدخول الي هذه الصفحة مباشرة </div>';
                redirectHome($theMsg, 4);
            }
            echo '</div>';

        
        }elseif ($do == 'Edit') { // Edit area

            $userId = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0;            
            $stmt = $con-> prepare("SELECT * FROM information WHERE Person_ID = ? LIMIT 1");
            $stmt-> execute(array($userId));
            $row = $stmt->fetch();
            $count = $stmt-> rowCount();
            if($count > 0){?>

            <h1 class= "text-center py-3">تعديل البيانات</h1>
            <div class="container add_members">
                <div class= "row">
                    <div class= "col-lg-offsit-3"> 
                        <form action= "members.php?do=Update" method = "POST">
                            <input type= "hidden" name= "user" value= "<?php echo $userId ?>" />
                            <div class= "input_cont">
                                <input pattern= ".{10,80}" type= "text" name= "fullName" class= "form-control" autocomplete= "off" 
                                required= "require" placeholder= "الاسم الشخصي" value= "<?php echo $row['Person_Name'] ?>" />                                
                            <span class= "asterisk">*</span>
                            </div>                        
                            <div class= "input_cont">
                                <input minlength= "4" type= "password" name= "new_password" class= "form-control" 
                                    autocomplete= "new-password" placeholder= "كلمة السر" />
                                <i class= "show-pass fa fa-eye"></i>
                                <span class= "asterisk">*</span>
                                <input type= "hidden" name= "old_password" value= "<?php echo $row['Person_Password'] ?>"/>                        
                            </div> 
                            <div class= "input_cont">
                                <input type= "text" name= "phone" class= "form-control" 
                                required= "required" placeholder= "رقم الهاتف" value= "<?php echo $row['Person_Phone'] ?>" />
                                <span class= "asterisk">*</span>
                            </div>

                            <div class="form-group mb-3">
                                <lable>الجنس</lable>
                                <div class= "pt-3">
                                    <input id="mail" type="radio" name= "type" value= "1" <?php if($row['Gander'] == 1){echo 'checked';} ?> />
                                    <lable for="mail">ذكر</lable>
                                    <input id="femail" type="radio" name= "type" value= "0" <?php if($row['Gander'] == 0){echo 'checked';} ?> />
                                    <lable for="femail">أنثي</lable>
                                </div>
                            </div>
                            <div class= "input_cont">
                                <lable>تاريخ الميلاد</lable><input type="date" name= "b-date" class= "form-control"
                                value= "<?php echo $row['Person_Date'] ?>" />                            
                            </div>
                            <div class= "input_cont">
                                <input type="serch" name= "place_date" class= "form-control" placeholder= "مكان الميلاد"
                                value= "<?php echo $row['Person_P_D'] ?>" />                            
                            </div>
                            <div class= "input_cont">
                                <input type="email" name= "email" class= "form-control" placeholder= "البريد الألكتروني"
                                value= "<?php echo $row['Person_Email'] ?>" />                            
                            </div>
                            <div class="form-group mb-3">
                                <lable>الوظيفة</lable>
                                <div class= "pt-3">
                                    <input id="manger" type="radio" name= "job" value= "مدير" <?php if($row['Person_Job'] == 'مدير'){echo 'checked';} ?> />
                                    <lable for="manger">مدير</lable>
                                    <input id="teatcher" type="radio" name= "job" value= "أستاذ" <?php if($row['Person_Job'] == 'أستاذ'){echo 'checked';} ?> />
                                    <lable for="teatcher">أستاذ</lable>
                                </div>
                            </div>
                            <label class= "my-3">مكان العمل</label>
                            <div class= "work_place">
                                <div class="mb-3 text-center">
                                    <lable for="stID" class = "d-inline-block">الولاية</lable>
                                    <select name= "state" class= "form-control" id= "stID">
                                        <?php
                                            $stmt3= $con->prepare("SELECT * FROM `State`");
                                            $stmt3->execute();
                                            $stats = $stmt3->fetchAll();
                                            foreach($stats as $state){
                                                echo "<option value='" . $state['State_ID'] . "'";
                                                if($row['Person_State'] == $state['State_ID']) {echo 'selected';}
                                                echo ">"  . $state['State_Name'] . "</option>" ;
                                            }
                                            ?>
                                    </select>
                                </div>
                                <div class="mb-3 text-center">
                                    <lable for= "cID">المنطقة التعليمية</lable>
                                    <select name= "city" class= "form-control" id= "cID">
                                        <?php
                                            $stmt4= $con->prepare("SELECT * FROM area");
                                            $stmt4->execute();
                                            $citys = $stmt4->fetchAll();
                                            foreach($citys as $city){
                                                echo "<option value='" . $city['Area_ID'] . "'";
                                                if($row['Person_City'] == $city['Area_ID']) {echo 'selected';}
                                                echo ">"  . $city['Area_Name'] . "</option>" ;                                            }
                                            ?>
                                    </select>
                                </div>
                                <div class="mb-3 text-center">
                                    <lable for= "schID">المدرسة</lable>
                                    <select name= "school" class= "form-control" id= "schID"> 
                                        <?php
                                            $stmt5= $con->prepare("SELECT * FROM school");
                                            $stmt5->execute();
                                            $schools = $stmt5->fetchAll();
                                            foreach($schools as $school){
                                                echo "<option value='" . $school['School_ID'] . "'";
                                                if($row['Person_School'] == $school['School_ID']){echo 'selected';}
                                                echo ">"  . $school['School_Name'] . "</option>";
                                            }
                                            ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <lable>الحالة الأجتماعية</lable>
                                <div class= "pt-3">
                                    <input id="single" type="radio" name= "status" value= "أعذب / عزباء" <?php if($row['Person_Status'] === "أعذب / عزباء"){echo "checked";}?> />
                                    <lable for="single">أعذب / عذباء</lable>
                                    <input id="mared" type="radio" name= "status" value= "متزوج / ة" <?php if($row['Person_Status'] === "متزوج / ة"){echo "checked";} ?> />
                                    <lable for="mared">متزوج/ة</lable>
                                    <input id="deforst" type="radio" name= "status" value= "مطلق / ة" <?php if($row['Person_Status'] === "مطلق / ة"){echo "checked";} ?> />
                                    <lable for="deforst">مطلق/ة</lable>
                                    <input id="death" type="radio" name= "status" value= "أرمل /ة" <?php if($row['Person_Status'] === "أرمل /ة"){echo "checked";} ?> />
                                    <lable for="death">أرمل/ة</lable>
                                </div>
                            </div>

                            <div class= "input_cont">
                                <label>عدد الأبناء</lable>
                                <input type="number" name= "kids" class= "form-control" placeholder= "عدد الابناء"
                                    value= "<?php echo $row['Person_Kids'] ?>" />                            
                            </div>

                            <div class="form-group mb-3">
                                <lable>معرفة بالكمبيوتر</lable>
                                <div class= "pt-3">
                                    <input id="yes" type="radio" name= "computer" value= "1" <?php if($row['Person_Computer'] == 1){echo 'checked';} ?> />
                                    <lable for="yes">نعم</lable>
                                    <input id="no" type="radio" name= "computer" value= "0" <?php if($row['Person_Computer'] == 0){echo 'checked';} ?> />
                                    <lable for="no">لا</lable>
                                </div>
                            </div>

                            <textarea name= "program" class= "form-control" placeholder= "المهارات الاضافية" value= "<?php echo $row['Person_Program'] ?>"></textarea>
                            <input class= "btn btn-primary" type= "submit" value= "حفظ" /> 
                        </form>
                    </div>
                </div>
            </div>
    <?php
            }else{
                $theMsg= '<div class= "alert alert-danger"> لايوجد مستخدم بهذا الاسم </div>';
                redirectHome($theMsg, 5, "back");
            }
        
        } elseif ($do == 'Update'){ // Update area

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                echo '<div class= "container text-start">';
                $id         = $_POST['user'];
                $name       = $_POST['fullName'];
                $gander     = $_POST['type'];
                $bDate      = $_POST['b-date'];
                $pDate      = $_POST['place_date'];
                $email      = $_POST['email'];
                $job        = $_POST['job'];
                $state      = $_POST['state'];
                $city       = $_POST['city'];
                $school     = $_POST['school'];
                $phone      = $_POST['phone'];
                $status     = $_POST['status'];
                $kids       = $_POST['kids'];
                $computer   = $_POST['computer'];
                $program    = $_POST['program'];

                // Password Trick
                $pass= (empty($_POST['new_password'])) ? $_POST['old_password'] : sha1($_POST['new_password']);

                // Validate The Form
                $formError = array();

                
                if(strlen($id) > 20 OR strlen($id) < 11 ){
                    $formError[]= ' الرقم الوطني يجب ان لا يقل عن  <strong> 4 ارقام </strong> ولا يزيد عن  <strong> 20 رقم </strong>';
                }
                if(strlen($name) > 80 OR strlen($name) < 20 ){
                    $formError[]= ' الاسم يجب ان لا يقل عن <strong> 20 حرف </strong> ولا يزيد عن  <strong> 80 حرف </strong>';
                }
                if(empty($email)){
                    $formError[]= '  البريد الالكتروني لايمكن ان يكون  <strong> خالي </strong>';
                }
                if(empty($phone)){
                    $formError[]= '  رقم الهاتف لايمكن ان يكون  <strong> خالي </strong>';
                }

                foreach($formError as $error){
                    echo '<div class= "alert alert-danger">' . $error . '</div>';
                }

                if(empty($formError)){

                    $stmt = $con-> prepare("SELECT * FROM information WHERE Person_ID != ?");
                    $stmt-> execute(array($id));
                    $count = $stmt->rowCount();

                    if($count == 1){
                        $theMsg= '<div class= "alert alert-danger">هذا المستخدم موجود </div>';
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
                                                    Person_Email    = ?,
                                                    Person_Job      = ?, 
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
                        $stmt->execute(array($pass, $name, $bDate, $pDate,
                                            $gander, $email, $job, $state, 
                                            $city, $school, $phone, $status,
                                            $kids, $computer, $program, $id));



                    $theMsg= '<div class= "alert alert-success"> تمت التعديلات بنجاح  </div>';
                    redirectHome($theMsg, 6, 'members.php');
        }
                }


            } else {
                $theMsg= '<div class= "alert alert-danger">لا يمكنك الدخول الي هذه الصفحة مباشرتا</div>';
                redirectHome($theMsg, 6);
            }
            echo '</div>';
        } elseif ($do == 'Delete'){ // Delete area

            echo '<div class="container">';
                    $userId = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0;     
                    $check= checkItem("Person_ID", "information", $userId);
                    
                    if($check > 0){
                        $stmt = $con->prepare("DELETE FROM information WHERE Person_ID = ?");
                        $stmt->execute(array($userId));

                        $theMsg= '<div class= "alert alert-success">تم حزفه ' . $stmt-> rowCount() . ' سجل  </div>';
                        redirectHome($theMsg, 5, 'back');

                    }else {
                        $theMsg= '<div class= "alert alert-danger"> لايوجد مستخدم بهذا الاسم </div>';
                        redirectHome($theMsg, 5, "back");
                    }
            echo '</div>';
        } elseif ($do == 'Activate'){ // Activated area
            echo '<div class="container">';
                    $userId = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0;     
                    $check= checkItem("Person_ID", "information", $userId);
                    
                    if($check > 0){
                        $stmt = $con->prepare("UPDATE information SET Reg_Status = 1 WHERE Person_ID = ?");
                        $stmt->execute(array($userId));

                        $theMsg= '<div class= "alert alert-success"> تم تفعيل المستخدم بنجاح</div>';
                        redirectHome($theMsg, 5, 'back');

                    }else {
                        $theMsg= '<div class= "alert alert-danger"> لايوجد مستخدم بهذا الاسم </div>';
                        redirectHome($theMsg, 5, "back");
                    }
            echo '</div>';
        }

echo '</div>';


        include $temp . 'footer.php';
    }else{
        header('location: boss.php');
        exit();
    }
    

    ob_end_flush();
?>