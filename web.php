<?php 

    Identifier::redirect("", "Page/Start");

    Identifier::route("Administration", "AdministrationController");

    Identifier::route("Administration/Login", "AdministrationController", "loginUserForm");
    Identifier::post("Administration/Login", "AdministrationController", "loginUser");
    Identifier::route("Administration/Login/{error}", "AdministrationController", "loginUserForm");

    Identifier::route("Administration/Logout", "AdministrationController", "logoutUser");

    Identifier::route("Administration/Pages", "AdministrationController", "viewPagesList");
    Identifier::route("Administration/Pages/New", "AdministrationController", "viewNewPageForm");
    Identifier::post("Administration/Pages/New", "AdministrationController", "addNewPage");

    Identifier::route("Administration/Page/{pageID}", "AdministrationController", "viewPageContent");
    Identifier::route("Administration/Page/{pageID}/New", "AdministrationController", "viewNewContentPageForm");
    Identifier::post("Administration/Page/{pageID}/New", "AdministrationController", "addNewPageContent");

    Identifier::route("Administration/Settings", "AdministrationController", "viewSettingsList");

    Identifier::route("Page", "PageController");
    Identifier::route("Page/{namePage}", "PageController", "viewPage");

    Identifier::route("Articles/{idCategory}", "ArticlesController", "viewArticlesList");
    Identifier::route("Articles/{idCategory}/{idArticle}", "ArticlesController", "viewArticle");

    Identifier::route("Error404", "ErrorController");

    Identifier::error("Error404");

?>