<?php
    ob_start();

    session_start();
    $pageTitle = "Home";
    $noNavbar = "";

    if (isset($_SESSION['UserName'])){
        include 'init.php';

        $stAll = $con->prepare("SELECT * FROM information WHERE Group_ID = 0 AND Reg_Status = 0");
        $stAll->execute();

        $my = $stAll->fetchAll();


        ?>
   <nav class="navbar navbar-expand-md header_title">
        <div class="container">
            <a class="navbar-brand" href= "homPage.php"><img src="layout/images/logo.png" alt="no Service"></a>     
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

    <section class="containetr mt-3">
        <div class="row">
            <div class="col-md-offset-3 py-3 bg-dark text-light">
                <div class= "container home-part text-center py-5">
                    <h1 class= "pb-5"> الــــعـــرض </h1>
                    <div class= "row">
                        <div class= "col-md-4">
                            <div class= "part-pending">
                                <h4> جميع المستخدمين </h4>
                                <span class= "d-block"><a href= "members.php">
                                    <?php
                                        $stall = $con->prepare("SELECT * FROM information WHERE Group_ID = 0");
                                        $stall->execute();
                                        $allC = $stall->rowCount();
                                        echo $allC;
                                    ?>
                                </a></span>
                            </div>
                        </div>
                        <div class= "col-md-4">
                            <div class= "part-pending">
                                <h4> شؤون الموظفين </h4>
                                <span class= "d-block"> <a href= "members.php?do=boss">
                                    <?php
                                        $stBoss = $con->prepare("SELECT * FROM information WHERE Group_ID = 0 AND Person_Job = 'شؤون الموظفين'");
                                        $stBoss->execute();
                                        $bossC = $stBoss->rowCount();
                                        echo $bossC;
                                    ?>
                                </a></span>
                            </div>
                        </div>
                        <div class= "col-md-4">
                            <div class= "part-pending">
                                <h4> غير مفعلين </h4>
                                <span class= "d-block"><a href= "members.php?do=pending">
                                <?php
                                    $stPend = $con->prepare("SELECT * FROM information WHERE Group_ID = 0 AND Reg_Status = 0");
                                    $stPend->execute();
                                    $mangC = $stPend->rowCount();
                                    echo $mangC;
                                    ?>
                                </a></span>                 
                            </div>
                        </div>
                        <div class= "col-md-4">
                            <div class= "part-manger">
                                <h4> المدراء </h4>
                                <span class= "d-block"><a href= "members.php?do=Manger">
                                    <?php
                                        $stMang = $con->prepare("SELECT * FROM information WHERE Group_ID = 0 AND Person_Job = 'مدير'");
                                        $stMang->execute();
                                        $mangC = $stMang->rowCount();
                                        echo $mangC;
                                    ?>
                                </a></span>
                            </div>
                        </div>
                        <div class= "col-md-4">
                            <div class= "part-manger">
                                <h4> الأساتذة </h4>
                                <span class= "d-block"> <a href= "members.php?do=teatcher">
                                    <?php
                                        $stTea = $con->prepare("SELECT * FROM information WHERE Group_ID = 0 AND Person_Job = 'أستاذ'");
                                        $stTea->execute();
                                        $teaC = $stTea->rowCount();
                                        echo $teaC;
                                    ?>
                                </a></span>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
        include $temp . 'footer.php';
    } else{
        header('location: boss.php');
        exit();
    }

    ob_end_flush();
?>
