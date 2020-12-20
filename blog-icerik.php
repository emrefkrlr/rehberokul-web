<?php
    require_once('php/Core.php');
if (SUBFOLDER){
    $robotsStatus = "noindex, nofollow";
}else{
    $robotsStatus = "index, follow";
}


    $crumbs = explode("/",$_SERVER["REQUEST_URI"]);
    $delete_first = array_shift($crumbs);

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
    if (isset($_GET['yaziSeflink'])) {
        $yaziSeflink = $_GET['yaziSeflink'];
        $db->where("link", $yaziSeflink);
        $singlePost = $db->getOne("blog");
        $blogId = ($singlePost['id']);
        $getTagIDS = $db->query("SELECT tag_id FROM blog_tags where blog_id = $blogId ");
        $tagIDS = array();
        $singlePostCommentCount = $db->query('SELECT count(id) as count from comment where blog_id = '. $blogId . '');
        foreach ($getTagIDS as $id){
            array_push($tagIDS, $id['tag_id']);
        }
        $getRelatedBlogIdsByTagId = $db->query("SELECT DISTINCT(blog_id) from blog_tags where tag_id IN (SELECT DISTINCT (tag_id) FROM blog_tags where blog_id = $blogId ) ORDER BY blog_id DESC LIMIT 5  ");
        $getRelatedBlogCommentsCount = $db->query("SELECT count(id) from comment where blog_id IN ('.$getRelatedBlogIdsByTagId.')");
        $getCategoryCount = $db->query("SELECT tag.name, COUNT(tag.name) as count, tag.link FROM `blog_tags`join tag on tag.id = blog_tags.tag_id GROUP BY tag.name, tag.link");

        if ($singlePost) {
            $pageTitle = $singlePost['title'];
            $pageDescription = $singlePost['description'];
            $postId = $singlePost['id'];
            $pageContent = $singlePost['content'];
            $postPhoto = str_replace("../", "", $singlePost['photo']);
            $postDate = turkcetarih_formati('j F Y',$singlePost['publish_date']);
        } else {
            header("Location: ".WEBURL);
        }
    } else {
        header("Location: ".WEBURL);
    }
    $pageKeywords = "rehber okul";
    $pageSocialImagePath = "images/rehberokul/rehber-okul.jpg";
    $twitterUsername = "rehberokul";
    $pageUrl = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
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
                    <h1> <?php echo $pageTitle; ?></h1>
                </div>
            </div>
        </div>
    </div>
	</section>
	<?php require_once('php/Components/Header-Part-2.php'); ?>

    <section class="bread-crumb">
        <div class="row">
            <div class="container">
                <ul class="breadcrumb">
                    <?php
                    $path = WEBURL;
                    $i = 1;
                    foreach ($crumbs as $crumb){
                        if ($i !=1 && count($crumbs) > 1){
                            $path .= '/'.$crumb;
                        }else{
                            $path .= $crumb;
                        }
                        $i++;
                        echo '
                            <li>
                                <a href="'.$path.'">
                                    '.ucfirst(str_replace(array(".php","_", "-"),array(""," ", " "),$crumb)).'
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
			<div class="row blog-single con-com-mar-bot-o">
				<div class="col-md-8">
					<img src="<?php echo $postPhoto; ?>" alt="" style="width: 100%;" />
					<div class="page-blog">
						<h3 style="margin-top: 20px;"><?php echo $pageTitle; ?></h3>
						<p class="xxs-pt"><i class="fa fa-user"></i> <b>Rehber Blog</b> | <i class="fa fa-calendar"></i> <b><?php echo $postDate; ?></b> | <i class="fa fa-comment"></i> <?php echo $singlePostCommentCount[0]['count']; ?> </p></p>
						<div class="share-btn share-pad-bot" style="margin-top: 20px;">
							<ul>
								<li><a href="https://www.facebook.com/sharer.php?u=<?php echo $pageUrl; ?>" target="_blank"><i class="fa fa-facebook fb1"></i> Facebook'da Paylaş</a> </li>
								<li><a href="https://twitter.com/share?url=<?php echo $pageUrl; ?>&text=<?php echo $pageTitle; ?>" target="_blank"><i class="fa fa-twitter tw1"></i> Twitter'da Paylaş</a> </li>
								<li><a href="https://api.whatsapp.com/send?text=<?php echo $pageTitle; ?> <?php echo $pageUrl; ?>" target="_blank"><i class="fa fa-whatsapp wa1"></i> WhatsApp İle Paylaş</a> </li>
							</ul>
						</div>
						<div class="xxs-py">
                            <p class="blog-content">
                                <?php echo htmlspecialchars_decode($pageContent); ?>
                            </p>

						</div>
						<div class="pglist-p3 pglist-bg pglist-p-com">
							<div class="pglist-p-com-ti blog-comment">
								<h3><span>Yorum Yap</span></h3> </div>
                            <div class="list-pg-inn-sp">
                                <div class="list-pg-write-rev">
                                    <form id="blog-form" class="col-md-12">
                                        <p>Bu yazıyla ilgili görüşlerini bu form aracılığı ile yazabilirsin</p>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <textarea id="re_msg" name="comment" class="materialize-textarea"></textarea>
                                                <label for="re_msg">Yorumun</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <input type="hidden" name="comment_url" value="<?php echo $pageUrl;?>">
                                            <input type="hidden" name="blog" value="<?php echo $postId;?>">
                                            <div class="input-field col s12"> <button type="button" class="waves-effect waves-light btn-large full-btn" onclick="comment_blog()">Gönder</button> </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
<?php
	$db->orderBy("publish_date","desc");
	$db->where('state', 1);
	$db->where("blog_id",$postId);
	$comments = $db->get('comment');
	if ($db->count > 0) {
		echo '<div class="pglist-p3 pglist-bg pglist-p-com" id="ld-rer">
								<div class="list-pg-inn-sp">
									<div class="lp-ur-all-rat">
										<h5>Yorumlar</h5>
										<ul>';
	    foreach ($comments as $singleComment) {
	        $db->where('id', $singleComment['commentator']);
	        $commentator = $db->getOne('user');
	    	echo '<li>
					<div class="lr-user-wr-con">
						<h6>'.$commentator['first_name'].' '.$commentator['last_name'].'</h6> <span class="lr-revi-date">'.turkcetarih_formati('j F Y',$singleComment['publish_date']).'</span>
						<p>'.$singleComment['comment'].'</p>
					</div>
				</li>';
		}
		echo '</ul></div></div></div>';
	}
?>			
						</div>
					</div>
				</div>
                <div class="col-md-4">
                    <div class="pglist-p3 pglist-bg pglist-p-com okulun-ozellikleri">
                        <div class="pglist-p-com-ti pglist-p-com-ti-right">
                            <h3>Alakalı Yazılar</h3>
                        </div>
                        <div class="list-pg-inn-sp">
                            <div class="list-pg-oth-info">
                                <ul>
                                    <?php
                                        foreach ($getRelatedBlogIdsByTagId as $relatedBlogId){
                                            if ($blogId <> $relatedBlogId['blog_id']){
                                                $db->where("id", $relatedBlogId['blog_id']);
                                                $singlePost = $db->getOne("blog");
                                                $getRelatedBlogCommentsCount = $db->query('SELECT count(id) as count from comment where blog_id = '. $relatedBlogId['blog_id'] . '');
                                                echo '
                                                <li>
                                                    <a href="'.WEBURL.'rehber-blog/'.$singlePost['link'].'">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <img src="'. str_replace("../", "", $singlePost['photo']) . '" alt="" style="width: 100%;" />
                                                            </div>
                                                            <div class="col-md-8">
                                                                <h6>'. $singlePost['title'] . '</h6>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="float-left blog-info" style="font-size: 12px">
                                                                    <i class="fa fa-user"></i> <b>Rehber Blog</b> | <i class="fa fa-calendar"></i> <b>'.turkcetarih_formati('j F Y',$singlePost['publish_date']).'</b>
                                                                </div>
                                                                <div class="float-right blog-info" style="font-size: 12px">
                                                                    <i class="fa fa-comment"></i>  '. $getRelatedBlogCommentsCount[0]['count'] .'
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                ';
                                            }
                                        }
                                    ?>
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
                                    <?php
                                    foreach ($getCategoryCount as $category){
                                        echo '
                                        <li>
                                        <a href="'.WEBURL.'kategori/'.$category['link'].'">
                                            <div class="row">
                                                <div class="col-md-10 blog-category-list">
                                                    <i class="fa fa-caret-right"></i>  '. $category['name'] .'
                                                </div>
                                                <div class="col-md-2 float-right blog-category-list">
                                                    '.$category['count'] .'
                                                </div>  
                                            </div>
                                        </a>
                                    </li>
                                        ';
                                    }?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
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