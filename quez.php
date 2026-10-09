<?php

    ob_start();
    session_start();
    $pageTitle = "Main";

    include 'init.php';
    include $temp .'nav.php';


    if(isset($_SESSION['user'])){
        
        echo '<div class= "container">';

        $do = isset($_GET['do']) ? $_GET['do'] : '';

        $stmt3= $con->prepare("SELECT
                                    information.*,
                                    `state`.*,
                                    area.*,
                                    school.*
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
        $stmt3->execute(array($_SESSION['user']));
        $quezs = $stmt3->fetchAll();
    
        foreach($quezs as $quez){

        }
        
        if($do == 'quez0'){ ?>
            <form class= "form-horizontal f_Quez" action="update_qu.php" method= "POST">
                <h1 class= "py-3">أحتياجات المدرسة</h1>
                <div class= "form-control">
                    <h2 class= "text-center py-5"> بسم الله الرحمن الرحيم </h2> 
                    <h4 class= "text-start"><?php echo date('y-m-d') ?> </h4>
                </div>
                <div class= "form-control">
                    <input type= "hidden" name= "state_n" value= "<?php echo $quez['State_ID']; ?>">
                    <input type= "hidden" name= "city_n" value= "<?php echo $quez['Area_ID']; ?>">
                    <input type= "hidden" name= "school_n" value= "<?php echo $quez['School_ID']; ?>">
                    <span><?php echo $quez['Person_Name']; ?> - </span>
                    <span><?php echo $quez['State_Name']; ?> - </span>
                    <span><?php echo $quez['Area_Name']; ?> - </span>
                    <span><?php echo $quez['School_Name'] ?></span>
                </div>
                <div class= "form-control">
                    <h4>أحتياج لمعلميين</h4>
                    <div>
                        <input class= "ms-3" type= "text" name= "type_1" placeholder= "المادة" />
                        <input class= "ms-3" type= "number" name= "num_1" placeholder= "العدد المطلوب" />
                        <input class= "ms-3" type= "text" name= "type_2" placeholder= "المادة" />
                        <input class= "ms-3" type= "number" name= "num_2" placeholder= "العدد المطلوب" />
                    </div>
                    <div>
                        <input class= "ms-3" type= "text" name= "type_3" placeholder= "المادة" />
                        <input class= "ms-3" type= "number" name= "num_3" placeholder= "العدد المطلوب" />
                        <input class= "ms-3" type= "text" name= "type_4" placeholder= "المادة" />
                        <input class= "ms-3" type= "number" name= "num_4" placeholder= "العدد المطلوب" />
                    </div>
                    <div>
                        <input class= "ms-3" type= "text" name= "type_5" placeholder= "المادة" />
                        <input class= "ms-3" type= "number" name= "num_5" placeholder= "العدد المطلوب" />
                        <input class= "ms-3" type= "text" name= "type_6" placeholder= "المادة" />
                        <input class= "ms-3" type= "number" name= "num_6" placeholder= "العدد المطلوب" />
                    </div>
                </div>
                <div class="form-control">
                    <h4>أحتياجات آخري</h4>
                    <textarea name= "another_r" placeholder= "الاحتياجات الاخري"></textarea>
                </div> 
                <input class= "btn btn-primary" type= "submit" name= "quez_0"/>
            </form>

            <?php
        }elseif($do == 'quez1'){ ?>
            <form class= "form-horizontal f_Quez" action="update_qu.php" method= "POST">
                <h1 class= "py-3">طلب أجازة </h1>
                <div class= "form-control">
                    <h2 class= "text-center py-5"> بسم الله الرحمن الرحيم </h2> 
                    <h4 class= "text-start"><?php echo date('y-m-d') ?> </h4>
                </div>
                <div class= "form-control">
                    <input type= "hidden" name= "state_n" value= "<?php echo $quez['State_ID']; ?>">
                    <input type= "hidden" name= "city_n" value= "<?php echo $quez['Area_ID']; ?>">
                    <input type= "hidden" name= "school_n" value= "<?php echo $quez['School_ID']; ?>">
                    <span><?php echo $quez['Person_Name']; ?> - </span>
                    <span><?php echo $quez['State_Name']; ?> - </span>
                    <span><?php echo $quez['Area_Name']; ?> - </span>
                    <span><?php echo $quez['School_Name'] ?></span>
                </div>
                <div class= "form-control">
                    <span>نوع الأجازة</span>
                    <select name= "type_Preak">
                       <option value= "سنوية">سنوية</option>
                       <option value= "بدون مرتب">بدون مرتب</option>
                       <option value= "مرافقة زوج">مرافقة زوج</option>
                       <option value= "وضوع">وضوع</option>
                       <option value= "أمومة">أمومة</option>
                    </select>
                    <input class= "me-5" type= "number" name= "time_q" placeholder= "مدة الأجازة المطلوبة بالايام" />
                </div>
                <div class="form-control">
                    <h4 class= "d-inline-block ms-5">تاريخ البداية<input type= "date" name= "start_q" /></h4>
                    <h4 class= "d-inline-block me-3">تاريخ النهاية<input type= "date" name= "end_q" /></h4>
                </div>
                <div class= "form-control">
                    <input class= "ms-5" type= "text" name= "place_q" placeholder= "العنوان أثناء الأجازة" />
                    <input type= "text" name= "phone_q" placeholder= "رقم الهاتف أثناء الأجازة" />
                </div>
                <div class= "form-control">
                    <textarea name= "ruson_q" placeholder= "سبب طلب الاجازة"></textarea>
                </div> 
                <input class= "btn btn-primary" type= "submit" name= "quez_1" />
            </form>

        <?php 
        }elseif($do == 'quez2'){?>

            <form class= "form-horizontal f_Quez" action="update_qu.php" method= "POST">
                <h1 class= "py-3">طلب تقاعد </h1>   
                <div class= "form-control">
                    <h2 class= "text-center py-5"> بسم الله الرحمن الرحيم </h2> 
                    <h4 class= "text-start"><?php echo date('y-m-d') ?> </h4>
                </div>
                <div class= "form-control">
                    <input type= "hidden" name= "state_n" value= "<?php echo $quez['State_ID']; ?>">
                    <input type= "hidden" name= "city_n" value= "<?php echo $quez['Area_ID']; ?>">
                    <input type= "hidden" name= "school_n" value= "<?php echo $quez['School_ID']; ?>">
                    <span><?php echo $quez['Person_Name']; ?> - </span>
                    <span><?php echo $quez['State_Name']; ?> - </span>
                    <span><?php echo $quez['Area_Name']; ?> - </span>
                    <span><?php echo $quez['School_Name'] ?></span>
                </div>
                <div class= "form-control">
                    <h4 class= "d-inline-block">تاريخ التعيين<input type= "date" name= "date_start" /></h4>
                    <input type= "number" placeholder= "عدد سنين الخدمة" name= "num_serv"/>
                </div>
                <div class= "form-control">
                    <textarea name= "ruson_end" placeholder= "سبب تقديم الطلب"></textarea>
                </div>
                <input class= "btn btn-primary" type= "submit" name= "quez_2" />
            </form>
        <?php
        }elseif($do == 'quez3'){ ?>
            <form class= "form-horizontal f_Quez" action="update_qu.php" method= "POST">
                <h1 class= "py-3">طلب نقل </h1>
                <div class= "form-control">
                    <h2 class= "text-center py-5"> بسم الله الرحمن الرحيم </h2> 
                    <h4 class= "text-start"><?php echo date('y-m-d') ?> </h4>
                </div>
                <div class= "form-control">
                    <input type= "hidden" name= "state_n" value= "<?php echo $quez['State_ID']; ?>">
                    <input type= "hidden" name= "city_n" value= "<?php echo $quez['Area_ID']; ?>">
                    <input type= "hidden" name= "school_n" value= "<?php echo $quez['School_ID']; ?>">
                    <span><?php echo $quez['Person_Name']; ?> - </span>
                    <span><?php echo $quez['State_Name']; ?> - </span>
                    <span><?php echo $quez['Area_Name']; ?> - </span>
                    <span><?php echo $quez['School_Name'] ?></span>
                </div>
                <div class= "form-control">
                    <input type= "text" name= "place_D" placeholder= "مكان الاقامة الدائم" />
                    <input type= "text" name= "place_m" placeholder= "مكان الاقامة المؤقت" />
                    <input type= "number" name= "yaer_q" placeholder= "سنوات الخدمة في المديرية" />
                </div>
                <div class="form-control">
                    <lable>المنطقة التعليمية التي تريد الانتقال اليها</lable>
                    <select name= "city" class= "city">
                        <?php
                            $stmt5= $con->prepare("SELECT * FROM area");
                            $stmt5->execute();
                            $citys = $stmt5->fetchAll();
                            foreach($citys as $city){
                                echo "<option value='" . $city['Area_ID'] . "'>"  . $city['Area_Name'] . "</option>" ;
                            }
                            ?>
                    </select>
                </div>
                <div class= "form-control">
                    <input type= "text" name= "class_q" placeholder= "الفصول التي تدرسها" />
                    <input type= "text" name= "subject_q" placeholder= "المادة التي تدرسها" />
                </div> 
                <div class= "form-control">
                    <textarea name= "ruson_m" placeholder= "سبب الأنتقال"></textarea>
                </div>
                <input class= "btn btn-primary" type= "submit" name= "quez_3" />
            </form>
        <?php 

        }elseif($do == 'quez4'){?>
            <form class= "form-horizontal f_Quez" action="update_qu.php" method= "POST">
                <h1 class= "py-3">طلب تمديد خدمة </h1>   
                <div class= "form-control">
                    <h2 class= "text-center py-5"> بسم الله الرحمن الرحيم </h2> 
                    <h4 class= "text-start"><?php echo date('y-m-d') ?> </h4>
                </div>
                <div class= "form-control">
                    <input type= "hidden" name= "state_n" value= "<?php echo $quez['State_ID']; ?>">
                    <input type= "hidden" name= "city_n" value= "<?php echo $quez['Area_ID']; ?>">
                    <input type= "hidden" name= "school_n" value= "<?php echo $quez['School_ID']; ?>">
                    <span><?php echo $quez['Person_Name']; ?> - </span>
                    <span><?php echo $quez['State_Name']; ?> - </span>
                    <span><?php echo $quez['Area_Name']; ?> - </span>
                    <span><?php echo $quez['School_Name'] ?></span>
                </div>
                <div class= "form-control">
                    <h4 class= "d-inline-block ms-5">تاريخ التعيين الاول<input type= "date" name= "date_start_f" /></h4>
                    <h4 class= "d-inline-block">تاريخ التقاعد<input type= "date" name= "date_end_f" /></h4>
                </div>
                <div class= "form-control">
                    <textarea name= "ruson_end_f" placeholder= "سبب أنهاء الخدمة"></textarea>
                </div>
                <input class= "btn btn-primary" type= "submit" name= "quez_4" />
            </form>
        <?php
        }

        echo '</div>';
    
    
    }



    include $temp . 'footer.php';
    ob_end_flush();
?>