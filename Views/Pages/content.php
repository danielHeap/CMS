<h3>Lista stron w serwisie</h3>
<a href="<?php echo System::getActualURL(); ?>/Administration/Pages/New">Dodaj nową</a>
<ul>
<?php

$listOfPages = DatabaseController::pullData( 
    "pages",
    "Page",
    array( "title", "description")
);
foreach($listOfPages as $page)
    echo "<li>" . $page->getTitle() . " | " . $page->getDescription() . "</li>";

?>
</ul>