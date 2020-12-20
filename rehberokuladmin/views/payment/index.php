<?php $pm = new PaymentModel(); ?>
<section class="panel">
    <header class="panel-heading">

        <h2 class="panel-title"><?php echo Controller::$title?></h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-tabletools-payment">
            <thead>
            <tr>
                <th>Sıra</th>
                <th>Referans No</th>
                <th>Kullanıcı</th>
                <th>Telefon</th>
                <th>Email</th>
                <th>İşlem Tarihi</th>
                <th>Paket</th>
                <th>Durum</th>
                <th class="center">İşlemler</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($viewModel as $payments) :?>
                <tr>
                    <td class="td-middle"></td>
                    <td class="td-middle"><?php echo $payments['reference_no'];?></td>
                    <td class="td-middle"><?php echo $pm->getUser($payments['user_id'])['first_name'].' '.$pm->getUser($payments['user_id'])['last_name']; ?></td>
                    <td class="td-middle"><?php echo $pm->getUser($payments['user_id'])['phone']; ?></td>
                    <td class="td-middle"><?php echo $pm->getUser($payments['user_id'])['email']; ?></td>
                    <td class="td-middle"><?php echo $payments['payment_time'];?></td>
                    <td class="td-middle"><?php echo $payments['package']; ?></td>
                    <td class="td-middle"><?php echo $payments['state'] == 1 ? 'Onay Bekliyor' : ($payments['state'] == 2 ? 'Onaylandı' : 'İptal Edildi'); ?></td>
                    <td class="center">
                        <a href="<?php echo strtolower(get_class($this));?>/viewApprove/<?php echo $payments['reference_no'].'-'.$payments['school_id'];?>" title="Onayla"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" <?php echo $pm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing'] == 0 || $payments['state']!=1 ? "style='display: none;'" : "";?>><i class="fa fa-check-square"></i></button></a>
                        <a href="<?php echo strtolower(get_class($this));?>/viewCancel/<?php echo $payments['reference_no'].'-'.$payments['school_id'];?>" title="İptal"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-danger" <?php echo $pm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading'] == 0 || $payments['state']!=1 ? "style='display: none;'" : "";?>><i class="fa fa-warning"></i></button></a>
                    </td>
                </tr>
            <?php endforeach;?>


            </tbody>
        </table>
    </div>
</section>
