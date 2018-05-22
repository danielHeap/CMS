<!DOCTYPE html>
    <html lang="pl">
        <head>
            <title><?php echo $this->websiteSettings["title"]->getValue(); ?> - <?php echo $this->getPage()->getTitle(); ?></title>
            <meta name="description" content="<?php echo $this->websiteSettings["description"]->getValue(); ?>">
            <meta name="keywords" content="<?php echo $this->websiteSettings["keywords"]->getValue(); ?>">
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <link rel="stylesheet" type="text/css" href="<?php echo System::getActualURL(); ?>/Resources/website-general.css">
            <script src="<?php echo System::getActualURL(); ?>/Resources/js/jquery-3.1.1.min.js"></script> 
            <script src="<?php echo System::getActualURL(); ?>/Resources/js/cookieMnstr.js"></script> 
            <script src="<?php echo System::getActualURL(); ?>/Resources/js/selectRange.js"></script> 
        </head>
        <body>
  