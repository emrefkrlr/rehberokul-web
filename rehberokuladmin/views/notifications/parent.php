<?php $nm = new NotificationsModel(); ?>

<section class="panel">

    <div class="panel-body">
        <?php if ($viewModel) :?>
            <?php foreach ($viewModel as $notifications) :?>
                <?php
                if($notifications['type'] == 'announcement') {
                    $date = new DateTime($notifications['end_date']);
                }
                if($notifications['type'] == '0') {
                    $nm->findByColumn('school_owner', 'user_id', $notifications['interested_user']);
                    $schoolIds = $nm->resultSet();
                    $result = '';
                    for($i = 0; $i < count($schoolIds); $i++) {
                        $nm->findByColumn('school', 'id', $schoolIds[$i]['school_id']);
                        $school = $nm->single();
                        if($notifications['school_type'] == $school['type']) {
                            $result = '( '.$result.$school['name'].' ) ';
                        }
                    }
                }
                if($notifications['type'] == 'school') {
                    $result = '';
                    $nm->findByColumn('school', 'id', $notifications['school_id']);
                    $school = $nm->single();
                    $result = '( '.$result.$school['name'].' ) ';
                }


                ?>
                <div class="p-lg row">
                    <div class="panel-heading-icon col-md-2" <?php echo $notifications['as_read'] == 0 ? 'style="background-color: rgba(28,169,255,0.42);"' : '';?>>
                        <i class="<?php echo $notifications['type'] == 'notification' ? 'fa fa-bell-o' : ($notifications['type'] == 'announcement' ? 'fa fa-bullhorn' : 'fa fa-reply');?>" style="height: 10px;"></i>
                    </div>
                    <div class="col-md-10" style="<?php echo $notifications['as_read'] == 0 ? 'background-color: rgba(28,169,255,0.42);' : '';?>margin-left: 10px;">
                        <div class="col-md-12">
                            <h3 class="text-weight-semibold mt-sm col-md-12">
                                <?php echo $notifications['type'] == 'notification' ? 'Yeni Bildirim! '.$notifications['title'] : ($notifications['type'] == 'announcement' ? 'Yeni Duyuru! '.$notifications['title'] :$notifications['title'])  ; ?>
                            </h3>
                            <p class="col-md-12"><?php echo $notifications['type'] == 'notification' ? $notifications['content'] : ($notifications['type'] == 'announcement' ?  $notifications['content'].' Bitiş Tarihi : '.$date->format('Y-m-d') : $result.$notifications['content'])   ; ?></p>
                        </div>
                        <div class="col-md-12">
                            <h6 class="col-md-3"><?php echo $notifications['publish_date'];?></h6>
                            <a class="col-md-3" <?php echo $notifications['type'] == 'notification' ? '' : ($notifications['type'] == '0' ? 'href="'.ROOT_URL.'demand/detailParentDemand/'.$notifications['link'].'"' : 'href="'.ROOT_URL.'demand/detailParentDemandSpesific/'.$notifications['link'].'"') ;?>>
                                <h6>
                                    <?php echo $notifications['type'] == 'school' ? 'Talebe Git!' : ($notifications['type'] == '0' ? 'Talebe Git!' : '') ;?>
                                </h6>
                            </a>
                            <?php echo $notifications['as_read'] == 0 ? '
                            <a class="col-md-3" style="cursor: pointer;" onclick="mark_as_read('.$notifications['id'].')">
                                <h6>
                                    Okundu Olarak İşaretle
                                </h6>
                            </a>' : '
                            <a class="col-md-3" style="cursor: pointer;" onclick="mark_as_unread('.$notifications['id'].')">
                                <h6>
                                    Okunmadı Olarak İşaretle
                                </h6>
                            </a>'; ?>
                            <a class="col-md-3" onclick="delete_notification(<?php echo $notifications['id'] ;?>)"; style="text-decoration: none; color: darkred; cursor: pointer;">
                                <h6>
                                    Kaldır
                                </h6>
                            </a>
                        </div>
                    </div>

                </div>
                <hr>
            <?php endforeach;?>
        <?php endif;?>

        <?php if (!$viewModel) :?>
            <div class="p-lg row">
                <div class="panel-heading-icon col-md-2">
                    <i class="fa fa-question-circle" style="height: 10px;"></i>
                </div>
                <div class="col-md-10">
                    <div class="col-md-12">
                        <h3 class="text-weight-semibold mt-sm col-md-12">
                            Bildiriminiz Bulunmamaktadır!
                        </h3>
                    </div>
                </div>
            </div>
        <?php endif;?>

    </div>
</section>
