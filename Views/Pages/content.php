<?php

?>
<div id="page-header">
    <div class="column blue">
        <a href="<?php echo System::getActualURL(); ?>/Administration/Pages/New"><span class="icon"><img src="<?php echo System::getActualURL(); ?>/Resources/images/pages_new.svg"></span>STWÓRZ NOWĄ</a>
    </div>
</div>
<section class="page-content">
    <h3>Lista stron w serwisie</h3>
    <h4><?php echo count($this->getPages()); ?> Wyniki</h4>
    <div class="table">
        <div class="row header">
            <div class="col col-200 text-to-left">Nazwa</div>
            <div class="col col-6 text-to-left">Rodzic</div>
            <div class="col col-5 text-to-left">Tytuł</div>
            <div class="col text-to-left">Opis</div>
            <div class="col col-4 text-to-right align-right">Akcje</div>
        </div>
        <?php
        if(!empty($this->getPages('0')))
            $this->viewPagesListTable( $this, '0' );
        else 
            echo '<span class="info">Lista stron jest pusta</span>';

        ?>
    </div>
</section>