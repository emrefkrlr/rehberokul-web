<?php
    require_once('php/Core.php');
    $pageTitle = "Rehber Blog | Rehber Okul";
    $pageDescription = "Çocuğunuzun gelişimi için sizlere rehber olacak yazılarımızı hemen oku! Kendini ve çocuğunu yeniden keşfet.";
    $pageKeywords = "rehber okul";
    $pageSocialImagePath = "images/rehberokul/rehber-okul.jpg";
    $twitterUsername = "rehberokul";
    $pageUrl = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (SUBFOLDER){
    $robotsStatus = "noindex, nofollow";
}else{
    $robotsStatus = "index, follow";
}


$getCategoryCount = $db->query("SELECT tag.name, COUNT(tag.name) as count, tag.link FROM `blog_tags`join tag on tag.id = blog_tags.tag_id GROUP BY tag.name, tag.link");
$getPopulerArticles = $db->query("SELECT * FROM blog where id in (SELECT blog_id FROM comment WHERE blog_id <> 0 )");
$crumbs = explode("/",$_SERVER["REQUEST_URI"]);
$delete_first = array_shift($crumbs);



?>
<!DOCTYPE html>
<html lang="tr">
<head>
	<?php require_once('php/Components/SEO.php'); ?>
	<link href="https://fonts.googleapis.com/css?family=Poppins%7CQuicksand:500,700" rel="stylesheet">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link href="css/materialize.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
	<link href="css/responsive.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css"/>
	<link href="css/custom.css" rel="stylesheet">
    <script src="js/login.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/autcomplete-custom.js"></script>
