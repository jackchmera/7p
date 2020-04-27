<div style="background: #eeeeee; padding: 8em 0 2em 0">

    <div class="container">

        <div class="row">

            <div class="col-md-3">

                <?php
                $this->load->view('otherpages/partials/left_nav');
                ?>

            </div>

            <div class="col-md-9" style="padding-left: 1em">

<?php
if (empty($posts)) {
    ?>

                    <div class="panel panel-primary">
                        <div class="panel-heading"><?= $content['name'] ?></div>
                        <div class="panel-body">
    <?php
    echo $content['content'];
    ?>
                        </div>
                    </div>
                            <?php
                        } else {


                            foreach ($posts as $key) {

                                if ($key['min'] == 'sNULL') {
                                    $img = base_url() . 'img/logo.png';
                                } else {
                                    $img = base_url() . 'posts_img/' . $key['min'];
                                }
                                ?>

                        <a href="<?= site_url('news/' . $id . '/' . $key['id']) ?>">
                            <div class="panel panel-primary">
                                <div class="panel-heading"><h4><?= $key['name'] ?></h4><div style="position: absolute; margin-top: -30px; right: 30px"><?= $key['added'] ?></div></div>
                                <div class="panel-body">

                                    <img align="left" style="max-width: 35%" src="<?= $img ?>" alt="<?= $key['name'] ?>" />

        <?php
        echo $key['short'];
        ?>

                                </div>
                            </div>
                        </a>                        

                                    <?php
                                }
                            }
                            ?>

            </div>
        </div>

    </div>

</div>