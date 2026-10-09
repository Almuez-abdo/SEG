<?php
    ob_start();

    session_start();
    $pageTitle = "Login";
    $noNavbar= '';

    if (isset($_SESSION['UserName'])){
        header('location: homePage.php');
        exit();
    }
    include "init.php";
    


    if($_SERVER ['REQUEST_METHOD'] == "POST"){
        
        $userName = $_POST['user'];
        $password = $_POST['pass'];
        $hashpass = sha1($password);
        $login_att = $_POST['login_attemps'];
        $allowed_attempts = 3;
        if($login_att >= $allowed_attempts){
                echo 'لقد تجاوزت العدد المحدد لتسجيل الدخول اليومي';
            }


        $stmt = $con-> prepare("SELECT 
                                    *
                                FROM
                                    information
                                WHERE
                                    Person_ID= ?
                                AND
                                    Person_Password= ? 
                                AND 
                                    Group_ID = 1
                                ");
        $stmt-> execute(array($userName, $hashpass));
        $row = $stmt->fetch();
        $count = $stmt-> rowCount();

        if($count > 0){
            $_SESSION['UserName']= $userName;
            $_SESSION['ID'] = $row['UserID'];
            header('location: homePage.php');
            exit();
        }
    };
    
?>


    <nav class="navbar header_title">
        <div class="container">
            <div class="navbar">
                <h2>حكــومـة السـودان الالـكـترونـيـة - وزارة التـربية والتـعليم</h2>
            </div>
            <a class="navbar-brand" href= "#"><img src="layout/images/logo.png" alt="no Service"></a>     
        </div>
    </nav>

    <div class="container admin_log">
        <div class="row">
            <div class= "col-lg-offsit-5">
                <form class= "login" action= "<?php echo $_SERVER['PHP_SELF'] ?>" method = "POST">
                    <div class= "input_cont">
                        <input class="form-control" type="text" name= "user" placeholder= "الرقم الوطني" autocomplete="off" />
                        <span class= "asterisk">*</span>
                    </div>
                    <div class= "input_cont">
                        <input class="form-control" type="password" name= "pass" placeholder="كلمة السر" autocomplete= "new-password" />
                        <span class= "asterisk">*</span>
                    </div>
                        <input class= "btn btn-primary" type= "submit" name= "login_attemps" value= "دخول" />  
                </form>
            </div>
        </div>
    </div>
            
<?php
    include $temp . "footer.php";

    ob_end_flush();
?>