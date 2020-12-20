<?php $um = new UserModel();?>
<section class="panel">
    <header class="panel-heading">

        <h2 class="panel-title"><?php echo Controller::$title?></h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-tabletools">
            <thead>
            <tr>
                <th>Sıra</th>
                <th>İsim</th>
                <th>Email</th>
                <th>Telefon</th>
                <th>Son Giriş</th>
                <th>Aktiflik</th>
                <th class="center">İşlemler</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($viewModel as $users) :?>
                <tr>
                    <td class="td-middle"></td>
                    <td class="td-middle"><?php echo $users['first_name'].' '.$users['last_name']; ?></td>
                    <td class="td-middle"> <?php echo $users['email']; ?></td>
                    <td class="td-middle"> <?php echo $users['phone']; ?></td>
                    <td class="td-middle"> <?php echo $users['last_login_date']; ?></td>
                    <td class="td-middle"> <?php echo $users['is_active'] ? 'Aktif' : 'Pasif' ?></td>
                    <td class="center">
                        <a href="<?php echo strtolower(get_class($this));?>/viewEdit/<?php echo $users['link'];?>" title="Düzenle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info" <?php echo $um->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-edit"></i></button></a>
                        <a href="<?php echo strtolower(get_class($this));?>/detail/<?php echo $users['link'];?>" title="Görüntüle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-warning" <?php echo $um->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-search"></i></button></a>
                        <a href="<?php echo strtolower(get_class($this));?>/viewDelete/<?php echo $users['link'];?>" title="Sil"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-danger" <?php echo $um->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-trash"></i></button></a>
                    </td>
                </tr>
            <?php endforeach;?>


            </tbody>
        </table>

    </div>
</section>
