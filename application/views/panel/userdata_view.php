<style>
    input {
        height: 23px;
    }

    input[type=submit]{
        height: 30px
    }

</style>

<div style="background: #eeeeee; padding: 8em 0 2em 0">
    <div class="container">
        <div class="col-md-3">
            <?php
                $this->load->view('panel/leftmenu_panel');
            ?>
        </div>

        <div class="col-md-9" style="padding-left: 1em">
            <div class="panel panel-primary">
                <div class="panel-heading">Dane użytkownika</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-6 col-md-2" style="font-weight: bold">
                            <p>E-mail: </p>
                            <p>Nazwa: </p>
                            <p>Ulica: </p>
                            <p>Miasto: </p>
                            <p>Kod pocztowy: </p>
                            <p>NIP: </p>
                            <p>Tel.: </p>
                            <p>Prześlij logo:</p>
                            <p>Nowe hasło:</p>
                            <p>Powtórz:</p>
                            <p><br/></p>
                        </div>

                        <div class="col-xs-6 col-md-6">
                            <p><?= $userdata['mail'] ?></p>
                            <form action="<?= site_url('panel/userdata') ?>" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                <?php
                                ($userdata['company'] != '') ? $default_company = $userdata['company'] : $default_company = $userdata['name'];

                                $data = array(
                                    'id' => 'company',
                                    'name' => 'company',
                                    'maxlenght' => '255',
                                    'value' => set_value('company', $default_company)
                                );

                                echo '<p>';
                                echo form_input($data);
                                echo '</p>';
                                ?>                                    

                                <?php
                                ($userdata['street'] != '') ? $default_street = $userdata['street'] : $default_street = $userdata['name'];

                                $data = array(
                                    'id' => 'street',
                                    'name' => 'street',
                                    'maxlenght' => '255',
                                    'value' => set_value('street', $default_street)
                                );

                                echo '<p>';
                                echo form_input($data);
                                echo '</p>';
                                ?>                                    

                                <?php
                                ($userdata['town'] != '') ? $default_town = $userdata['town'] : $default_town = $userdata['name'];

                                $data = array(
                                    'id' => 'town',
                                    'name' => 'town',
                                    'maxlenght' => '255',
                                    'value' => set_value('town', $default_town)
                                );

                                echo '<p>';
                                echo form_input($data);
                                echo '</p>';
                                ?>                                    

                                <?php
                                ($userdata['postal'] != '') ? $default_postal = $userdata['postal'] : $default_postal = $userdata['name'];

                                $data = array(
                                    'id' => 'postal',
                                    'name' => 'postal',
                                    'maxlenght' => '6',
                                    'value' => set_value('postal', $default_postal)
                                );

                                echo '<p>';
                                echo form_input($data);
                                echo '</p>';
                                ?>                                    

                                <?php
                                ($userdata['nip'] != '') ? $default_nip = $userdata['nip'] : $default_nip = $userdata['name'];

                                $data = array(
                                    'id' => 'nip',
                                    'name' => 'nip',
                                    'maxlenght' => '13',
                                    'value' => set_value('nip', $default_nip)
                                );

                                echo '<p>';
                                echo form_input($data);
                                echo '</p>';
                                ?>                                    

                                <?php
                                ($userdata['phone'] != '') ? $default_phone = $userdata['phone'] : $default_phone = $userdata['name'];

                                $data = array(
                                    'id' => 'phone',
                                    'name' => 'phone',
                                    'maxlenght' => '22',
                                    'value' => set_value('phone', $default_phone)
                                );
                                echo '<p>';
                                echo form_input($data);
                                echo '</p>';
                                ?>                                    
                                <p><input type="file" name="img1" /></p>
                                <?php echo form_error('password'); ?>
                                <p><input type="password" name="password" maxlenght="255" /></p>
                                <?php echo form_error('repeat'); ?>
                                <p><input type="password" name="repeat" maxlenght="255" /></p>
                                <input style="margin-left: 89px" type="submit" class="btn btn-danger" value="Zapisz zmiany" />
                            </form>
                        </div>

                        <div class="col-xs-12 col-md-4">
                            <img class="img-responsive right" src="<?= $this->session->userdata('logo') ?>" alt="" />
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-xs-12">

<?php echo form_error('company'); ?>
<?php echo form_error('street'); ?>
<?php echo form_error('town'); ?>
<?php echo form_error('postal'); ?>
<?php echo form_error('nip'); ?>
<?php echo form_error('phone'); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>                   