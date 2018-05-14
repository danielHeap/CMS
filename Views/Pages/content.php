<h3>Lista stron w serwisie</h3>
<a href="<?php echo System::getActualURL(); ?>/Administration/Pages/New">Dodaj nową</a>
<div style=" margin-top: 20px; font-weight: 600"><span style="width: 200px;  line-height: 40px; display: inline-block;">NAZWA</span><span style="width: 200px;  line-height: 40px; display: inline-block;">TYTUŁ</span>OPIS</div>
<ul style="margin: 0; padding: 0; list-style: none;">
<?php

$pages = DatabaseController::pullData( 
    "pages",
    "Page",
    array( "title", "name", "description")
);
if(!empty($pages))
    if(count($pages) == 1)
        echo '<li style="line-height: 30px"><span style="width: 200px; display: inline-block;">' . $pages->getName() . '</span><span style="width: 200px;  line-height: 40px; display: inline-block;">' . $pages->getTitle() . '</span>' . $pages->getDescription() . '</li>';
    else 
        foreach($pages as $page)
        {
            echo '<li style="line-height: 30px"><span style="width: 200px; display: inline-block;">' . $page->getName() . '</span><span style="width: 200px;  line-height: 40px; display: inline-block;">' . $page->getTitle() . '</span>' . $page->getDescription() . '</li>';
        }
else 
    echo '<span class="info">Lista stron jest pusta</span>';

?>
</ul>