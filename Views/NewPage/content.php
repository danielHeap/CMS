
<section class="page-content">
    <h3>Lista stron w serwisie<span class="arrow"><img width="24px" src="<?php echo System::getActualURL() . "/Resources/images/right-arrow.svg"; ?>"></span><span class="lighttext">Dodaj nową stronę</span></h3>
    <?php

    $newForm = new FormCreator("loginForm", array(
        "method"        => "post",
        "class"         => "basic-form"
    ));
    $newForm->addClass( "first-class", null);

    $pages = DatabaseController::pullData( 
        "pages",
        "Page",
        array( "pageID", "title" )
    );
    $pagesList = [];
    array_push(
        $pagesList,
        array(
            "name" => "0",
            "title" => "- - - - -"
        )
    );
    if(count($pages) > 0)
        foreach ($pages as $value) {
            array_push(
                $pagesList,
                array(
                    "name" => $value->getPageID(),
                    "title" => $value->getTitle()
                )
            );
        }
    $newForm->addObject( "parentID", "first-class", array(
        "title" => "Rodzic",
        "type"  => "select",
        "options"  => $pagesList
    ));
    $newForm->addObject( "title", "first-class", array(
        "title" => "Tytuł strony",
        "type"  => "text",
        "placeholder"   => "Wpisz tytuł"
    ));
    $newForm->addObject( "name", "first-class", array(
        "title" => "Nazwa w linku",
        "type"  => "text",
        "placeholder"   => "Wpisz nazwę widoczną w linku",
        "comment"   => 'Nie używaj spacji, ani żadnych znaków specjalnych, np. podstrona1.'
    ));
    $newForm->addObject( "description", "first-class", array(
        "title" => "Opis zawartości",
        "type"   => "textarea",
        "comment"   => 'Krótkie streszczenie, do 100 znaków.'
    ));
    $newForm->addButton( "submitButton", "first-class", array(
        "value" => "Utwórz",
        "class" => "button button-accept"
    ));

    $newForm->displayForm();

    ?>
</section>