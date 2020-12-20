<?php $ld = new LandingsModel()?>
<section class="panel">
    <header class="panel-heading">

        <h2 class="panel-title"><?php echo Controller::$title?></h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-tabletools-demand-spesific">
            <thead>
            <tr>
                <th>Sıra</th>
                <th>Sayfa Adı</th>
                <th>Sayfa Title</th>
                <th>Sayfa Description</th>
                <th>Header İçeriği</th>
                <th>Öncelik</th>
                <th class="center">İşlemler</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($viewModel as $landings) :?>
                <tr>
                    <td class="td-middle"><?php echo $landings['id']; ?></td>
                    <td class="td-middle"><?php echo $landings['page_name']; ?></td>
                    <td class="td-middle"><?php echo $landings['page_title']; ?></td>
                    <td class="td-middle"><?php echo $landings['page_description'];?></td>
                    <td class="td-middle"><?php echo $landings['header_content'];?></td>
                    <td class="td-middle"><?php echo $landings['priority'];?></td>
                    <td class="center">
                        <a href="<?php echo strtolower(get_class($this));?>/landingViewEdit/<?php echo $landings['id'];?>" title="Düzenle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info" <?php echo $ld->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-edit"></i></button></a>

                    </td>
                </tr>
            <?php endforeach;?>

            </tbody>
        </table>

    </div>
</section>
