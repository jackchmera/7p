<!DOCTYPE html>
<html lang="pl">
    <head>
        <title><?=$title?> - domPGN.pl</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="<?=$csrf['name']?>" content="<?=$csrf['hash']?>">
        <link rel="shortcut icon" href="<?=base_url()?>img/logo.png" type="image/x-icon" />

        <!-- attach CSS styles -->
        <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?=base_url()?>css/style.css" rel="stylesheet">
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" type="text/javascript"></script> 
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=News+Cycle:400,700|Tangerine&amp;subset=latin-ext" rel="stylesheet">
        
        <!-- OFFER VIEW -->
        <link rel="stylesheet" type="text/css" media="all" href="<?=base_url()?>css/font-awesome.min.css" />
        <link rel="stylesheet" type="text/css" media="all" href="<?=base_url()?>css/jgallery.min.css?v=1.5.5" />
        <script type="text/javascript" src="<?=base_url()?>js/jgallery.min.js"></script>
    </head>  
  <body>
      <div id="fb-root"></div>
        <script>(function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/pl_PL/all.js#xfbml=1";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
       
    <?php
      
        $this->load->view('layout/partials/nav');
        
        if($middle) echo $middle ;
 
        $this->load->view('layout/partials/footer');
    
    ?>
  </body>
</html>