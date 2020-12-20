<?php $dm = new DemandsModel();?>
<section class="panel">
    <header class="panel-heading">

        <h2 class="panel-title"><?php echo Controller::$title?></h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-tabletools-demands">
            <thead>
            <tr>
                <th>Sıra</th>
                <th>İsim - Email</th>
                <th>Telefon</th>
                <th>Okul Türü</th>
                <th>Okul</th>
                <th>Tarih</th>
                <th>Not</th>
                <th class="center">İşlemler</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($viewModel as $demands) :?>
                <tr>
                    <td class="td-middle"></td>
                    <td class="td-middle"><?php echo $dm->hideAllDetails($dm->getUser($demands['user_id'])['first_name'].' '.$dm->getUser($demands['user_id'])['last_name'].'<br>'.$dm->getUser($demands['user_id'])['email']); ?></td>
                    <td class="td-middle"><?php echo $dm->hideAllDetails($dm->getUser($demands['user_id'])['phone']); ?></td>
                    <td class="td-middle"><?php echo $dm->getSchoolTypeBySchoolId($demands['school_id']); ?></td>
                    <td class="td-middle"><?php echo $dm->getSchool($demands['school_id']); ?></td>
                    <td class="td-middle"><?php $date = new DateTime($demands['end_date']); echo $date->format('Y-m-d'); ?></td></td>
                    <td class="td-middle" style="width: 20%;"><?php echo $demands['note']; ?></td>
                    <td class="td-middle center">
                        <a href="<?php echo strtolower(get_class($this));?>/interestSpesific/<?php echo $demands['link'];?>" title="Taleple İlgilen"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" <?php echo $dm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-check"></i></button></a>
                        <a href="<?php echo strtolower(get_class($this));?>/detailSpesific/<?php echo $demands['link'];?>" title="Görüntüle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-warning" <?php echo $dm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-search"></i></button></a>
                    </td>
                </tr>
            <?php endforeach;?>

            </tbody>
        </table>
    </div>
</section>
