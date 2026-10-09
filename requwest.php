<?php
    ob_start();
    session_start();
    $pageTitle = "requst";

    include 'init.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $num_name   = filter_var($_POST['num_re'], FILTER_SANITIZE_NUMBER_INT);
        $name       = filter_var($_POST['name_re'], FILTER_SANITIZE_STRING);
        $name_m     = filter_var($_POST['name_mam'], FILTER_SANITIZE_STRING);
        $year_grad  = $_POST['date_re'];
        $tkhsas     = filter_var($_POST['qual_re'], FILTER_SANITIZE_STRING);
        $univ       = filter_var($_POST['unif_re'], FILTER_SANITIZE_STRING);
        $univ_T       = filter_var($_POST['unif_Part'], FILTER_SANITIZE_STRING);
        $gander     = filter_var($_POST['type_re'], FILTER_SANITIZE_STRING);
        $mail       = filter_var($_POST['mail_re'], FILTER_SANITIZE_STRING);
        $bDate      = $_POST['b_date_re'];
        $p_Date     = filter_var($_POST['p_date_re'], FILTER_SANITIZE_STRING);
        $phone      = filter_var($_POST['phone_re'], FILTER_SANITIZE_NUMBER_INT);
        $state      = filter_var($_POST['place_re'], FILTER_SANITIZE_STRING);
        $city       = filter_var($_POST['city_re'], FILTER_SANITIZE_STRING);
        $area       = filter_var($_POST['aria_re'], FILTER_SANITIZE_STRING);
        $subj       = filter_var($_POST['subj_re'], FILTER_SANITIZE_STRING);
        $skils      = filter_var($_POST['skil_re'], FILTER_SANITIZE_STRING);
        $other      = filter_var($_POST['other_re'], FILTER_SANITIZE_STRING);

        $check = checkItem('People_ID', 'people', $num_name);

        echo '<div class= "container">';

        if($check == 1){
            $theMsg= '<div class= "alert alert-success"> هنالك ملف سابق بهذا الرقم الوطني</div>';
            redirectHome($theMsg, 4, "back");
        }else{
            $stPeople = $con->prepare("INSERT INTO
                                            people(People_ID, People_Name, Mother_Name, People_Email, Date_Grad, Grad_Type, Grad_Univ, Univ_Part, People_Gander, Birth_Date, Place_Date, People_Phone, People_state, People_area, People_Naber, Subject_T, People_Skils, Other_Info, Des_Bos)
                                            VALUES(:id, :pName, :mName, :pMail, :dGrad, :gType, :gUniv, :univT, :gander, :bDate, :pDate, :phone, :pState, :pCity, :pNaber, :sub, :pSkils, :oInfo, 0)");
            $stPeople->execute(array(
                    'id'        => $num_name, 
                    'pName'     => $name,
                    'mName'     => $name_m,
                    'pMail'     => $mail,
                    'dGrad'     => $year_grad,
                    'gType'     => $tkhsas,
                    'gUniv'     => $univ,
                    'univT'     => $univ_T,
                    'gander'    => $gander,
                    'bDate'     => $bDate,
                    'pDate'     => $p_Date,
                    'phone'     => $phone,
                    'pState'    => $state,
                    'pCity'     => $city,
                    'pNaber'    => $area,
                    'sub'       => $subj,
                    'pSkils'    => $skils,
                    'oInfo'     => $other
                ));


            $theMsg= '<div class= "alert alert-success"> تم أضافت ملفك سيتم التواصل معك هاتفيا</div>';
            redirectHome($theMsg, 4, "loguot.php");
            }
        echo '</div>';

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

    
    <div class= "rebo">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 bg-dark text-light py-3">
                    <h3><a href="log.php">القائمة الرئيسية</a></h3>
                    <h3><a href="info.php"> وزارة التربية والتعليم </a></h3>
                    <h3> <a href="rebort.php"> طلب توظيف </a></h3>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-8 bg-light py-3">
                    <h3>أستمارة التقديم</h3>
                    <form class="singUp" action= "<?php echo $_SERVER['PHP_SELF'] ?>" method= "POST">
                        <div class="form-group mb-3">
                            <input type="text" placeholder="الرقم الوطني" name= "num_re" />
                            <input type="text" placeholder="اسمك ثلاثي" name= "name_re" />
                            <input type="text" placeholder="اسم الوالدة" name= "name_mam" />
                        </div>
                        <div class="form-group mb-3">
                            <div class= "year_grad">
                                <lable>سنة التخرج<input type="date" name= "date_re" class= "me-2" /></lable>
                                <div>
                                    <lable>المؤهل الدراسي</lable>
                                    <select name= "qual_re">
                                        <option value= "دبلوم">دبلوم</option>
                                        <option value= "دبلوم عالي">دبلوم عالي</option>
                                        <option value= "بكالريوس">بكالريوس</option>
                                        <option value= "ماجستير">ماجستير</option>
                                        <option value= "دكتوراه">دكتوراه</option>
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                        <div class= "form-group mb-3">   
                            <input type="text" placeholder="الجامعة" name= "unif_re" />
                            <input type="text" placeholder="التخصص" name= "unif_Part" />
                            <input type="email" placeholder="البريد الألكتروني" name= "mail_re" />
                        </div>
                        <div class="form-group mb-3">
                            <div class= "year_grad">
                                <div>
                                    <lable>الجنس</lable>
                                    <div class= "d-inline-block me-5">
                                        <input id="mail" type="radio" name= "type_re" value= "1" />
                                        <lable for="mail">ذكر</lable>
                                        <input id="femail" type="radio" name= "type_re" value= "0" />
                                        <lable for="femail">أنثي</lable>
                                    </div>
                                </div>
                            <lable >تاريخ الميلاد<input type="date" name= "b_date_re" class= "me-2" /></lable>
                        </div>
                        <div class="form-group mb-3">
                            <input type= "text" placeholder= "مكان الميلاد" name= "p_date_re" />
                            <input type="text" placeholder="رقم الهاتف" name= "phone_re" />
                        </div>
                        <div class="form-group mb-3">
                            <lable class= "d-block">الأقامة الحالية :-</lable>
                            <div class="mb-3 text-center">
                                <lable for="stID" class = "d-inline-block">الولاية</lable>
                                <select name= "place_re" class= "form-control" id= "stID">
                                    <?php
                                        $stPeople= $con->prepare("SELECT * FROM `State` WHERE State_ID = 1");
                                        $stPeople->execute();
                                        $stats = $stPeople->fetchAll();
                                        foreach($stats as $state){
                                            echo "<option value='" . $state['State_ID'] . "'>"  . $state['State_Name'] . "</option>" ;

                                        }
                                        ?>
                                </select>
                            </div>
                            <div class="mb-3 text-center">
                                <lable for= "cID">المحلية</lable>
                                <select name= "city_re" class= "form-control" id= "cID">
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
                            <input class= "form-control" type="text" placeholder="الحي" name= "aria_re" />
                        </div>
                        <div class="form-group mb-3">
                            <input type="text" placeholder="المواد التي تدرسها" name= "subj_re" />
                            <input type="text" placeholder="المهارات" name= "skil_re" />
                        </div>
                        <div class="form-group mb-3">
                            <textarea placeholder="اي معلومة أضافية" name= "other_re" ></textarea>
                        </div>

                        <input type= "submit" class= "btn btn-success" value= "تقديم">

                    </form>
                    
                </div>
            </div>
        </div>
    </div>

<?php
    include $temp . "footer.php";
?> 