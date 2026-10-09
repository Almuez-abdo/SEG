<?php
    ob_start();
    session_start();
    $pageTitle = "singUp";

    if(isset($_SESSION['user'])){
        header('location: main.php');
        exit();
    }
    include "init.php";

    $actived = (isset($_GET['page']) && $_GET['page'] == 'pending') ? " AND Reg_Status = 0" : "";
            
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        echo '<div class= "container text-start">';
    

        // Avatar Upload
        $avatarName = $_FILES['avatar']['name'];
        $avatarSize = $_FILES['avatar']['size'];
        $avatarTmp  = $_FILES['avatar']['tmp_name'];
        $avatarType = $_FILES['avatar']['type'];
        $avatarExt  = array("jpeg", "jpg", "png", "gif");
        $extensionArray  = explode(".", $avatarName);
        $endExten = strtolower(end($extensionArray));

        $id         = filter_var($_POST['userName'], FILTER_SANITIZE_STRING);
        $fullN      = filter_var($_POST['fullName'], FILTER_SANITIZE_STRING);
        $email      = filter_var($_POST['mail'], FILTER_SANITIZE_STRING);
        $phone      = filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT);
        $type       = $_POST['type'];
        $b_Date     = filter_var($_POST['b-date'], FILTER_SANITIZE_NUMBER_INT);
        $p_Date     = filter_var($_POST['place_date'], FILTER_SANITIZE_STRING);
        $job        = $_POST['job'];
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
        $pass = $_POST['pass'];
        $hashPass= sha1($pass);


        // Validate The Form
        $formError = array();

        if(strlen($id) > 20 OR strlen($id) < 11 ){
            $formError[]= ' الرقم الوطني يجب ان لايقل عن  <strong> 11 رقم </strong> ولا يزيد عن  <strong> 20 رقم </strong>';
        }
        if(empty($fullN)){
            $formError[]= ' الاسم الشخصي لايمكن ان يكون <strong> خالي </strong>';
        }
        if(strlen($fullN) > 80 OR strlen($fullN) < 20 ){
            $formError[]= ' الاسم الشخصي لايمكن ان يكون اقل من  <strong> 20 حروف </strong> ولا اكبر من <strong> 80 حرف </strong>';
        }
        if(empty($pass)){
            $formError[]= ' الرقم السري يجب ان لا يكون <strong> خالي </strong>';
        }
        if(!($pass === $_POST['rePass'])){
            $formError[]= ' الباسويرد غير  <strong> متطابق </strong>';
        }
        if(empty($email)){
            $formError[]= '  البريد الالكتروني يجب ان لا يكون <strong> خالي </strong>';
        }
        if(empty($phone)){
            $formError[]= '   رقم الهاتف يجب ان لا يكون <strong> خالي </strong>';
        }
        if(! empty($avatarName) && ! in_array($endExten, $avatarExt)){
            $formError[]= 'امتداد الصورة  <strong> غير مطابق </strong>';
        }
        if($avatarSize > 4194304 ){
            $formError[]= 'حجم الصورة يجب ان لا يتعدي <strong> 4 ميغابايت</strong>';
        }

        if(!empty($formError)){
            foreach($formError as $error){
                echo '<div class= "alert alert-danger">' . $error . '</div>';
            }
        }else{

            $check = checkItem("Person_ID", "information", $id);

            if($check == 0){
                $avatar = rand(0, 10000000) . $avatarName;
                move_uploaded_file($avatarTmp, "upload\avatar\\" . $avatar);

                $stmt2 = $con->prepare("INSERT INTO 
                                            information(Person_ID, Person_Password, Person_Name, Person_Avatar, Person_Date, Person_D_P, Gander, Person_Email, Person_Job, Person_State, Person_City, Person_School, Person_Phone, Reg_Status)
                                        VALUES(:zid, :zpass, :zname, :zavatar, :zbDate, :zpDate, :zgander, :zmail, :zjob, :zstate, :zcity, :zschool, :zphone, 0)");
                $stmt2->execute(array(
                    'zid'       => $id,
                    'zpass'     => $hashPass,
                    'zname'     => $fullN,
                    'zavatar'   => $avatar,
                    'zbDate'    => $b_Date,
                    'zpDate'    => $p_Date,
                    'zgander'   => $type,
                    'zmail'     => $email,
                    'zjob'      => $job,
                    'zstate'    => $state,
                    'zcity'     =>$city,
                    'zschool'   => $school,
                    'zphone'    => $phone
                ));

                $theMsg= '<div class= "alert alert-success"> تم التسجيل بنجاح سيتم تفعيل حسابك قريبا</div>';
                redirectHome($theMsg, 4, "main.php");
                
            } else {
                $theMsg= '<div class= "alert alert-danger"> هذاالمستخدم موجود </div>';
                redirectHome($theMsg, 4, "back");
            }

            

        }
    }


