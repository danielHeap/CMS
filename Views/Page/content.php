<h2>MENU</h2>
<?php $this->viewMenu(); ?>
<div>
    <h1><?php echo $this->getPage()->getTitle(); ?></h1>
    <?php

    if($this->getContent())
        foreach ($this->getContent() as $content) {
            echo "<div>" . $content->getContentHTML() . "</div>";
        }

    ?>
</div>