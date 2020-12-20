<?php $em = new EmailModel();?>
<section class="panel">
    <header class="panel-heading">

        <h2 class="panel-title"><?php echo Controller::$title?></h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-tabletools-cat">
            <thead>
            <tr>
                <th>Sıra</th>
                <th>Mail Başlığı</th>
                <th class="center">İşlemler</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($viewModel as $emails) :?>
                <tr>
                    <td class="td-middle"></td>
                    <td class="td-middle"><?php echo $emails['title']; ?></td>
                    <td class="center">
                        <a href="<?php echo strtolower(get_class($this));?>/viewSend/<?php echo $emails['link'];?>" title="Toplu Gönder"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" <?php echo $em->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing'] == 0 || $emails['deletable'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-send"></i></button></a>
                        <a href="<?php echo strtolower(get_class($this));?>/copy/<?php echo $emails['link'];?>" title="Kopyala"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-primary" <?php echo $em->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-copy"></i></button></a>
                        <a href="<?php echo strtolower(get_class($this));?>/preview/<?php echo $emails['link'];?>" title="Test Gönderi"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-primary" <?php echo $em->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-send-o"></i></button></a>
                        <a href="<?php echo strtolower(get_class($this));?>/viewEdit/<?php echo $emails['link'];?>" title="Düzenle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info" <?php echo $em->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing'] == 0 || ($emails['deletable'] == 0 && $_SESSION['user_data']['super'] == 0) ? "style='display: none;'" : "";?>><i class="fa fa-edit"></i></button></a>
                        <a href="<?php echo strtolower(get_class($this));?>/detail/<?php echo $emails['link'];?>" title="Görüntüle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-warning" <?php echo $em->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-search"></i></button></a>
                        <a href="<?php echo strtolower(get_class($this));?>/viewDelete/<?php echo $emails['link'];?>" title="Sil"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-danger" <?php echo $em->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting'] == 0 || $emails['deletable'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-trash"></i></button></a>
                    </td>
                </tr>
            <?php endforeach;?>


            </tbody>
        </table>
        <div class="center" <?php echo $em->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding'] == 0 ? "style='display: none;'" : "";?>>
            <a href="<?php echo strtolower(get_class($this)).'/viewAdd/';?>"><button type="button" class="btn btn-primary">Yeni Mail Şablonu Ekle</button></a>
        </div>
    </div>
</section>
