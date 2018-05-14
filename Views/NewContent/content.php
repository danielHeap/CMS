
<h3>Dodaj nową treść do <b><?php echo $this->getEditPage()->getTitle(); ?></b></h3>
<a href="<?php echo System::getActualURL(); ?>/Administration/Page/<?php echo $this->getEditPage()->getPageID(); ?>/">Wróć do treści witryny</a>
<?php

$newForm = new FormCreator("loginForm", array(
    "method"        => "post",
));

$newForm->addClass( "first-class", array());
$newForm->addObject( "title", "first-class", array(
    "placeholder"   => "Treść",
    "type"          => "textarea"
));
$newForm->addButton( "submitButton", "first-class", array(
    "value" => "Utwórz"
));

$newForm->displayForm();

?>