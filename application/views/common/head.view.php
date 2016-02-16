<!DOCTYPE>
<html lang="<?= WEBSITE_LANGUAGE ?>">
    <head>
        <title><?= WEBSITE_NAME ?></title>
        <meta charset="<?= WEBSITE_CHARSET ?>">
        <meta name="description" content="<?= WEBSITE_DESCRIPTION ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?= WEBSITE_ADDRESS . CSS ?>common.css" type="text/css" />
        <link rel="stylesheet" media="print" href="<?= WEBSITE_ADDRESS . CSS ?>print.css" type="text/css" />
        <link rel="stylesheet" media="screen and (max-width: 900px)" href="<?= WEBSITE_ADDRESS . CSS ?>mobile.css" type="text/css" />
        <link rel="stylesheet" media="screen and (min-width: 900px) and (max-width: 1200px)" href="<?= WEBSITE_ADDRESS . CSS ?>tablet.css" type="text/css" />
        <link rel="stylesheet" media="screen and (min-width: 1200px)" href="<?= WEBSITE_ADDRESS . CSS ?>desktop.css" type="text/css" />
        <?php __autoload_url_lib_css() ?>
    </head>

    <body>