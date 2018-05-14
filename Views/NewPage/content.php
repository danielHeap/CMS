
<h3>Dodaj nową stronę</h3>
<?php

$newForm = new FormCreator("loginForm", array(
    "method"        => "post",
));

$newForm->addClass( "first-class", array(
    "title"         => "Podstawowe dane", 
    "description"   => "Wpisz dane strony w serwisie"
));
$newForm->addObject( "title", "first-class", array(
    "placeholder"   => "Tytuł"
));
$newForm->addObject( "name", "first-class", array(
    "placeholder"   => "Nazwa"
));
$newForm->addObject( "description", "first-class", array(
    "placeholder"   => "Opis"
));
$newForm->addButton( "submitButton", "first-class", array(
    "value" => "Utwórz"
));

$newForm->displayForm();

?>