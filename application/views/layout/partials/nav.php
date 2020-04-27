<!-- navigation panel -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-main">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
        
      <a class="navbar-brand" href="<?=base_url()?>">
          <img id="logo" class="img-responsive" src="<?=base_url()?>img/logo.png" alt="Polska Giełda Nieruchomości Komercyjnych" />
      </a>
        
        <h4 id="main-header">POLSKA GIEŁDA NIERUCHOMOŚCI - dom<span style="color: red">PGN.pl</span></h4> 
      
    </div>

    <div class="collapse navbar-collapse" id="navbar-collapse-main">
      <ul class="nav navbar-nav navbar-right">
        
            <?php
                                                
                if($this->session->userdata('login')){

                    ?>
                    <li><a href="<?=site_url('panel/panel')?>" rel="external">Panel Klienta</a></li>
                    <li><a href="<?=site_url('wyloguj')?>" rel="external">Wyloguj</a></li>

            <?php

                }
                else{

                    ?>
                    <li><a href="<?=site_url('zaloguj')?>"><button type="button" class="btn btn-default" style="margin: 0px">Zaloguj się</button></a></li>
                    <li><a href="<?=site_url('rejestracja')?>"><button type="button" class="btn btn-primary">Zarejestruj się</button></a></li>
            <?php
                }                                    
            ?>
        
        <li><a href="<?=site_url('dodaj')?>"><button type="button" class="btn btn-danger">Dodaj ofertę</button></a></li>
        <li><a href="https://www.facebook.com/Polska-Gie%C5%82da-Nieruchomo%C5%9Bci-1744404939166107" title="Nasz Facebook"><img class="img-responsive" style="padding-top: 15px; height:40px" src="<?=base_url()?>img/facebook.png" alt="pgn" /></a></li>
      </ul>
    </div>
  </div>
</nav>