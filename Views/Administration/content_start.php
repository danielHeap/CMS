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
                    <li>
                        <a href="" class="menu-link"><span class="icon"><img src="http://localhost/NeonCMS/Resources/images/dashboard.svg" /></span><span class="title">Kokpit</span></a>
                    </li>
                    <li>
                        <a href="" class="menu-link"><span class="icon"><img src="http://localhost/NeonCMS/Resources/images/pages.svg" /></span><span class="title">Strony</span></a>
                    </li>
                    <li>
                        <a href="" class="menu-link"><span class="icon"><img src="http://localhost/NeonCMS/Resources/images/articles.svg" /></span><span class="title">Blog</span></a>
                    </li>
                    <li class="active">
                        <a href="" class="active-link menu-link"><span class="icon"><img src="http://localhost/NeonCMS/Resources/images/components.svg" /></span><span class="title">Komponenty</span></a>
                        <div class="hide-area"></div>
                        <ul>
                            <li><a href="">Shop</a></li>
                            <li><a href="">Helpdesc</a></li>
                            <li><a href="">Social Network</a></li>
                            <li class="active"><a class="active-link" href="">Helpdesc</a>
                                <div class="hide-area"></div>
                                <ul>
                                    <li class="active"><a class="active-link" href="">Facebook</li>
                                    <li><a href="">Twitter</a></li>
                                </ul>
                            </li>
                            <li><a href="">Counter</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="" class="menu-link"><span class="icon"><img src="http://localhost/NeonCMS/Resources/images/modules.svg" /></span><span class="title">Moduły</span></a>
                    </li>
                    <li>
                        <a href="" class="menu-link"><span class="icon"><img src="http://localhost/NeonCMS/Resources/images/templates.svg" /></span><span class="title">Szablony</span></a>
                    </li>
                    <li>
                        <a href="" class="menu-link"><span class="icon"><img src="http://localhost/NeonCMS/Resources/images/settings.svg" /></span><span class="title">Ustawienia</span></a>
                    </li>
                </ul>
            </nav>
            <div class="author">Made with <span style="color: #e25555;">❤</span> by Norbert Gil & Daniel Dymiński</div>
            <div class="author-2">Made</br>with</br><span style="color: #e25555;">❤</span></br>by</br>NG & DD</div>
        </section>
        <section id="col-right">