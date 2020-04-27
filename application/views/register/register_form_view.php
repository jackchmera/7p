<div style="background: #eeeeee; padding: 8em 0 2em 0">
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="padding-left: 1em">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <?php
                        switch ($type) {

                            case '1': $type_name = 'Użytkownik indywidualny';
                                break;
                            case '2': $type_name = 'Biuro nieruchomości';
                                break;
                            case '3': $type_name = 'Deweloper';
                                break;
                        }
                        ?>
                        <h2>Rejestracja użytkownika: <?= $type_name ?></h2>
                        <a style="color: white" href="<?= site_url('rejestracja') ?>">zmień</a>
                    </div>

                    <div class="panel-body">

                        <form action="<?= site_url('rejestracja/' . $type) ?>" method="post">

                            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                            <input type="hidden" name="type" value="<?= $type ?>" />

                            <div class="form-group">
                                <div class="col-md-12"><h4>Dane ogólne</h4></div>
                                <!--<hr/>-->
                            </div>

                            <div class="form-group col-md-12">
                                <?php
                                $data = array(
                                    'title' => 'E-mail',
                                    'name' => 'mail',
                                    'maxlenght' => '128',
                                    'value' => set_value('mail', ''),
                                    'placeholder' => 'Twój adres e-mail',
                                    'class' => 'form-control'
                                );
                                echo '<div class="col-md-12">' . form_label('E-mail <sup>*</sup>', 'mail') . '</div>';
                                echo '<div class="col-md-5">' . form_input($data) . '</div>';
                                echo form_error('mail');
                                ?>
                            </div>

                            <div class="form-group col-md-12">
                                <?php
                                $data = array(
                                    'title' => 'Hasło',
                                    'name' => 'password',
                                    'maxlenght' => '255',
                                    'value' => set_value('password', ''),
                                    'placeholder' => 'Hasło',
                                    'class' => 'form-control'
                                );
                                echo '<div class="col-md-12">' . form_label('Hasło <sup>*</sup>', 'password') . '</div>';
                                echo '<div class="col-md-5">' . form_password($data) . '</div>';
                                echo form_error('password');
                                ?>
                            </div>

                            <div class="form-group col-md-12">
                                <?php
                                $data = array(
                                    'title' => 'Powtórz hasło',
                                    'name' => 'confirm_password',
                                    'maxlenght' => '255',
                                    'value' => set_value('confirm_password', ''),
                                    'placeholder' => 'Powtórz hasło',
                                    'class' => 'form-control'
                                );
                                echo '<div class="col-md-12">' . form_label('Powtórz hasło <sup>*</sup>', 'confirm_password') . '</div>';
                                echo '<div class="col-md-5">' . form_password($data) . '</div>';
                                echo form_error('confirm_password');
                                ?>
                            </div>

                            <?php
                            if ($type != '1') {
                                ?>

                                <div class="form-group col-md-12">
                                    <?php
                                    $data = array(
                                        'title' => 'Nazwa firmy',
                                        'name' => 'company',
                                        'maxlenght' => '255',
                                        'value' => set_value('company', ''),
                                        'placeholder' => 'Nazwa firmy',
                                        'class' => 'form-control'
                                    );
                                    echo '<div class="col-md-12">' . form_label('Nazwa firmy <sup>*</sup>', 'company') . '</div>';
                                    echo '<div class="col-md-5">' . form_input($data) . '</div>';
                                    echo form_error('company');
                                    ?>
                                </div>

                                <div class="form-group col-md-12">
                                    <?php
                                    $data = array(
                                        'title' => 'NIP',
                                        'name' => 'nip',
                                        'maxlenght' => '13',
                                        'value' => set_value('nip', ''),
                                        'placeholder' => 'NIP',
                                        'class' => 'form-control'
                                    );
                                    echo '<div class="col-md-12">' . form_label('NIP <sup>*</sup>', 'company') . '</div>';
                                    echo '<div class="col-md-5">' . form_input($data) . '</div>';
                                    echo form_error('nip');
                                    ?>
                                </div>

                                <div class="form-group col-md-12">
                                    <?php
                                    $data = array(
                                        'title' => 'Licencja',
                                        'name' => 'license',
                                        'maxlenght' => '45',
                                        'value' => set_value('license', ''),
                                        'placeholder' => 'Numer twojej licencji - jeśli posiadasz',
                                        'class' => 'form-control'
                                    );
                                    echo '<div class="col-md-12">' . form_label('Numer licencji', 'license') . '</div>';
                                    echo '<div class="col-md-5">' . form_input($data) . '</div>';
                                    echo form_error('license');
                                    ?>
                                </div>

                                <?php
                            }
                            ?>

                            <div class="form-group">
                                <div class="col-md-12"><hr/></div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12"><h4>Adres</h4></div>
                            </div>

                            <div class="form-group col-md-12">

                                <div class="col-md-3">                                            
                                    <?php
                                    $data = array(
                                        'title' => 'Ulica i numer budynku',
                                        'name' => 'street',
                                        'maxlenght' => '255',
                                        'value' => set_value('street', ''),
                                        'placeholder' => 'Ulica i numer budynku',
                                        'class' => 'form-control'
                                    );
                                    echo form_label('Ulica i numer budynku <sup>*</sup>', 'street');
                                    echo form_input($data);
                                    echo form_error('street');
                                    ?>
                                </div>

                                <div class="col-md-3">                                            
                                    <?php
                                    $data = array(
                                        'title' => 'Kod pocztowy',
                                        'name' => 'postal',
                                        'maxlenght' => '6',
                                        'value' => set_value('postal', ''),
                                        'placeholder' => 'Kod pocztowy',
                                        'class' => 'form-control'
                                    );
                                    echo form_label('Kod pocztowy <sup>*</sup>', 'postal');
                                    echo form_input($data);
                                    echo form_error('postal');
                                    ?>
                                </div>

                                <div class="col-md-3">                                            
                                    <?php
                                    $data = array(
                                        'title' => 'Miejscowość',
                                        'name' => 'town',
                                        'maxlenght' => '255',
                                        'value' => set_value('town', ''),
                                        'placeholder' => 'Miejscowość',
                                        'class' => 'form-control'
                                    );
                                    echo form_label('Miejscowość <sup>*</sup>', 'town');
                                    echo form_input($data);
                                    echo form_error('town');
                                    ?>
                                </div>

                            </div>


                            <div class="form-group">
                                <div class="col-md-12"><hr/></div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12"><h4>Kontakt</h4></div>
                                <hr/>
                            </div>

                            <div class="form-group col-md-12">

                                <div class="col-md-3">                                            
                                    <?php
                                    $data = array(
                                        'title' => 'Imię i nazwisko',
                                        'name' => 'name',
                                        'maxlenght' => '255',
                                        'value' => set_value('name', ''),
                                        'placeholder' => 'Imię i nazwisko',
                                        'class' => 'form-control'
                                    );
                                    echo form_label('Imię i nazwisko <sup>*</sup>', 'name');
                                    echo form_input($data);
                                    echo form_error('name');
                                    ?>
                                </div>

                                <div class="col-md-3">                                            
                                    <?php
                                    $data = array(
                                        'title' => 'Numer telefonu',
                                        'name' => 'phone',
                                        'maxlenght' => '22',
                                        'value' => set_value('phone', ''),
                                        'placeholder' => 'Numer telefonu',
                                        'class' => 'form-control'
                                    );
                                    echo form_label('Numer telefonu <sup>*</sup>', 'phone');
                                    echo form_input($data);
                                    echo form_error('phone');
                                    ?>
                                </div>

                            </div>

                            <div class="form-group">
                                <div class="col-md-12"><hr/></div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12"><h4>Pozostałe</h4></div>
                                <hr/>
                            </div>

                            <div class="form-group col-md-12">
                                <p><input type="checkbox" name="check1" value="1" <?php echo set_checkbox('check1', '1'); ?> /> Zapoznałem się i akceptuję <a href="<?= site_url('otherpages/49/78') ?>">regulamin</a> serwisu domPGN.pl. <sup>*</sup></p>
                                <p><?= form_error('check1'); ?></p>
                            </div>

                            <div class="form-group col-md-12">
                                <p><input type="checkbox" name="check2" value="1" <?php echo set_checkbox('check2', '1'); ?> /> Wyrażam zgodę, na przetwarzanie moich danych osobowych przez PGN z siedzibą w Kłodzku (57-300 Kłodzko, ul. Bohaterów Getta 11), w celu świadczenia usług w ramach serwisu domPGN.pl. <sup>*</sup></p>
                                <p><?= form_error('check2'); ?></p>
                            </div>


                            <div class="form-group col-md-12">
                                <div class="col-md-12"><button style="float:right" class="btn btn-primary">Publikuj</button></div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>