?>


    <nav class="navbar header_title">
        <div class="container">
            <div class="navbar">
                <h2>حكــومـة السـودان الالـكـترونـيـة - وزارة التـربية والتـعليم</h2>
            </div>
            <a class="navbar-brand" href= "log.php"><img src="layout/images/logo.png" alt="no Service"></a>     
        </div>
    </nav>

    <h2 class= "text-center py-3">تســجيل</h2>
    <div class="container singUp">
        <div class= "row">
            <div class= "col-md-offsit-3"> 
                <form class= "signUp" action= "<?php echo $_SERVER['PHP_SELF'] ?>" method = "POST" enctype= "multipart/form-data">
                    <div class= "input_cont">
                        <input type= "text" name= "userName" class= "form-control" autocomplete= "off" 
                            required= "require" placeholder= "الرقم الوطني" />                                
                        <span class= "asterisk">*</span>
                    </div>
                    <div class= "input_cont">
                        <input pattern= ".{10,80}" type= "text" name= "fullName" class= "form-control" autocomplete= "off" 
                            required= "require" placeholder= "الاسم الشخصي" />                                
                        <span class= "asterisk">*</span>
                    </div>                        
                    <div class= "input_cont">
                        <input minlength= "8" type= "password" name= "pass" class= "form-control" 
                            autocomplete= "new-password" placeholder= "كلمة السر" />
                        <i class= "show-pass fa fa-eye"></i>
                        <span class= "asterisk">*</span>
                    </div>
                    <div class= "input_cont">
                        <input minlength= "8" type= "password" name= "rePass" class= "form-control" 
                            autocomplete= "new-password" placeholder= "أعادة كلمة السر" />
                        <i class= "show-pass fa fa-eye"></i>
                        <span class= "asterisk">*</span>
                    </div> 
                    <div class= "input_cont">
                        <lable>الصورة الشخصية</lable>
                        <input type= "file" name= "avatar" class= "form-control" />
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
                        <input type="email" name= "mail" class= "form-control" required= "required" 
                            placeholder= "البريد الألكتروني" />
                        <span class= "asterisk">*</span>
                    </div>
                    <div class="form-group mb-3">
                        <lable>الوظيفة</lable>
                        <div class= "pt-3" required= "required" class= "form-control" required= "requird">
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
                            <select name= "state" class= "form-control" required= "requird">
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
                            <select name= "city" class= "form-control" required= "requird">
                                <?php
                                    $stmt4= $con->prepare("SELECT * FROM aria");
                                    $stmt4->execute();
                                    $citys = $stmt4->fetchAll();
                                    foreach($citys as $city){
                                        echo "<option value='" . $city['Aria_ID'] . "'>"  . $city['Aria_Name'] . "</option>" ;
                                    }
                                    ?>
                            </select>
                        </div>
                        <div class="mb-3 text-center">
                            <lable>المدرسة</lable>
                            <select name= "school" class= "form-control" required= "requird"> 
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
                    <input class= "btn btn-success" type= "submit" value= "تسجيل" /> 
                </form>
            </div>
        </div>
    </div>



        


<?php

    include $temp . 'footer.php';
    ob_end_flush();
?>