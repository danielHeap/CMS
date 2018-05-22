
<section class="page-content">
    <h3>Lista stron w serwisie<span class="arrow"><img width="24px" src="<?php echo System::getActualURL() . "/Resources/images/right-arrow.svg"; ?>"></span><span class="lighttext">Modyfikuj stronę <b><?php echo $this->editPage->getTitle(); ?></b></span></h3>
    <?php

    $newForm = new FormCreator("loginForm", array(
        "method"        => "post",
        "class"         => "basic-form"
    ));
    $newForm->addClass( "first-class", null);

    $newForm->addObject( "pageID", "first-class", array(
        "type"  => "hidden",
        "value"         => $this->editPage->getPageID()
    ));
    $newForm->addObject( "title", "first-class", array(
        "title" => "Tytuł strony",
        "type"  => "text",
        "placeholder"   => "Wpisz tytuł",
        "value"         => $this->editPage->getTitle()
    ));
    $newForm->addObject( "name", "first-class", array(
        "title" => "Nazwa w linku",
        "type"  => "text",
        "placeholder"   => "Wpisz nazwę widoczną w linku",
        "comment"   => 'Nie używaj spacji, ani żadnych znaków specjalnych, np. podstrona1.',
        "value"         => $this->editPage->getName()
    ));
    $newForm->addObject( "description", "first-class", array(
        "title" => "Opis zawartości",
        "type"   => "textarea",
        "comment"   => 'Krótkie streszczenie, do 100 znaków.',
        "value"         => $this->editPage->getDescription()
    ));
    $newForm->addButton( "submitButton", "first-class", array(
        "value" => "Modyfikuj",
        "class" => "button button-accept"
    ));

    $newForm->displayForm();

    ?>
</section>