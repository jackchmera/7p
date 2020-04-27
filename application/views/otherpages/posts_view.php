<div style="background: #eeeeee; padding: 8em 0 2em 0">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php
                $this->load->view('otherpages/partials/posts_nav');
                ?>
            </div>

            <div class="col-md-9" style="padding-left: 1em">

                <div class="panel panel-primary">
                    <div class="panel-heading"><h2 style="font-weight: bold"><?= $content['name'] ?></h2></div>

                    <div class="panel-body">
                        <p><?= $content['added'] ?></p>

                        <?php
                        if ($content['max'] == 'NULL') {
                            $img = base_url() . 'img/logo.png';
                        } else {
                            $img = base_url() . 'posts_img/' . $content['max'];
                        }

                        echo '<img align="right" style="max-width: 35%" src="' . $img . '" alt="' . $content['name'] . '" />';
                        ?>

                        <?= $content['content'] ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>