<?php

    if($this->getErrorLogin() == true) echo '<span class="error">Podany użytkownik nie istnieje lub hasło, które wpisałeś jest błedne.';
    
    $newForm = new FormCreator("loginForm", array(
        'title'         => "Formularz logowania",
        "method"        => "post",
        "action"        => System::getActualURL() . "/Administration/Login"
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
    $newForm->addButton( "submitButton", "first-class", array(
        "value" => "Zaloguj się"
    ));

    $newForm->displayForm();
?>