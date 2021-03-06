<?php
global $ID, $ACT, $conf;
$data = p_get_metadata($ID, 'redfoftpl');
$title_page = $data['title-page'] && $ACT == 'show';

// background-text
$background_text = mb_strtoupper( isset($data['background-text']) ? $data['background-text'] : tpl_pagetitle(null, true));

// menu-source: Source page for menu. "system:" is added to the beginning and "_<lang>" to the end
$menu_source = $data['menu-source'] ?: tpl_getConf('menu-source');

// footer-source: Source page for footer
$footer_source = $data['footer-source'] ?: tpl_getConf('footer-source') . '_' . $conf['lang'];

// header-source: is a page which will be displayed on the top of the title page
$header_source = isset($data['header-source']) ? $data['header-source'] : tpl_getConf('header-source');

// title, don't forget to enable useheading
$title = isset($data['title']) ? hsc($data['title']) : tpl_pagetitle(null, true) . " - " . strip_tags($conf['title']);

// request for full width
$full_width = isset($data['full-width']) ? (bool)$data['full-width'] : false;

require_once(dirname(__FILE__) . '/tpl_functions.php'); /* include hook for template functions */

require_once('navBar/NavBarItem.php');
require_once('navBar/BootstrapNavBar.php');

use fksTemplate\NavBar\BootstrapNavBar;

$main_menu = new BootstrapNavBar('full');
$main_menu->setClassName('navbar navbar-expand-lg')->addMenuText($menu_source)
    ->addLangToggle();
$main_menu->addTools(null, true);

?><!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml"
      xml:lang="<?= $conf['lang'] ?>"
      lang="<?= $conf['lang'] ?>"
      dir="<?= $lang['direction']; ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#d7392e">
    <!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,500,600,700" rel="stylesheet"> -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300&display=swap" rel="stylesheet">
    <title><?= $title ?></title>


    <link rel="apple-touch-icon" sizes="180x180" href="<?= tpl_basedir() . 'images/favicon' ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= tpl_basedir() . 'images/favicon' ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= tpl_basedir() . 'images/favicon' ?>/favicon-16x16.png">
    <link rel="manifest" href="<?= tpl_basedir() . 'images/favicon' ?>/site.webmanifest">
    <link rel="mask-icon" href="<?= tpl_basedir() . 'images/favicon' ?>/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="apple-mobile-web-app-title" content="<?= strip_tags($conf['title']) ?>">
    <meta name="application-name" content="<?= strip_tags($conf['title']) ?>">
    <meta name="msapplication-TileColor" content="#d7392e">
<script type="text/javascript">
    _ga.create('<?= tpl_getConf('ga_trackcode') ?>', '<?= $_SERVER['HTTP_HOST'] ?>');
    _gaq.push(['_trackPageview']);
</script>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <?php tpl_metaheaders() ?>
    <?php tpl_includeFile('meta.html') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script defer="defer" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>

</head>

<body class="<?= $title_page ? "title-page" : null ?>">
<div id="dokuwiki__top" class="site <?php echo tpl_classes(); ?><?= $full_width ? ' full-width' : null ?>">
    <header>
        <div class="title-pane">
            <svg class="header-background" preserveAspectRatio="<?= $title_page ? "none" : "xMinYMin meet" ?>" viewBox="0 0 59 15">
                <text <?= $title_page ? 'x="-1.2" ' : null ?>y="15"><?= $background_text ?></text>
            </svg>
            <object class="header-background" type="image/svg+xml" data="<?= tpl_basedir() . 'images/prague.svg' ?>"></object>
            <a href="<?= wl($conf['titlepage']) /* comes from the translatemapping plugin */ ?>" class="svg header-logo"><object class="" type="image/svg+xml" data="<?= tpl_basedir() . 'images/logo-2022.svg' ?>"></object></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#mainNavbar<?= $main_menu->id ?>" aria-controls="main-navbar" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <?php $main_menu->render(false); ?>

        <?php if ($title_page): ?>
            <div class="header-inner">
                <?php tpl_include_page($header_source, true, false, false); ?>
            </div>
        <?php endif; ?>

    </header>

    <div class="inner-container">

<!--        <svg class="tpl-triangle-top" preserveAspectRatio="none" viewBox="0 0 100 100">
            <polygon points="0,0 0,2 100,100 100,0"></polygon>
        </svg>
-->

        <article>
            <?php html_msgarea() ?>
            <?php tpl_content(false); ?>
        </article>


        <svg class="tpl-triangle-bottom" preserveAspectRatio="none" viewBox="0 0 100 100">
            <polygon points="0,0 100,98 100,100 0,100"></polygon>
        </svg>

    </div>

    <footer>
        <?php tpl_include_page($footer_source, true, false, false); ?>
    </footer>
</div>
<?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?>
</body>
</html>
