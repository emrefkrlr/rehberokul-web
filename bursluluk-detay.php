<?php
require_once('php/Core.php');
if (SUBFOLDER){
    $robotsStatus = "noindex, nofollow";
}else{
    $robotsStatus = "index, follow";
}

if (isset($_SERVER['REQUEST_URI']))
{
    $url = array_filter(explode('/', $_SERVER['REQUEST_URI']));
    if ($url > 2) {
        if(SUBFOLDER){
            $getScholarshipSlug = $url[3];
        }else{
            $getScholarshipSlug = $url[2];
        }

    }else{
        $getScholarshipSlug = ltrim($_SERVER['REQUEST_URI'], "/");
    }
    echo $getScholarshipSlug;
    $db->where('scholarship_slug', $getScholarshipSlug);
    $scholarship = $db->getOne('scholarship');
}


$pageTitle = $scholarship['title'];
$pageDescription = $scholarship['page_description'];
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
    <?php require_once('php/Components/Scripts.php'); ?>
</head>
<body>
<?php require_once('php/Components/Header-Part-1.php'); ?>
<div class="container xxs-py">
    <div class="row">
        <div class="pg-list-1-left dir-ho-t-tit" style="padding-top: 1%">
            <h1><?= $scholarship['title']?></h1>
            <?php if ($scholarship['school_id'] != 0):?>
                <?php
                $db->where('id', $scholarship['school_id']);
                $school_link = $db->get('school', null, 'link');
                ?>

                <a href="<?=WEBURL.'okul/'.$school_link[0]['link']?>" style="padding: 10px; border: 1px solid tomato; border-radius: 7px; display: flex; width: 220px; align-items: center">
                    <i class="fa fa-hand-o-right color-white" aria-hidden="true" style="margin-right: 5px"></i>
                    Okulun profilini ziyaret et
                </a>
            <?php endif; ?>
        </div>
        <div class="pg-list-1-right">
            <div class="list-enqu-btn pg-list-1-right-p1">
                <a href="<?= WEBURL.'bursluluk-sinavi/'.$getScholarshipSlug?>#ucretsiz-danismanlik-formu" style="font-size: 14px !important;color: #fff !important;border: 1px solid #44526c !important;font-weight: 400 !important;border-radius: 4px !important;padding: 10px 10px !important;margin-left: 7px !important;max-width: 200px !important;cursor:pointer !important;height: 55px !important;line-height: 35px !important;" class="waves-effect waves-light tourz-sear-btn waves-input-wrapper float-right"><i class="fa fa-bookmark"></i> &nbsp;Talep Oluştur</a>
            </div>
        </div>

    </div>
</div>


<div class="container">
    <div class="row">

    </div>
</div>



</section>
<?php require_once('php/Components/Header-Part-2.php'); ?>





<section class="p-about com-padd">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="page-about pad-bot-red-40">
                    <?php echo htmlspecialchars_decode($scholarship['content']); ?>

                </div>
            </div>
            <div class="col-md-6">
                <div class="page-about">
                    <?php if ($scholarship['img'] != ''): ?>
                        <img src="<?=WEBURL.'/'.$scholarship['img'] ?>" alt="<?=$scholarship['scholarship_slug'].'-Rehber Okul'?>" />
                    <?php else:?>
                        <img src="images/ro-blank.jpg" alt="<?=$scholarship['scholarship_slug'].'-Rehber Okul'?>" />
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</section>








<section id="ucretsiz-danismanlik-formu" class="com-padd quic-book-ser-full">
    <div class="quic-book-ser">
        <div class="quic-book-ser-inn">
            <div class="quic-book-ser-left">
                <div class="land-com-form">
                    <p class="sizi-arayalım">Sizi Arayalım</p>
                    <form id="call-us-form">
                        <ul>
                            <li>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="text" name="full_name" value="<?php echo $_SESSION['user_data']['full_name'] ;?>" pattern="[a-zA-ZçÇöÖüÜşŞİığĞ\s]*" title="İsminizi Girmediniz!" required>
                                        <label>İsim Soyisim</label>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input value="<?php echo $loggedInUser ? $loggedInUser['phone'] : '' ;?>" type="text" name="phone" pattern="^[0-9]{10,10}$" title="Sadece rakam kullanabilirsiniz! 10 haneli olmalıdır!" required>
                                        <label>Telefon</label>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input value="<?php echo $loggedInUser ? $loggedInUser['email'] : '' ;?>" type="email" name="email" title="Hatalı Email!" required>
                                        <label>E-Posta</label>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="input-field col s12 school-type-select">
                                        <select name="school_type" required title="Okul Türü Seçmediniz!">
                                            <option value="">Okul Türü</option>
                                            <option <?php echo $schoolType == 1 ? 'selected' : '';?> value="1">Anaokulu veya Kreş</option>
                                            <option <?php echo $schoolType == 2 ? 'selected' : '';?> value="2">İlkokul</option>
                                            <option <?php echo $schoolType == 3 ? 'selected' : '';?> value="3">Ortaokul</option>
                                            <option <?php echo $schoolType == 4 ? 'selected' : '';?> value="4">Lise</option>
                                        </select>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <textarea id="ta-call-us-note" name="note" required title="Not Girmediniz!" rows="4" cols="50" style="height: 70px;" placeholder="Notunuz"></textarea>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <button type="button" class="waves-effect waves-light btn-large full-btn" onclick="send_call_us();">Talep Oluştur</button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
            <div class="quic-book-ser-right">
                <div class="hom-cre-acc-left">
                    <p class="h3">Eğitim danışmanlarımız sizi arasın</p>
                    <p class="under-h-title-info">Sizin için en uygun okulu belirlemeye zaman ayıramıyorsanız, ücretiz olarak eğitim danışmanlarımızla iletişime geçebilir ve destek alabilirsiniz.</p>
                    <ul>
                        <li> <img src="images/ikonlar/talep-formu/adim-1.png" alt="" width="35">
                            <div>
                                <h5 class="xxs-pt under-h-title-info">Formu doldurun</h5>
                                <p></p>
                            </div>
                        </li>
                        <li> <img src="images/ikonlar/talep-formu/adim-2.png" alt="" width="35">
                            <div>
                                <h5 class="xxs-pt under-h-title-info">Eğitim danışmanlarımız sizi arasın</h5>
                                <p></p>
                            </div>
                        </li>
                        <li> <img src="images/ikonlar/talep-formu/adim-3.png" alt="" width="35">
                            <div>
                                <h5 class="xxs-pt under-h-title-info">En uygun eğitim kurumunu bulun</h5>
                                <p></p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
require_once('php/Components/Footer.php');

?>
<script src="js/bootstrap.js" type="text/javascript"></script>
<script src="js/materialize.min.js" type="text/javascript"></script>
<script src="js/custom.js"></script>
<script src="js/rehberokul.js"></script>
<script type="text/javascript" src="slick/slick.min.js"></script>
<script type="text/javascript">
    $(document).ready( function () {
        $('.school-type-select .select-wrapper .caret').remove();
        $('.school-type-select .select-wrapper .select-dropdown').remove();
    });
    $('.card-slider').slick({
        autoplay: true,
        dots: false,
        infinite: true,
        speed: 1500,
        slidesToShow: 4,
        slidesToScroll: 4,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: false
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
</script>
</body>
</html>

