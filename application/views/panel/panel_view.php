<div style="background: #eeeeee; padding: 8em 0 2em 0">
    <div class="container">
        <div class="row">
            <div class="col-md-3 text-center">
                <?php $this->load->view('panel/leftmenu_panel'); ?>
            </div>

            <div class="col-md-9">
                <?php
                foreach ($offers as $key) {
                    ?>

                    <div class="panel panel-info">
                        <div class="panel-heading text-center"><h4><?= $key['type_name'] ?></h4><hr/><?= $key['type_name'] ?> na sprzedaż <?= $key['town'] ?></div>

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
                                    <p><?= $key['rooms'] ?> pokoje</p>
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
        </div>
    </div>
</div>