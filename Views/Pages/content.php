<h3>Lista stron w serwisie</h3>
<ul>
<?php

$listOfPages = DatabaseController::pullData( 
    "pages",
    "Page",
    array( "title", "description") , 
    array(
        "parentID" => 1
    )
);
foreach($listOfPages as $page)
    echo "<li>" . $page->getTitle() . " | " . $page->getDescription() . "</li>";

?>
</ul>
<h3>Dodaj nową stronę</h3>
<?php

$newForm = new FormCreator("loginForm", array(
    'title'         => "Formularz logowania",
    "method"        => "post",
));

$newForm->addClass( "first-class", array(
    "title"         => "Nowa strona", 
    "description"   => "Wpisz dane strony w serwisie"
));
$newForm->addObject( "title", "first-class", array(
    "placeholder"   => "Tytuł"
));
$newForm->addObject( "description", "first-class", array(
    "placeholder"   => "Opis"
));
$newForm->addObject( "parentID", "first-class", array(
    "placeholder"   => "Indeks rodzica"
));
$newForm->addObject( "actionController", "first-class", array(
    "type"          => "hidden",
    "value"         => "PagesController"
));
$newForm->addObject( "actionMethod", "first-class", array(
    "type"          => "hidden",
    "value"         => "createNewPage"
));
$newForm->addButton( "submitButton", "first-class", array(
    "value" => "Utwórz"
));

$newForm->displayForm();

?>