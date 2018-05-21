<h2>MENU</h2>
<?php $this->viewMenu(); ?>
<div>
    <h1><?php echo $this->getPage()->getTitle(); ?></h1>
    <?php

    $this->content();

    ?>
</div>