<!DOCTYPE html>
<?php include ("./controller/main.php");?>
<?php 
?>
<html class="no-js" lang="<?=$lang?>">

<head>
    <?php sectionhead($db)?>
</head>

<body>
    <?php sectiontopbar($trans);?>

    <?php sectionheader($db, 0, $trans); ?>

    <?php sectionbreadcrumb("|faq", $trans);?>

    <div class="section section-padding pb-0">
        <div class="container">
            <div class="row row-cols-lg-2 row-cols-1 learts-mb-n40">

                <div class="col learts-mb-40">
                    <div class="section-title2">
                        <h2 class="title"><?=$trans['faq_group1_title']?></h2>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="accordion" id="faq-accordion">
                                <div class="card active">
                                    <div class="card-header">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#faq-accordion-1"><?=$trans['faq_group1_btn1']?></button>
                                    </div>

                                    <div id="faq-accordion-1" class="collapse show" data-parent="#faq-accordion">
                                        <div class="card-body">
                                            <p><?=$trans['faq_group1_text1']?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#faq-accordion-2"><?=$trans['faq_group1_btn2']?></button>
                                    </div>

                                    <div id="faq-accordion-2" class="collapse" data-parent="#faq-accordion">
                                        <div class="card-body">
                                            <p><?=$trans['faq_group1_text2']?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#faq-accordion-3"><?=$trans['faq_group1_btn3']?></button>
                                    </div>

                                    <div id="faq-accordion-3" class="collapse" data-parent="#faq-accordion">
                                        <div class="card-body">
                                            <p><?=$trans['faq_group1_text3']?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col learts-mb-40">
                    <div class="section-title2">
                        <h2 class="title"><?=$trans['faq_group2_title']?></h2>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="accordion" id="faq-accordion2">
                                <div class="card active">
                                    <div class="card-header">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#faq-accordion-5"><?=$trans['faq_group2_btn1']?></button>
                                    </div>

                                    <div id="faq-accordion-5" class="collapse show" data-parent="#faq-accordion2">
                                        <div class="card-body">
                                            <p><?=$trans['faq_group2_text1']?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#faq-accordion-6"><?=$trans['faq_group2_btn2']?></button>
                                    </div>

                                    <div id="faq-accordion-6" class="collapse" data-parent="#faq-accordion2">
                                        <div class="card-body">
                                            <p><?=$trans['faq_group2_text2']?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#faq-accordion-7"><?=$trans['faq_group2_btn3']?></button>
                                    </div>

                                    <div id="faq-accordion-7" class="collapse" data-parent="#faq-accordion2">
                                        <div class="card-body">
                                            <p><?=$trans['faq_group2_text3']?></p>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php sectioncookies($trans);?>
    <?php sectionfooter($trans);?>

    <?php sectionjs();?>
</body>