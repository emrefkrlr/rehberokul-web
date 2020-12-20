<base href="<?php echo WEBURL; ?>">
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
<?php if ($robotsStatus) {echo '<meta name="robots" content="'.$robotsStatus.'" />';} ?>

<meta http-equiv="Content-Language" content="tr-TR" />
<meta name="content-language" content="tr-TR" />
<meta name="title" content="<?php echo $pageTitle; ?>" />
<meta name="description" content="<?php echo $pageDescription; ?>" />
<?php if ($pageKeywords) {echo '<meta name="keywords" content="' .$pageKeywords . '" />';} ?>

<meta name="author" content="<?php echo SITENAME; ?>" />
<meta name="owner" content="<?php echo SITENAME; ?>" />
<meta name="generator" content="<?php echo SITENAME; ?>" />
<meta property="og:locale" content="tr_TR" />
<meta property="og:type" content="website" />
<meta name="og:title" content="<?php echo $pageTitle; ?>"/>
<meta name="og:url" content="<?php echo $pageUrl; ?>"/>
<meta name="og:image" content="<?php echo WEBURL; echo $pageSocialImagePath; ?>"/>
<meta name="og:site_name" content="<?php echo SITENAME; ?>"/>
<meta name="og:description" content="<?php echo $pageDescription; ?>"/>
<meta name="twitter:card" content="summary" />
<meta name="twitter:description" content="<?php echo $pageDescription; ?>" />
<meta name="twitter:title" content="<?php echo $pageTitle; ?>" />
<meta name="twitter:creator" content="@<?php echo $twitterUsername; ?>" />
<meta name="apple-mobile-web-app-title" content="<?php echo SITENAME; ?>">
<title><?php echo $pageTitle; ?></title>
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo WEBURL; ?>images/rehberokul/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo WEBURL; ?>images/rehberokul/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo WEBURL; ?>images/rehberokul/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo WEBURL; ?>images/rehberokul/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo WEBURL; ?>images/rehberokul/apple-touch-icon-180x180.png">
<link rel="icon" type="image/png" href="<?php echo WEBURL; ?>images/rehberokul/favicon-16x16.png" sizes="16x16">
<link rel="icon" type="image/png" href="<?php echo WEBURL; ?>images/rehberokul/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="<?php echo WEBURL; ?>images/rehberokul/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="<?php echo WEBURL; ?>images/rehberokul/favicon-192x192.png" sizes="192x192">
<link rel="icon" type="image/png" href="<?php echo WEBURL; ?>images/rehberokul/favicon-194x194.png" sizes="194x194">
<link rel="canonical" href="<?php echo $pageUrl; ?>" />