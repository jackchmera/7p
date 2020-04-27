<div style="background: #eeeeee; padding: 8em 0 2em 0">

    <div class="container">

        <div class="row">

            <div class="col-md-3">

                <div class="panel panel-info">
                    <div class="panel-heading text-center"><h4><?= $offer['price']; ?> zł</h4></div>

                    <div class="panel-body text-center">
                        <h3>PGN</h3>
                        <img class="img-responsive" src="<?= $logo['logo'] ?>" alt="PGN" />
                        <p>Biuro nieruchomości</p>
                        <hr/>
                        <p><b><?= $offer['agent_name']; ?></b></p>
                        <p><b>Tel.</b> <?= $offer['agent_tel_kom']; ?></p>
                        <p><b>E-mail:</b> <?= $offer['agent_email']; ?></p>
                    </div>
                </div>

                <div class="panel panel-success">
                    <div class="panel-heading text-center">Zapytaj ogłoszeniodawcę</div>

                    <div class="panel-body">
                        <form class="form" action="<?= site_url('oferta/' . $offer['id']) ?>" method='post'>

                            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                            
                            <div class="bots">

                                <input id="forbots" name="forbots" type="text" value="" />
                                <input id="noobsaibot" name="noobsaibot" type="text" value="ążść" />

                            </div>

                            <div class="form-group">
                                <?php echo form_error('mail'); ?>
                                <input class="form-control" id="mail" name="mail" type="text" maxlength="128" placeholder="Twój e-mail" value="<?= set_value('mail') ?>" />
                            </div>
                            <div class="form-group">
                                <?php echo form_error('phone'); ?>
                                <input class="form-control" id="phone" name="phone" type="text" maxlength="22" placeholder="Twój numer telefonu" value="<?= set_value('phone') ?>" />
                            </div>
                            <div class="form-group">
                                <?php echo form_error('message'); ?>
                                <?php $message = "Ta oferta wydaje mi się interesujące.

Chętnie poznam więcej szczegółów przed umówieniem wizyty.

Pozdrawiam."; ?>
                                <textarea style="resize: none; height: 250px" id="message" name="message" class="form-control"><?= set_value('message', $message) ?>
                                </textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success form-control">Wyślij</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            <!--<div class="col-md-1"></div>-->

            <div class="col-md-9" style="padding-left: 1em">

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h2><?= $offer['town'] ?> - <?= $offer['type_name'] ?> - <?= $offer['area']; ?> m2</h2>
                        <p>Na sprzedaż <?= $offer['type_name'] ?>, <?= $offer['town']; ?>, <?= $offer['voivodeship_name']; ?>, powiat <?= $offer['community']; ?></p>
                        <p><b>Numer oferty:</b> <?= $offer['no'] ?></p>
                        <p><a style="color: #fff; font-weight: bold" href="<?= site_url('pdf/' . $offer['id']) ?>"><span style="font-size:22px" class="glyphicon glyphicon-print"></span></a></p>
                    </div>

                    <div class="panel-body">

                        <div id="gallery">
                            <?php
                            foreach ($offer['images'] as $key) {

                                echo '<a href="' . base_url() . 'imports/' . $offer['ftp']['directory'] . '/unziped/' . $key['name'] . '"><img src="' . base_url() . 'imports/' . $offer['ftp']['directory'] . '/unziped/' . $key['name'] . '" alt="Nieruchomości" /></a>';
                            }
                            ?>

                        </div>

                        <script type="text/javascript">
                            $(function () {
                                $('#gallery').jGallery();
                            });
                        </script>

                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead class="text-center">
                                <th class="text-center">Cena</th>
                                <th class="text-center">Powierzchnia</th>
                                <th class="text-center">Liczba pokoi</th>
                                <th class="text-center">Piętro</th>
                                </thead>
                                <tr>
                                    <td><?= $offer['price']; ?> zł<br/><span style="color: gray; font-size: 0.9em"><?= intval($offer['price'] / $offer['area']); ?> / m<sup>2</sup></span></td>
                                    <td><?= $offer['area']; ?> m<sup>2</sup></td>
                                    <td>
<?php if ($offer['type'] != '5') { ?>
    <?= $offer['rooms']; ?>
                                        <?php } ?>
                                    </td>
                                    <td><?= $offer['floor']; ?> / <?= $offer['floors']; ?> </td>
                                </tr>
                            </table>

                            <p><b>Opis:</b></p>
                            <div style='text-align: justify'><?= $offer['description']; ?></div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-center">
                                <hr/>
                                <p class="bold">Odwiedziny</p>
                                <div class="counter"><?= $offer['count'] ?></div>            
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

</div>