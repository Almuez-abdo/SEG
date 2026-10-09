<?php 
    ob_start();

    session_start();
    $pageTitle = "rePassword";
    include "init.php";


    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        echo '<div class= "container text-center">';

        $id         = filter_var($_POST['userName'], FILTER_SANITIZE_STRING);
        $fullN      = filter_var($_POST['fullName'], FILTER_SANITIZE_STRING);
        $email      = filter_var($_POST['mail'], FILTER_SANITIZE_STRING);
        $pass       = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
        $rePass     = filter_var($_POST['rePass'], FILTER_SANITIZE_STRING);
        if($pass === $rePass){
            $newPass = sha1($pass);
        }

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
        if(empty($email)){
            $formError[]= ' الاسم الشخصي لايمكن ان يكون <strong> خالي </strong>';
        }
        if(empty($pass)){
            $formError[]= ' الاسم الشخصي لايمكن ان يكون <strong> خالي </strong>';
        }
        if($pass !== $rePass){
            $formError[]= 'كلمة السر المدخلة غير  <strong> متطابقة </strong>';
        }

        if(!empty($formError)){
            foreach($formError as $error){
                echo '<div class= "alert alert-danger">' . $error . '</div>';
            }
        }else{
            $stcheck = $con->prepare("SELECT * FROM information WHERE Person_ID = ? AND Person_Name = ? AND Person_Email = ?");
            $stcheck->execute(array($id, $fullN, $email));
            $count = $stcheck->rowCount();
            $chAll = $stcheck->fetch();
            if($count > 0){

                $stUp = $con->prepare("UPDATE information SET Person_Password = ? WHERE Person_ID = ?");
                $stUp->execute(array($newPass, $id));

                $theMsg= '<div class= "alert alert-success">تم تغير كلمة السر بنجاح</div>';
                redirectHome($theMsg, 4, "log.php");
            }else{
                $theMsg= '<div class= "alert alert-danger"> هذاالمستخدم غير موجود </div>';
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

    <div class= "container">
        <form action= "<?php echo $_SERVER['PHP_SELF'] ?>" class= "rePassForm" method= "POST">
            <h3>أسترجاع كلمة السر</h3>
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
                <input type="email" name= "mail" class= "form-control" required= "required" 
                    placeholder= "البريد الألكتروني" />
                <span class= "asterisk">*</span>
            </div>
            <h3>كلمة السر الجديدة</h3>
            <div class= "input_cont">
                <input type= "password" name= "pass" class= "form-control" placeholder= "كلمة السر" 
                    required= "require"/>
                <span class= "asterisk">*</span>
            </div>
            <div class= "input_cont">
                <input type= "password" name= "rePass" class= "form-control" placeholder= "اعادة كلمة السر" 
                    required= "require"/>
                <span class= "asterisk">*</span>
            </div>
            <input class= "btn btn-primary" type= "submit" value= "ارسال" /> 
        </form>
    </div>
<?php 
    
    include $temp . 'footer.php';
    ob_end_flush();
?>