<?php require_once('php/Components/Scripts.php'); ?></head>
<body>
	<?php require_once('php/Components/Header-Part-1.php'); ?>
		<div class="container xxs-py">
			<div class="row">
				<div class="dir-hr1">
					<div class="dir-ho-t-tit">
						<p class="h1">Rehber Blog</p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php require_once('php/Components/Header-Part-2.php'); ?>
    <?php
    function turkcetarih_formati($format, $datetime = 'now'){
        $z = date("$format", strtotime($datetime));
        $gun_dizi = array(
            'Monday'    => 'Pazartesi',
            'Tuesday'   => 'Salı',
            'Wednesday' => 'Çarşamba',
            'Thursday'  => 'Perşembe',
            'Friday'    => 'Cuma',
            'Saturday'  => 'Cumartesi',
            'Sunday'    => 'Pazar',
            'January'   => 'Ocak',
            'February'  => 'Şubat',
            'March'     => 'Mart',
            'April'     => 'Nisan',
            'May'       => 'Mayıs',
            'June'      => 'Haziran',
            'July'      => 'Temmuz',
            'August'    => 'Ağustos',
            'September' => 'Eylül',
            'October'   => 'Ekim',
            'November'  => 'Kasım',
            'December'  => 'Aralık',
            'Mon'       => 'Pts',
            'Tue'       => 'Sal',
            'Wed'       => 'Çar',
            'Thu'       => 'Per',
            'Fri'       => 'Cum',
            'Sat'       => 'Cts',
            'Sun'       => 'Paz',
            'Jan'       => 'Oca',
            'Feb'       => 'Şub',
            'Mar'       => 'Mar',
            'Apr'       => 'Nis',
            'Jun'       => 'Haz',
            'Jul'       => 'Tem',
            'Aug'       => 'Ağu',
            'Sep'       => 'Eyl',
            'Oct'       => 'Eki',
            'Nov'       => 'Kas',
            'Dec'       => 'Ara',
        );
        foreach($gun_dizi as $en => $tr){
            $z = str_replace($en, $tr, $z);
        }
        if(strpos($z, 'Mayıs') !== false && strpos($format, 'F') === false) $z = str_replace('Mayıs', 'May', $z);
        return $z;
    }
    $blogHCountFor5 = 0;
    $db->orderBy("publish_date","desc");
    $allPosts = $db->get('blog');

    if (isset($_GET['sayfa'])) {
        $pageNumber = $_GET['sayfa'];
    } else {
        $pageNumber = 1;
    }
    $pageLimit = 5;
    if ($pageNumber) {
        $startPoint = (($pageNumber - 1) * $pageLimit);
    }
    $postByPage = array_slice($allPosts, $startPoint, $pageLimit);
    ?>

    <section class="bread-crumb">
        <div class="row">
            <div class="container">
                <ul class="breadcrumb">
                    <?php
                    $path = WEBURL;
                    $i = 1;

                    foreach ($crumbs as $crumb){
                        if ($i !=1 && count($crumbs) > 1) {
                            $path .= '/'.$crumb;
                        }else{
                            $path .= $crumb;
                        }
                        $i++;
                        echo '
                            <li>
                                <a href="'.$path.'">
                                    '.ucfirst(str_replace(array(".php","_", "-", "="),array(""," ", " ", "/"),$crumb)).'
                                </a>
                            </li>
                        ';
                    }
                    ?>
                </ul>

            </div>
        </div>

    </section>

	<section class="p-about com-padd">
		<div class="container">
            <div class="row">
                <div class="col-md-8">
                    <?php if ($db->count > 0):?>
                    <?php foreach ($postByPage as $singlePost): ?>
                        <div class="row blog-single">
                            <div class="col-md-4">
                                <div class="blog-img">
                                    <img src="<?php echo str_replace("../", "", $singlePost['photo']);?>" alt="">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="page-blog">
                                    <h2><?php echo $singlePost['title'];?></h2>
                                    <p><?php echo $singlePost['description'] ;?></p>
                                    <p class="xxs-pt">
                                        <i class="fa fa-user"></i> Rehber Blog | <i class="fa fa-calendar"></i> <?php echo turkcetarih_formati('j F Y',$singlePost['publish_date']); ?>
                                    </p>
                                    <a class="waves-effect waves-light btn-large full-btn" style="height: 30px; line-height: 30px;text-transform: none;" href="<?php echo WEBURL.'rehber-blog/'.$singlePost['link'];?>">Devamını Oku</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                    <?php endif;?>
                </div>

                <div class="col-md-4">
                    <div class="pglist-p3 pglist-bg pglist-p-com okulun-ozellikleri">
                        <div class="pglist-p-com-ti pglist-p-com-ti-right">
                            <h3>Populer Yazılar</h3>
                        </div>
                        <div class="list-pg-inn-sp">
                            <div class="list-pg-oth-info">
                                <ul>
                                    <?php foreach ($getPopulerArticles as $article): ?>
                                        <li>
                                            <a href="<?php echo WEBURL.'rehber-blog/'.$article['link'] ;?>">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <img src="<?php echo str_replace("../", "", $article['photo']); ?>" alt="" style="width: 100%;" />
                                                    </div>
                                                    <div class="col-md-8">
                                                        <h6><?php echo $article['title'] ; ?></h6>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="float-left blog-info" style="font-size: 12px">
                                                            <i class="fa fa-user"></i> <b>Rehber Blog</b> | <i class="fa fa-calendar"></i> <b><?php echo turkcetarih_formati('j F Y',$article['publish_date']) ;?></b>
                                                        </div>
                                                        <!--<div class="float-right blog-info" style="font-size: 12px">
                                                        <i class="fa fa-comment"></i> <?php /*echo $getRelatedBlogCommentsCount[0]['count'] */?>
                                                    </div>-->
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="pglist-p3 pglist-bg pglist-p-com okulun-ozellikleri">
                        <div class="pglist-p-com-ti pglist-p-com-ti-right">
                            <h3>Kategoriler</h3>
                        </div>
                        <div class="list-pg-inn-sp">
                            <div class="list-pg-oth-info">
                                <ul>
                                    <?php foreach ($getCategoryCount as $singleCategory): ?>
                                        <?php if ($singleCategory['link'] <> $category): ?>
                                            <li>
                                                <a href="<?php echo WEBURL.'kategori/'.$singleCategory['link']?>">
                                                    <div class="row">
                                                        <div class="col-md-10 blog-category-list">
                                                            <i class="fa fa-caret-right"></i> <?php echo $singleCategory['name'];?>
                                                        </div>
                                                        <div class="col-md-2 float-right blog-category-list">
                                                            <?php echo $singleCategory['count']; ?>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <ul class="pagination list-pagenat">
                    <?php
                        if (count($allPosts) > 0) {
                            $totalPage = ceil(count($allPosts) / $pageLimit);
                            if ($totalPage != 1) {
                                if ($pageNumber != 1) {
                                    echo '<li class="waves-effect"><a class="page-link" href="'.WEBURL.'rehber-blog/sayfa/'.($pageNumber-1).'"><i class="fa fa-angle-left"></i></a></li>';
                                }
                                if ($pageNumber == 1 || $pageNumber == 2 || $pageNumber == 3) {
                                    for ($i=1; $i <= 7; $i++) {
                                        if ($i <= $totalPage) {
                                            echo '<li class="waves-effect';
                                            if ($pageNumber == $i) {
                                                echo ' active';
                                            }
                                            echo '"><a class="page-link" href="'.WEBURL.'rehber-blog/sayfa/'.$i.'">'.$i.'</a></li>';
                                        }
                                    }
                                } else if ($pageNumber == $totalPage || $pageNumber == $totalPage-1 || $pageNumber == $totalPage-2) {
                                    for ($i=$totalPage-6; $i <= $totalPage; $i++) {
                                        if ($i <= $totalPage && $i!=0) {
                                            echo '<li class="waves-effect';
                                            if ($pageNumber == $i) {
                                                echo ' active';
                                            }
                                            echo '"><a class="page-link" href="'.WEBURL.'rehber-blog/sayfa/'.$i.'">'.$i.'</a></li>';
                                        }
                                    }
                                } else {
                                    for ($i=($pageNumber-3); $i <= ($pageNumber+3); $i++) {
                                        if ($i > 0 && $i <= $totalPage) {
                                            if ($i <= $totalPage) {
                                                echo '<li class="waves-effect';
                                                if ($pageNumber == $i) {
                                                    echo ' active';
                                                }
                                                echo '"><a class="page-link" href="'.WEBURL.'rehber-blog/sayfa/'.$i.'">'.$i.'</a></li>';
                                            }
                                        }
                                    }
                                }
                                if ($pageNumber != $totalPage) {
                                    echo '<li class="waves-effect"><a class="page-link" href="'.WEBURL.'rehber-blog/sayfa/'.($pageNumber+1).'"><i class="fa fa-angle-right"></i></a></li>';
                                }
                            }
                        }
                    ?>
                </ul>
            </div>
		</div>
	</section>

	<?php require_once('php/Components/Footer.php'); ?>
	<script src="js/bootstrap.js" type="text/javascript"></script>
	<script src="js/materialize.min.js" type="text/javascript"></script>
	<script src="js/custom.js"></script>
	<script src="js/rehberokul.js"></script>
</body>

</html>