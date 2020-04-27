<div style="background: #eeeeee; padding: 8em 0 2em 0">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-primary">
                    <div class="panel-heading text-center">Nowe hasło</div>
                    <div class="panel-body">
                        <p>Jeżeli nie pamiętasz swojego hasła, wpisz adres e-mail, którego użyłeś w czasie rejestracji, aby wygenerować nowe hasło.</p>
                        <form action="<?= site_url('panel/remember') ?>" method="post" class="form">
                            <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
                            <?php
                            echo '<div class="form-group">';
                            echo $error;
                            echo form_error('mail');
                            $data = array(
                                'id' => 'mail',
                                'name' => 'mail',
                                'class' => 'form-control',
                                'value' => set_value('mail', ''),
                                'maxlegth' => '128',
                                'placeholder' => 'Twój e-mail'
                            );

                            echo form_input($data);
                            echo '</div>';
                            ?>
                            <div class="form-group">
                                <button class="btn btn-success form-control">Wygeneruj nowe hasło</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="padding-left: 1em"></div>
        </div>
    </div>
</div>