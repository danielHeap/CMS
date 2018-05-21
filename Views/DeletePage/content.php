<div class="page-content content-alert">
    <div class="alert">
        <div class="up">Czy napewno chcesz usunąć stronę "<b><?php echo $this->editPage[0]->getTitle(); ?></b>"?</div>
        <div class="down">
            <a href="<?php echo System::getActualURL(); ?>/Administration/Pages/" class="button">Anuluj</a><a href="<?php echo System::getActualURL(); ?>/Administration/Page/<?php echo $this->editPage[0]->getPageID(); ?>/Delete" class="button button-accept">Usuń</a>
        </div>
    </div>
</div>