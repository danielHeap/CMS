
	<header id="zielony">
		<div id="logo"><a href="<?php echo System::getActualURL() . '/Page/' . $this->websiteSettings['startPage']->getValue(); ?>"><?php echo $this->websiteSettings["title"]->getValue(); ?></a></div>
		<nav id="top-menu">
            <?php $this->viewMenu(0); ?>
		</div>
	</header>
<main>