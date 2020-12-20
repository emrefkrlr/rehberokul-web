<?php $bm = new BlogModel(); ?>
<section class="panel">
    <header class="panel-heading">

        <h2 class="panel-title"><?php echo Controller::$title?></h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-tabletools-comment">
            <thead>
            <tr>
                <th>Sıra</th>
                <th>Gönderen</th>
                <th>Email</th>
                <th>Yazı Başlığı</th>
                <th>Yayınlanma Tarihi</th>
                <th>Durum</th>
                <th class="center">İşlemler</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($viewModel as $comments) :?>
                <tr>
                    <td class="td-middle"></td>
                    <td class="td-middle"><?php echo $bm->getCommentator($comments['commentator'])['first_name'].' '.$bm->getCommentator($comments['commentator'])['last_name']; ?></td>
                    <td class="td-middle"><?php echo $bm->getCommentator($comments['commentator'])['email']; ?></td>
                    <td class="td-middle"><?php echo $bm->getBlogName($comments['blog_id']); ?></td>
                    <td class="td-middle"><?php echo $comments['publish_date'];?></td>
                    <td class="td-middle"><?php echo $comments['state'] == 1 ? 'Aktif' : 'Pasif'; ?></td>
                    <td class="center">
                        <a href="<?php echo strtolower(get_class($this));?>/viewEditComment/<?php echo $comments['link'];?>" title="Düzenle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info" <?php echo $bm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-edit"></i></button></a>
                        <a href="<?php echo strtolower(get_class($this));?>/detailComment/<?php echo $comments['link'];?>" title="Görüntüle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-warning" <?php echo $bm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-search"></i></button></a>
                        <a href="<?php echo strtolower(get_class($this));?>/viewDeleteComment/<?php echo $comments['link'];?>" title="Sil"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-danger" <?php echo $bm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-trash"></i></button></a>
                    </td>
                </tr>
            <?php endforeach;?>

            </tbody>
        </table>

    </div>
</section>
