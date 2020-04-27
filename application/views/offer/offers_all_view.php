<div style="background: #eeeeee; padding: 8em 0 2em 0">

    <div class="container">

        <div class="row">

            <div class="col-xs-12 col-md-6">

                <div class="panel panel-default">
                    <div class="panel-heading text-center"><h5>Sortowanie po cenie</h5></div>

                    <div class="panel-body">
                        <?php ($sort == '0') ? $btn = 'btn-primary' : $btn = 'btn-default'; ?>
                        <a class="btn <?= $btn ?> col-md-6" href="<?= base_url() . 'index.php/' . $method . '/0/' . $offset ?>">Od najniższej</a>
                        <?php ($sort == '1') ? $btn = 'btn-primary' : $btn = 'btn-default'; ?>
                        <a class="btn <?= $btn ?> col-md-6" href="<?= base_url() . 'index.php/' . $method . '/1/' . $offset ?>">Od najwyższej</a>
                    </div>
                </div>

            </div>

            <div class="col-xs-12 col-md-6">

                <div class="panel panel-default">
                    <div class="panel-heading text-center"><h5>Sortowanie po dacie publikacji</h5></div>

                    <div class="panel-body">
                        <?php ($sort == '2') ? $btn = 'btn-primary' : $btn = 'btn-default'; ?>
                        <a class="btn <?= $btn ?> col-md-6" href="<?= base_url() . 'index.php/' . $method . '/2/' . $offset ?>">Od najnowszych</a>
                        <?php ($sort == '3') ? $btn = 'btn-primary' : $btn = 'btn-default'; ?>
                        <a class="btn <?= $btn ?> col-md-6" href="<?= base_url() . 'index.php/' . $method . '/3/' . $offset ?>">Od najwcześniejszych</a>
                    </div>
                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-md-9">

                <?php
                foreach ($offers as $key) {
                    ?>

                    <div class="panel panel-info">
                        <div class="panel-heading text-center"><h4><?= $key['type_name'] ?></h4>
                            <!--<hr/>--><br/>
    <?= $key['type_name'] ?> na sprzedaż <?= $key['town'] ?></div>

                        <div class="panel-body">
                            <a href="<?= site_url('oferta/' . $key['id']) ?>">
                                <div class="col-md-5">

    <?php
    if ($key['main_image']['name'] == '') {

        $key['main_image']['name'] = 'logo.png';
        ?>

                                        <img class="img-responsive offer-img" src="<?= base_url() ?>img/logo.png" />

        <?php
    } else {
        ?>

                                        <img class="img-responsive offer-img" src="<?= base_url() ?>imports/<?= $key['ftp']['directory'] ?>/unziped/<?= $key['main_image']['name'] ?>" />
                                    <?php } ?>
                                </div>

                                <div class="col-md-7">
                                    <p><?= $key['town'] ?></p>
                                    <?php if ($key['type'] != '5') { ?>
                                        <p><?= $key['rooms'] ?> pokoje</p>
    <?php } ?>
                                    <p><?= $key['area'] ?> m<sup>2</sup> (<?= intval($key['price'] / $key['area']) ?> zł / m<sup>2</sup>)</p>
                                    <?php
                                    if ($key['full_area'] != '') {
                                        echo '<p>Działka ' . $key['full_area'] . ' m<sup>2</sup></p>';
                                    }
                                    ?>
                                    <p>PGN</p>
                                    <hr/>
                                    <p><div class="btn btn-block btn-success"><?= $key['price'] ?> zł</div></p>
                                </div>
                            </a>
                        </div>
                    </div>



    <?php
}

echo $this->pagination->create_links();
?>

            </div>

            <div class="col-md-3 text-center">

                <?= $banners['content'] ?>

            </div>

        </div>

    </div>

</div>