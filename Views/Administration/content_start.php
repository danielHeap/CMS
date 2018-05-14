<main>
        <section id="col-left">
            <div class="mini-button" title="Zmień rozmiar menu"></div>
            <script type="text/javascript">
                $(document).ready(function(){
                    if(getCookie("mini-menu"))
                    {
                        $('main').addClass('mini');
                    }
                    $('.mini-button').on('click', function(){
                        $('main').toggleClass('mini');
                        if(!getCookie("mini-menu"))
                        {
                            setCookie("mini-menu", "1", 2);
                        } else {
                            deleteCookie("mini-menu");
                        }
                    });
                });
            </script>
            <nav id="main-menu">
                <ul>
                    <li <?php if(System::getView() == "Administration") echo "class=active" ?>>
                        <a href="<?php echo System::getActualURL(); ?>/Administration/" class="menu-link"><span class="icon"><img src="<?php echo System::getActualURL(); ?>/Resources/images/dashboard.svg" /></span><span class="title">Kokpit</span></a>
                    </li>
                    <li <?php if(System::getView() == "Administration/Pages") echo "class=active" ?>>
                        <a href="<?php echo System::getActualURL(); ?>/Administration/Pages/" class="menu-link"><span class="icon"><img src="<?php echo System::getActualURL(); ?>/Resources/images/pages.svg" /></span><span class="title">Strony</span></a>
                    </li>
                    <li <?php if(System::getView() == "Administration/Settings") echo "class=active" ?>>
                        <a href="<?php echo System::getActualURL(); ?>/Administration/Settings/" class="menu-link"><span class="icon"><img src="<?php echo System::getActualURL(); ?>/Resources/images/settings.svg" /></span><span class="title">Ustawienia</span></a>
                    </li>
                </ul>
            </nav>
            <div class="author">Made with <span style="color: #e25555;">❤</span> by Norbert Gil & Daniel Dymiński</div>
            <div class="author-2">Made</br>with</br><span style="color: #e25555;">❤</span></br>by</br>NG & DD</div>
        </section>
        <section id="col-right">