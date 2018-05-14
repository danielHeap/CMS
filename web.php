<?php 

    Identifier::redirect("", "Start");

    Identifier::route("Administration", "AdministrationController");

    Identifier::route("Administration/Login", "AdministrationController", "loginUserForm");
    Identifier::post("Administration/Login", "AdministrationController", "loginUser");

    Identifier::route("Administration/Logout", "AdministrationController", "logoutUser");

    Identifier::route("Administration/Pages", "AdministrationController", "viewPagesList");
    Identifier::route("Administration/Page/{idPage}", "AdministrationController", "viewPageContent");

    Identifier::route("Administration/Settings", "AdministrationController", "viewSettingsList");

    Identifier::route("Start", "PageController");
    Identifier::route("Page/{idPage}", "PageController");

    Identifier::route("Error404", "ErrorController");

    Identifier::error("Error404");

?>