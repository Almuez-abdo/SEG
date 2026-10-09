<?php
    ob_start();
    session_start();
    $pageTitle = "rebort";

    include 'init.php';
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
                <div class="col-lg-9 col-md-9 col-sm-10 mb-5 form_rebo">
                    <h3>شـروط تـقديم طـلب التـوظـيف </h3>
                    <h4 class="text-centar">حتي تتمكن من متابعة طلب التوظيف يجب الموافقة علي الشروط التالية :-</h4>
                    <ol class="list">
                        <li>يجب أن تكون المعلومات المدخلة صحيحة </li>
                        <li>أنت تتحمل أي خطأ في البيانات حيث سيتم ألغاء الطلب</li>
                        <li>عدم الاعتراض علي مركز العمل الذي تحدده المديرية </li>
                        <li>الالتزام بالقوانين والقواعد المعمول بها في وزارة التربية والتعليم في حال تعيينك في سلك التربية والتعليم</li>
                        <li>يجب ارفاق نسخة من الوثائق المطلوبة </li>
                        <li>في حال تم التعيين يجب احضار الوثائق الرسمية والا سيتم الغاء عملية التعيين </li>
                    </ol>
                    <h4 class="py-3"><input type="checkbox" id= "agreeCheckbox" class="ms-3">أوافق علي الشروط السابقة</h4>
                    
                    <a href="requwest.php" id= "submitButton"><input type= "submit" class= "btn btn-success" value= "تقديم"></a>
                    
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 bg-dark text-light py-3">
                    <h3><a href="log.php">القائمة الرئيسية</a></h3>
                    <h3><a href="info.php"> وزارة التربية والتعليم </a></h3>
                    <h3> <a href="rebort.php"> طلب توظيف </a></h3>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("agreeCheckbox").addEventListener("change", function(){
            if(this.checked){
                document.getElementById("submitButton").style.display= "block";
            }else{
                document.getElementById("submitButton").style.display= "none";
            }
        })
    </script>

<?php

    include $temp . 'footer.php';
?>