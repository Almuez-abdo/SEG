<?php 
    ob_start();

    session_start();
    $pageTitle = "login";
    include "init.php";

   

    if(isset($_SESSION['user']) && $_SESSION['user'] > 3){
        header('location: main.php');
        exit();

        }elseif(!isset($_SESSION['user'])){
        $_SESSION['user'] = 0;
        }

        $_SESSION['user']++;

        $max_attempts = 3;
    
        if($_SESSION['user'] > $max_attempts){
            $_SESSION['user'] = 0;
    
            $theMsg= '<div class= "alert alert-danger"> تجاوزت عدد المحاولات المسموح به تاكد من اسم المستخدم الخاص بك وكلمة المرور واعد المحاولة لاحقاً</div>';
            redirectHome($theMsg, 3, 'back'); 
        }
    
    
   

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $user   = $_POST['user'];
        $pass   = sha1($_POST['pass']);
    

        $stmt = $con->prepare("SELECT 
                                    *
                                FROM
                                    information
                                WHERE
                                    Person_ID = ?
                                AND
                                    Person_Password= ?
                                AND 
                                group_ID = 0
                                ");
        $stmt->execute(array($user, $pass));
        $getID= $stmt->fetch();
        $count = $stmt->rowCount(); 
        

        if($count > 0){
            if($getID['Person_Job'] == 'شؤون الموظفين'){
                $_SESSION['user'] = $user;
                $_SESSION['uID'] = $getID['Person_ID'];
                header('location: boss.php');
                exit();
            }else{
                $_SESSION['user'] = $user;
                $_SESSION['uID'] = $getID['Person_ID'];
                header('location: main.php');
                exit();
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
    
    <section> 
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-5 col-md-6 col-sm-8 py-3">
                    <div class= "info">
                        <h3 class="text-center">أهلا بكم في موقع الحكومة الالكترونية <br>
                        (قسم شؤون الموظفين)</h3>
                        <div>
                            <h4>موظفي مديرة التربية والتعليم</h4>
                            <ul>
                                <li>اسم المستخدم هو رقم الهوية </li>
                                <li> كلمة المرور هو الرقم الذي ادخلته عند التسجيل ويمكنك تغيره</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-8 p-form text-dark py-3">
                    <h3>دخول</h3>                    
                    <form class= "login" action= "<?php echo $_SERVER['PHP_SELF'] ?>" method = "POST">
                        <div class= "input_cont">
                            <input class="form-control" type="text" name= "user" placeholder= "الرقم الوطني" autocomplete="off" />
                            <span class= "asterisk">*</span>
                        </div>
                        <div class= "input_cont">
                            <input class="form-control" type="password" name= "pass" placeholder="كلمة السر" autocomplete= "new-password" />
                            <span class= "asterisk">*</span>
                        </div>
                        <input class= "btn btn-success" type= "submit" value= "دخول" /> 
                        <a href= "singup.php">
                            <input class= "btn btn-primary" type= "submit" value= "تسجيل" />
                        </a>
                        <a href= "rePassword.php" class= "rePass"> هل نسيت كلمة المرور</a> 
                    </form>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 log_nav py-3">
                    <h3><a href="log.php">القائمة الرئيسية</a></h3>
                    <h3><a href="info.php"> وزارة التربية والتعليم </a></h3>
                    <h3> <a href="rebort.php"> طلب توظيف </a></h3>
                </div>
            </div>
    </section>
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
    include $temp . "footer.php";

    ob_end_flush();
?>

