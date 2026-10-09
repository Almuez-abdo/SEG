<?php 
    ob_start();

    session_start();
    $pageTitle = "Edit Profile";

    if(isset($_SESSION['user'])){
        $sUser = $_SESSION['user'];
        include "init.php";
        include $temp . "nav.php";
       

        $stmt3 = $con->prepare("SELECT
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
        $stmt3->execute(array($sUser));
        $s_full = $stmt3->fetch();
        $count = $stmt3-> rowCount();

        if($count > 0){?>
            <div class= "edit_pro">
                <h1>تعديل الملف الشخصي</h1>
                <div class="container">
                    <div class= "row">
                        <div class= "col-md-offset-3"> 
                            <form  action="update.php" method= "POST" enctype= "multipart/form-data">
                                <input class= "form-control" type= "hidden" name= "userName" value= "<?php echo $s_full['Person_ID'] ?>" />
                                <div class= "input_cont">
                                    <input pattern= ".{10,80}" type= "text" name= "fullName" class= "form-control" autocomplete= "off" 
                                    required= "require" placeholder= "الاسم الشخصي" value= "<?php echo $s_full['Person_Name'] ?>"/>
                                    <span class= "asterisk">*</span>
                                </div>                        
                                <div class= "input_cont">
                                    <input minlength= "4" type= "password" name= "new_password" class= "form-control" 
                                        autocomplete= "new-password" placeholder= "كلمة السر" />
                                    <i class= "show-pass fa fa-eye"></i>
                                    <span class= "asterisk">*</span>
                                    <input type= "hidden" name= "old_password" value= "<?php echo $s_full['Person_Password'] ?>" />
                                </div> 
                                <div class= "input_cont">
                                    <input type= "text" name= "phone" class= "form-control" 
                                    required= "required" placeholder= "رقم الهاتف" value= "<?php echo $s_full['Person_Phone'] ?>"/>
                                    <span class= "asterisk">*</span>
                                </div>

                                <div class="form-group mb-3">
                                    <lable>الجنس</lable>
                                    <div class= "pt-3">
                                        <input id="mail" type="radio" name= "type" value= "1" <?php if($s_full['Gander'] === 1){echo "checked";}?> />
                                        <lable for="mail">ذكر</lable>
                                        <input id="femail" type="radio" name= "type" value= "0" <?php if($s_full['Gander'] === 0){echo "checked";} ?> />
                                        <lable for="femail">أنثي</lable>
                                    </div>
                                </div>
                                <div class= "input_cont">
                                    <lable>تاريخ الميلاد</lable><input type="date" name= "b-date" class= "form-control"
                                    value= "<?php echo $s_full['Person_Date'] ?>" />
                                </div>
                                <div class= "input_cont">
                                    <input type="serch" name= "place_date" class= "form-control" placeholder= "مكان الميلاد"
                                    value= "<?php echo $s_full['Person_P_D'] ?>" />
                                </div>
                                <label class= "my-3">مكان العمل</label>
                                <div class= "work_place">
                                    <div class="mb-3 text-center">
                                        <lable for="stID" class = "d-inline-block">الولاية</lable>
                                        <select name= "state" class= "form-control" id= "stID">
                                            <?php
                                                $stmt3= $con->prepare("SELECT * FROM `State` WHERE State_ID = 1");
                                                $stmt3->execute();
                                                $stats = $stmt3->fetchAll();
                                                foreach($stats as $state){
                                                    echo "<option value='" . $state['State_ID'] . "'";
                                                    if($s_full['Person_State'] == $state['State_ID']) {echo 'selected';}
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
                                                    if($s_full['Person_City'] == $city['Area_ID']) {echo 'selected';}
                                                    echo ">"  . $city['Area_Name'] . "</option>" ;
                                                }
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
                                                    if($s_full['Person_School'] == $school['School_ID']) {echo 'selected';}
                                                    echo ">"  . $school['School_Name'] . "</option>" ;
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <lable>الحالة الأجتماعية</lable>
                                    <div class= "pt-3">
                                        <input id="single" type="radio" name= "status" value= "0" <?php if($s_full['Person_Status'] === "أعذب / عزباء"){echo "checked";}?> />
                                        <lable for="single">أعذب / عذباء</lable>
                                        <input id="mared" type="radio" name= "status" value= "1" <?php if($s_full['Person_Status'] === "متزوج / ة"){echo "checked";} ?> />
                                        <lable for="mared">متزوج/ة</lable>
                                        <input id="deforst" type="radio" name= "status" value= "2" <?php if($s_full['Person_Status'] === "مطلق / ة"){echo "checked";} ?> />
                                        <lable for="deforst">مطلق/ة</lable>
                                        <input id="death" type="radio" name= "status" value= "3" <?php if($s_full['Person_Status'] === "أرمل / ة"){echo "checked";} ?> />
                                        <lable for="death">أرمل/ة</lable>
                                    </div>
                                </div>

                                <div class= "work_place">
                                    <label>عدد الأبناء</lable>
                                    <input type="number" name= "kids" class= "form-control" placeholder= "عدد الابناء"
                                    value= "<?php echo $s_full['Person_Kids'] ?>" />
                                </div>

                                <div class="form-group mb-3">
                                    <lable>معرفة بالكمبيوتر</lable>
                                    <div class= "pt-3">
                                        <input id="yes" type="radio" name= "computer" value= "1" <?php if($s_full['Person_Computer'] === 1){echo "checked";}?> />
                                        <lable for="yes">نعم</lable>
                                        <input id="no" type="radio" name= "computer" value= "0" <?php if($s_full['Person_Computer'] === 0){echo "checked";} ?> />
                                        <lable for="no">لا</lable>
                                    </div>
                                </div>

                                <div class= "input_cont">
                                    <textarea name= "program" class= "form-control" placeholder= "المهارات الاضافية"
                                    ><?php echo $s_full['Person_Program'] ?></textarea>
                                </div>

                                <div class= "text-center my-3">
                                    <input type= "submit" value= "حفظ" class= "btn btn-success btn-block" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>                            
<?php 
        }else {
            echo "لا يوجد مستخدم بهذا الاسم";
        }
    }else{
        header('location: main.php');
        exit();
    }

    include $temp . "footer.php";
    ob_end_flush();

?>