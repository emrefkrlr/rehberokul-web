<?php $dm = new DemandsModel();?>
<section class="panel">
    <header class="panel-heading">

        <h2 class="panel-title"><?php echo Controller::$title?></h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-tabletools-demand-spesific">
            <thead>
            <tr>
                <th>Sıra</th>
                <th>İsim - Email</th>
                <th>Telefon</th>
                <th>Kota</th>
                <th>Not</th>
                <th class="center">İşlemler</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($viewModel as $demands) :?>
                <tr>
                    <td class="td-middle"></td>
                    <td class="td-middle"><?php echo $demands['user_id'] != 0 ? $dm->getUser($demands['user_id'])['first_name'].' '.$dm->getUser($demands['user_id'])['last_name'].'<br>'.$dm->getUser($demands['user_id'])['email'] : $demands['full_name']; ?></td>
                    <td class="td-middle"><?php echo $demands['user_id'] != 0 ? $dm->getUser($demands['user_id'])['phone'] : $demands['phone']; ?></td>
                    <td class="td-middle"><?php echo $demands['quota']; ?></td>
                    <td class="td-middle"><?php echo $demands['note']; ?></td>
                    <td class="center">
                        <a href="<?php echo strtolower(get_class($this));?><?php echo $demands['school_id'] == 0 ? '/detailInterested/' : '/detailSpesificInterested/'?><?php echo $demands['link'];?>" title="Görüntüle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-warning" <?php echo $dm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-search"></i></button></a>
                    </td>
                </tr>
            <?php endforeach;?>

            </tbody>
        </table>
    </div>
</section>
