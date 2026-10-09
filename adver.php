<?php

    ob_start();
    session_start();
    $pageTitle = "boss";

    include 'init.php'; ?>

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

    if(isset($_SESSION['user'])){
        $sUser = $_SESSION['user'];

        $do = isset($_GET['do']) ? $_GET['do'] : 'main';
        if($do == 'insert_ad'){ //Insert Page
            $subT = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
            $subB = filter_var($_POST['adBody'], FILTER_SANITIZE_STRING);
    
            $stSub = $con->prepare("INSERT INTO 
                                            adver(Adver_Subject, Adver_Text, Adver_Date)
                                        VALUES(:t_sub, :b_sub, now()) ");
            $stSub->execute(array(
                        't_sub' => $subT,
                        'b_sub' => $subB
            ));
    
            $theMsg= '<div class= "alert alert-success"> اعلان ' . $stSub->rowCount() . ' تم أضافته</div>';
            redirectHome($theMsg, 4, "boss.php");
    
        


        }elseif($do == 'edit_ad'){ // Edit aeria
            $adID = $_GET['Adver_ID'];

            $stEdit = $con->prepare("SELECT * FROM adver WHERE Adver_ID = ?");
            $stEdit->execute(array($adID));
            $adEdit = $stEdit->fetchAll();
            echo '<div class= "container">';
            foreach($adEdit as $adE){
                echo '<form class= "form-horizontal" action="adver.php?do=update_ad" method= "POST">';
                    echo '<input type= "hidden" name= "adver_id" value= "' . $adID . '" />';
                    echo '<div class= "form-control">';
                        echo '<input type= "text" name= "subject" placeholder= "عنوان الاعلان" require
                        value= "' . $adE['Adver_Subject'] . '"/>';
                    echo '</div>';
                    echo '<div class= "form-control">';
                        echo '<textarea name= "adBody" placeholder= "موضوع الأعلان" 
                        value= "' . $adE['Adver_Text'] . '"/></textarea>';
                    echo '</div>';
                }
                    echo '<input class= "btn btn-primary btn-block" type= "submit" value= "حفظ" />';
                echo '</form>';
            echo '</div>';
        }elseif($do == 'update_ad'){ // Update aeria
        
           $id = $_POST['adver_id'];
           $sub = $_POST['subject'];
           $body_S = $_POST['adBody'];

           $stUpdate = $con->prepare("UPDATE adver SET
                                        Adver_Subject = ?, Adver_Text = ?
                                    WHERE Adver_ID = ? ");
            $stUpdate->execute(array($sub, $body_S, $id));

            $theMsg= '<div class= "alert alert-success"> تم تعديل ' . $stUpdate->rowCount() . ' أعلان</div>';
            redirectHome($theMsg, 4, "boss.php");
        }elseif($do == 'delete_ad'){ // Delete aeria
            $adID = $_GET['Adver_ID'];

            $stDelete = $con->prepare("DELETE FROM adver WHERE Adver_ID = ? ");
            $stDelete->execute(array($adID));

             $theMsg= '<div class= "alert alert-success"> تم حزف ' . $stDelete->rowCount() . ' أعلان</div>';
             redirectHome($theMsg, 4, "boss.php");
         }

?>



    <div>
        <div class="adver">
            <h2>الأعلانات</h2>
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
                        <a href= "adver.php?do=edit_ad&Adver_ID=<?php echo $adver['Adver_ID'] ?>" class= "btn btn-primary" value= "تعديل"></a>
                        <a href= "adver.php?do=delete_ad&Adver_ID=<?php echo $adver['Adver_ID'] ?>" class= "btn btn-danger" value= "حزف"></a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

        <div class= "container py-3">
            <form class= "form-horizontal" action="adver.php?do=insert_ad" method= "POST">
                <h5>أضافة اعلان</h5>
                <div class= "form-control">
                    <input type= "text" name= "subject" placeholder= "عنوان الاعلان" require/>
                </div>
                <div class= "form-control">
                    <textarea name= "adBody" placeholder= "موضوع الأعلان"></textarea>
                </div>
                <input class= "btn btn-primary btn-block" type= "submit" />
            </form>
        </div>
    </div>
 



            
<?php }


    include $temp . 'footer.php';
    ob_end_flush();
    
?>