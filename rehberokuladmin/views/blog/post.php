<?php $pm = new BlogModel();?>
<section class="panel">
    <header class="panel-heading">

        <h2 class="panel-title"><?php echo Controller::$title?></h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-tabletools-blogpost">
            <thead>
            <tr>
                <th>Sıra</th>
                <th>Başlık</th>
                <th>Kategori</th>
                <th>Yayınlanma Tarihi</th>
                <th class="center">İşlemler</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($viewModel as $posts) :?>
                <tr>
                    <td class="td-middle"></td>
                    <td class="td-middle"><?php echo $posts['title']; ?></td>
                    <td class="td-middle"> <?php echo $pm->getBlogTags($posts['id']); ?></td>
                    <td class="td-middle"> <?php $date = new DateTime($posts['publish_date']); echo $date->format('Y-m-d'); ?></td>
                    <td class="center">
                        <a href="<?php echo strtolower(get_class($this));?>/viewEdit/<?php echo $posts['link'];?>" title="Düzenle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info" <?php echo $pm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-edit"></i></button></a>
                        <a href="<?php echo strtolower(get_class($this));?>/detail/<?php echo $posts['link'];?>" title="Görüntüle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-warning" <?php echo $pm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-search"></i></button></a>
                        <a href="<?php echo strtolower(get_class($this));?>/viewDelete/<?php echo $posts['link'];?>" title="Sil"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-danger" <?php echo $pm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-trash"></i></button></a>
                    </td>
                </tr>
            <?php endforeach;?>


            </tbody>
        </table>
        <div class="center" <?php echo $pm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding'] == 0 ? "style='display: none;'" : "";?>>
            <a href="<?php echo strtolower(get_class($this)).'/viewAdd/';?>"><button type="button" class="btn btn-primary">Yeni Yazı Ekle</button></a>
        </div>
    </div>
</section>
