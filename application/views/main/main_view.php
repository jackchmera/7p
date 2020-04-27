<div id="home" class="home">
    <div class="text-vcenter">

        <h2 style="color: #eee; text-shadow: 0px 0px 3px #000; background-color: rgba(40, 21, 110, 0.9); padding: 5px"><span style="text-shadow: 0px 0px 10px #ee0000">dom<span style="color:red">PGN.PL</span></span> - POLSKA GIEŁDA NIERUCHOMOŚCI</h2>

        <div class="row" style="margin-top:2em">

            <div class="col-md-2"></div>

            <?php $this->load->view('main/search'); ?>

            <div class="col-md-2"></div>

        </div>

    </div>
</div>
<div class="promo-section">
    <div class="container">

        <div class="row" style="padding: 2em 0 0em 0">
            <div class="col-md-12 text-center">
                <h2>Promowane oferty</h2>
            </div>
        </div>

        <div class="row" style="padding: 2em 0 1em 0">

            <?php
            for ($i = 0; $i <= 3; $i++) {
                ?>

                <div class="col-md-3">
                    <a href="<?= site_url('oferta/' . $promo_offers[$i]['id']) ?>">
                        <div class="promo-offer">

                            <?php
                            if ($promo_offers[$i]['main_image']['name'] != '') {
                                ?>
                                <div class='promo-offer-picture' style="background: #000 url('<?= base_url() ?>imports/<?= $promo_offers[$i]['ftp']['directory'] ?>/unziped/<?= $promo_offers[$i]['main_image']['name'] ?>"></div>
                                <?php
                            } else {
                                ?>
                                <div class='promo-offer-picture-none' style="background: #fff url('<?= base_url() ?>img/logo.png') no-repeat center"></div>
                                <?php
                            }
                            ?>    

                            <div class='promo-desc'>
                                <h3><?= $promo_offers[$i]['price'] ?> PLN</h3>
                                <h2><?= $promo_offers[$i]['community'] ?>, <?= $promo_offers[$i]['voivodeship_name'] ?>, powiat <?= $promo_offers[$i]['district_name'] ?></h2>
                                <p><?= $promo_offers[$i]['area'] ?> m<sup>2</sup></p>
                            </div>

                        </div>
                    </a>
                </div>


    <?php
}
?>

        </div>

        <div class="row" style="padding: 1em 0 1em 0">

<?php
for ($i = 4; $i <= 7; $i++) {
    ?>

                <div class="col-md-3">
                    <a href="<?= site_url('oferta/' . $promo_offers[$i]['id']) ?>">
                        <div class="promo-offer">

    <?php
    if ($promo_offers[$i]['main_image']['name'] != '') {
        ?>
                                <div class='promo-offer-picture' style="background: #000 url('<?= base_url() ?>imports/<?= $promo_offers[$i]['ftp']['directory'] ?>/unziped/<?= $promo_offers[$i]['main_image']['name'] ?>"></div>
                                <?php
                            } else {
                                ?>
                                <div class='promo-offer-picture-none' style="background: #fff url('<?= base_url() ?>img/logo.png') no-repeat center"></div>
                                <?php
                            }
                            ?>  

                            <div class='promo-desc'>
                                <h3><?= $promo_offers[$i]['price'] ?> PLN</h3>
                                <h2><?= $promo_offers[$i]['community'] ?>, <?= $promo_offers[$i]['voivodeship_name'] ?>, powiat <?= $promo_offers[$i]['district_name'] ?></h2>
                                <p><?= $promo_offers[$i]['area'] ?> m<sup>2</sup></p>
                            </div>

                        </div>
                    </a>
                </div>


    <?php
}
?>

        </div>

        <div class="row" style="padding: 1em 0 2em 0">

            <?php
            for ($i = 8; $i <= 11; $i++) {
                ?>

                <div class="col-md-3">
                    <a href="<?= site_url('oferta/' . $promo_offers[$i]['id']) ?>">
                        <div class="promo-offer">

                <?php
                if ($promo_offers[$i]['main_image']['name'] != '') {
                    ?>
                                <div class='promo-offer-picture' style="background: #000 url('<?= base_url() ?>imports/<?= $promo_offers[$i]['ftp']['directory'] ?>/unziped/<?= $promo_offers[$i]['main_image']['name'] ?>"></div>
        <?php
    } else {
        ?>
                                <div class='promo-offer-picture-none' style="background: #fff url('<?= base_url() ?>img/logo.png') no-repeat center"></div>
                                <?php
                            }
                            ?>  

                            <div class='promo-desc'>
                                <h3><?= $promo_offers[$i]['price'] ?> PLN</h3>
                                <h2><?= $promo_offers[$i]['community'] ?>, <?= $promo_offers[$i]['voivodeship_name'] ?>, powiat <?= $promo_offers[$i]['district_name'] ?></h2>
                                <p><?= $promo_offers[$i]['area'] ?> m<sup>2</sup></p>
                            </div>

                        </div>
                    </a>
                </div>


    <?php
}
?>

        </div>

        <div class="row" style="padding: 2em 0 2em 0">

            <div class="col-md-12 text-center">

                <a href='<?= site_url('wszystkie_oferty') ?>' class="btn btn-default btn-lg">ZOBACZ WIĘCEJ</a>

            </div>

        </div>

    </div>
</div>

<div style="background: #dddddd; padding: 2em 0 2em 0">

    <div class="container">

        <div class="row">
            <div class="col-md-12 text-center">
                <h2>Branżowe serwisy Polskiej Giełdy Nieruchomości</h2>
            </div>
        </div>
<?= $section1['content'] ?>

    </div>

</div>

<div style="background: #eeeeee; padding: 2em 0 2em 0">

    <div class="container">

        <div class="row">
            <div class="col-md-12 text-center">
                <h2>Serwisy prasowe dla samorządów i instytucji publicznych</h2>
            </div>
        </div>
<?= $section2['content'] ?>

    </div>

</div>

<div class="parallax">


    <div class="container" style="padding: 2em 0 2em 0">

        <div class="row">
            <div class="col-md-12 text-center">
                <h2>Nasi partnerzy</h2>
            </div>
        </div>

<?= $section3['content'] ?>

    </div>

    <div class="container" style="padding: 2em 0 2em 0">

        <div class="row">

            <div class="col-md-12 text-center">                    
                <img style="border-radius: 5px" src="<?= base_url() ?>img/pgn_5.png" alt="polska giełda nieruchomości komercyjnych" />
            </div>

        </div>

    </div>

</div>