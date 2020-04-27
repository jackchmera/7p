

<a href="#0" class="cd-top">Top</a>

<!--    <div style="background:#29166e; color: #fff;  padding: 2em 0 2em 0">
      
        <div class="container">

            <div class="row">
                <div class="col-md-12 text-center">
                  <h2>Nasz biuletyn</h2>
                </div>
            </div>

            <div class="row">

                <div class="col-md-12 text-center">
                    
                    <p>
                        Czy chcesz otrzymywać od PGN najnowsze informacje dotyczące nieruchomości? Jeśli tak, wystarczy zarejestrować się, wypełniając poniższy formularz. Z subskrypcji można zrezygnować w każdej chwili, klikając na link zamieszczony na końcu biuletynu.
                    </p>
                    
                    <form action="<?=site_url('biuletyn')?>" method="post">
                        
                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                        
                        <div class="form-group">
                            <input class="form-control-static" type="email" name="newsletter" placeholder="Twój adres e-mail" maxlength="128" />
                        </div>
                        
                        <div class="form-group">
                            <input type="checkbox" name="acknowlege" />
                            * Wyrażam zgodę na przetwarzanie moich danych osobowych przez PGN, w celu korzystania z prowadzonej przez PGN biuletynu elektronicznego. Zapoznałem/zapoznałam się z pouczeniem dotyczącym prawa dostępu do treści moich danych i możliwości ich poprawiania. Jestem świadom/świadoma, iż moja zgoda może być odwołana w każdym czasie, co skutkować będzie usunięciem mojego adresu e-mail z listy dystrybucyjnej usługi biuletynu. 
                        </div>
                        
                        <div class="form-group">
                            <input class="btn btn-default btn-lg" type="submit" value="Zapisz się" />
                        </div>
                        
                    </form>
                    
                </div>

            </div>

        </div>
          
      </div>-->

<div style="background:#180e3f; color: #fff;  padding: 2em 0 2em 0">
    <div class="container">

                <div class="row pad-section2">
                    <div class="col-md-12 text-center">
                      <p>Odwiedziło nas</p>
                      <h2><?=$count?></h2>
                      <p>osób</p>
                    </div>
                </div>
    </div>
</div>

<footer style="padding: 2em 0 2em 0">
    <div class="container">

        <div class="row">

            <div class="col-md-3">
                <h4><a href="<?=site_url('artykul/49/49')?>">domPGN.pl</a></h4>
                <ul>
                    <?php
                    
                        foreach($pgneu as $key){
                            
                            echo '<li><a href="'.site_url('artykul/49/'.$key['id']).'"><span class="glyphicon glyphicon-hand-right" aria-hidden="true"></span> '.$key['name'].'</a></li>';
                            
                        }
                    
                    ?>

                </ul>
                
            </div>

            <div class="col-md-3">
                <h4><a href="<?=site_url('artykul/73/73')?>">USŁUGI</a></h4>
                <ul>
                    <?php
                    
                        foreach($services as $key){
                            
                            echo '<li><a href="'.site_url('artykul/73/'.$key['id']).'"><span class="glyphicon glyphicon-hand-right" aria-hidden="true"></span> '.$key['name'].'</a></li>';
                            
                        }
                    
                    ?>
                </ul>
            </div>

            <div class="col-md-3">
                <h4><a href="<?=site_url('artykul/112/112')?>">Wiadomości</a></h4>
                <ul>
                    <?php
                    
                        foreach($posts_footer as $key){
                            
                            echo '<li><a href="'.site_url('news/' . $key['position']).'/'.$key['id'].'"><span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span> '.$key['name'].'</a></li>';
                            
                            
                        }
                        
                    ?>
                </ul>
                <h4><a href="<?=site_url('artykul/121/121')?>">Wiadomości TV</a></h4>
                <ul>
                    <?php
                    
                        foreach($tv_footer as $key){
                            
                            echo '<li><a href="'.site_url('news/' . $key['position']).'/'.$key['id'].'"><span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span> '.$key['name'].'</a></li>';
                            
                            
                        }
                        
                    ?>
                </ul>
            </div>

            <div class="col-md-3 text-center">

                <div id="facebookPlace" class="text-center">
                    <img style="margin: 0 auto" class="img-responsive" src="http://www.hirosi.pl/img/fb-logo2.png" alt="Ogłoszenia" />
                    <p>dołącz do nas na</p>
                    <div class="fb-like" data-href="https://www.facebook.com/Polska-Giełda-Nieruchomości-1744404939166107" data-layout="box_count" data-action="like" data-show-faces="false" data-share="true"></div>
                </div>
            </div>

        </div>

        <div class="row" style="padding: 3em 0 1em 0">

            <div class="col-md-12 text-center">
                Korzystanie z usług portalu domPGN.pl oznacza akceptację <a href="<?=site_url('artykul/49/126')?>">regulaminu</a>.
            </div>

        </div>


    </div>
</footer>

<div class="container-fluid" style="background: #180e3f">

    <div class="row-fluid">

        <a href="http://www.helloworld.com.pl" title="Hello World"><img class="img-responsive" style="margin: 0 auto" src="<?= base_url() ?>img/helloworld.png" /></a>

    </div>

</div>

<div class="cookies" id="cook">
    <div id="cookies_contener">
        Używamy plików cookies w celach zapewnienia funkcjonalności strony oraz zbierania statystyk odwiedzin wyłącznie na nasz użytek.
        <a style="margin-left: 50px; background: #fff; font-weight: bold; padding: 3px" href="javascript:hidden();" onClick="hidden();
                return false">x</a> 
    </div>
</div>

<script type="text/javascript">
    
    jQuery(document).ready(function ($) {
        // browser window scroll (in pixels) after which the "back to top" link is shown
        var offset = 300,
                //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
                offset_opacity = 1200,
                //duration of the top scrolling animation (in ms)
                scroll_top_duration = 400,
                //grab the "back to top" link
                $back_to_top = $('.cd-top');


        //hide or show the "back to top" link
        $(window).scroll(function () {
            ($(this).scrollTop() > offset) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
            if ($(this).scrollTop() > offset_opacity) {
                $back_to_top.addClass('cd-fade-out');
            }
        });

        //smooth scroll to top
        $back_to_top.on('click', function (event) {
            event.preventDefault();
            $('body,html').animate({
                scrollTop: 0,
            }, scroll_top_duration
                    );
        });

    });

    function checkCookie() {
        if (getCookie('ogloszenia')) {
            document.getElementById("cook").style.display = "none";
        }
    }

    checkCookie();

    function hidden() {
        setCookie('ogloszenia', 'OK', '30', '/', 'dompgn.pl');
        document.getElementById("cook").style.display = "none";
    }
    function setCookie(name, value, expires, path, domain, secure) {
        document.cookie = name + '=' + escape(value || '') +
                (expires ? ';expires=' + new Date(+new Date() + expires * 864e5).toGMTString() : '') +
                (path ? ';path=' + path : '') +
                (domain ? ';domain=' + domain : '') +
                (secure ? ';secure' : '');
    }
    function getCookie(N) {
        if (N = (new RegExp(';\\s*' + ('' + N).replace('/([()[\]{}\-.*+?^$|\/\\])/g', '\\$1') + '=([^;]*)')).exec(';' + document.cookie + ';'))
            return N[1]
    }

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-88935724-1', 'auto');
  ga('send', 'pageview');

</script>

