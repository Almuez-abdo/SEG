<?php
ob_start();
session_start();
$pageTitle = "My Profile";

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
            ?>

    <div class= "pro">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-sm-4 py-3 bg-dark text-light">
                    <div class= "panel panel-success">
                        <div class= "panel-heading">
                            <a href= "avatar.php">
                            <?php
                                if(! empty($my['Person_Avatar'])){
                                    echo '<img src="upload/avatar/' . $my['Person_Avatar'] . '" alt="" class="card-img-top">';
                                }else{
                                    echo '<img src="layout/images/d-1-7.png" alt="" class="card-img-top">';
                                }
                            ?> 
                            </a>                       
                        </div>
                        <div class= "mt-3 text-center">
                            <a href= "edit_pro.php" class= "btn btn-success">تعديل</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-5 col-sm-4 py-3 bg-dark text-light">
                    <h2>المعلومات الشخصية :-</h2>
                    <hr>
                    <div>
                        <h5>الـــــرقم الـــــوطني : <span><?php echo $my['Person_ID']; ?></span></h5>
                        <h5>الاســــــــــــــــــم : <?php echo $my['Person_Name']; ?></span></h5>
                        <h5>تـــــاريخ المـــــيلاد : <?php echo $my['Person_Date']; ?></span></h5>
                        <h5>مــــــكان المـــــيلاد : <?php echo $my['Person_P_D']; ?></span></h5>
                        <h5>الـــــــــــــــــجنس : <?php if($my['Gander'] == '1'){echo 'ذكر';}else{ echo 'أنثي';} ?></span></h5>
                        <h5>رقـــــم الـــــــهاتف : <?php echo $my['Person_Phone']; ?></span></h5>
                        <h5>الـــحالة الاجـــتماعية : <?php echo $my['Person_Status']; ?></span></h5>
                        <h5>عـــــــدد الاطفـــــال : <?php if($my['Person_Kids'] == 0) {echo 'لايوجد';}else{echo $my['Person_Kids'];} ?></span></h5>
                    </div>
                </div>

                <div class="col-md-5 col-sm-4 py-3 bg-dark text-light">
                    <h2>معلومات العمل :-</h2>
                    <hr>
                    <div>
                        <h5>الــــــــــــــــولاية : <?php echo $my['State_Name']; ?></span></h5>
                        <h5>الـــــــــــــــمحلية : <?php echo $my['Area_Name']; ?></span></h5>
                        <h5>الـــــــــــــــمدرسة : <?php echo $my['School_Name']; ?></span></h5>
                        <h5>الــمعرفة بالــكمبيوتر : <?php if($my['Person_Computer'] == '1'){echo 'نعم';}else{ echo 'لا';} ?></span></h5>
                        <h5>مهــــــارات آخـــــري : <?php echo $my['Person_Program']; ?></span></h5>
                    </div>
                <div>
             </div>
        </div>
    </div>

    <?php 
   
}else{
    header('location:log.php');
}


include $temp . 'footer.php';    

?>