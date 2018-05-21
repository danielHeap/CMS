<section class="page-content">
    <h3>Ustawienia<span class="arrow"><img width="24px" src="<?php echo System::getActualURL() . "/Resources/images/right-arrow.svg"; ?>"></span><span class="lighttext">Podstawowe ustawienia</span></h3>
    <h4>Globalne metadane witryny internetowej</h4>
    <?php

    $newForm = new FormCreator("settings", array(
        "method"        => "post",
        "class"         => "basic-form"
    ));
    $newForm->addClass( "basic", null);

    $basicSettings = DatabaseController::pullData( 
        "settings",
        "Setting",
        array( "name", "value", "title" ),
        array(
            "name" => array(
                "!=",
                "template"
            )
        )
    );

    foreach ($basicSettings as $setting) {
        $newForm->addObject( $setting->getName(), "basic", array(
            "title" => $setting->getTitle(),
            "value" => $setting->getValue(),
            "type"  => "text"
        ));
    }
    
    $newForm->addButton( "submitButton", "basic", array(
        "value" => "Modyfikuj ustawienia",
        "class" => "button button-accept"
    ));

    $newForm->displayForm();
    ?>
</section>