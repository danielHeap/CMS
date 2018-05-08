<?php
    
    $newForm = new FormCreator("loginForm", array(
        'title'         => "Formularz logowania",
        "method"        => "post",
    ));

    $newForm->addClass( "first-class", array(
        "title"         => "Panel administratora", 
        "description"   => "Wpisz login oraz hasło, aby sie zalogować"
    ));
    $newForm->addObject( "login", "first-class", array(
        "placeholder"   => "Login"
    ));
    $newForm->addObject( "password", "first-class", array(
        "placeholder"   => "Hasło",
        "type"          => "password"
    ));
    $newForm->addObject( "actionController", "first-class", array(
        "type"          => "hidden",
        "value"         => "LoginController"
    ));
    $newForm->addObject( "actionMethod", "first-class", array(
        "type"          => "hidden",
        "value"         => "loginUser"
    ));
    $newForm->addButton( "submitButton", "first-class", array(
        "value" => "Zaloguj się"
    ));

    $newForm->displayForm();
?>