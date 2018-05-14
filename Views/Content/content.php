<h3>Treść witryny <b><?php echo $this->getEditPage()->getTitle(); ?></b></h3>
<a href="<?php echo System::getActualURL(); ?>/Administration/Pages/">Wróć do listy stron</a><br>
<a href="<?php echo System::getActualURL(); ?>/Administration/Page/<?php echo $this->getEditPage()->getPageID(); ?>/New">Dodaj nową</a>
<?php
/*
$pages = DatabaseController::pullData( 
    "pagesContent",
    "Content",
    array( "contentHTML" ),
    array(
        "pageID" => 
    )
);
if(!empty($pages))
    foreach($pages as $page)
    {
        echo '<li style="line-height: 30px"><span style="width: 200px; display: inline-block;">' . $page->getName() . '</span><span style="width: 200px;  line-height: 40px; display: inline-block;">' . $page->getTitle() . '</span><span style="width: 200px;  line-height: 40px; display: inline-block;">' . $page->getDescription() . '</span><a href="' . System::getActualURL() . '/Administration/Page/' . $page->getPageID() . '">Wyświetl treść</a> | <a href="' . System::getActualURL() . '/Administration/Page/' . $page->getPageID() . '/New/">Dodaj nową treść</a></li>';
    }
else 
    echo '<span class="info">Lista treści jest pusta</span>';
*/
?>