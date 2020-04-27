<div style="background: #eeeeee; padding: 8em 0 2em 0">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <p>Zaloguj się, aby publikować swoje oferty.</p>
                <p>Jeżeli nie masz jeszcze konta, zarejestruj się.</p>
            </div>
        </div>

        <div class="row">

            <div class="col-md-8">

                <div class="panel panel-primary">

                    <div class="panel-heading text-center">Zaloguj się</div>

                    <div class="panel-body">
                        <form action="<?= site_url('zaloguj') ?>" method="post" class="form">
                            
                            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

                            <?php
                            echo '<div class="form-group">';
                            echo form_error('mail_login');
                            $data = array(
                                'id' => 'mail_login',
                                'name' => 'mail_login',
                                'class' => 'form-control',
                                'value' => set_value('mail_login', ''),
                                'maxlegth' => '64',
                                'placeholder' => 'Twój e-mail'
                            );

                            echo form_input($data);
                            echo '</div>';
                            ?>

                            <?php
                            echo '<div class="form-group">';
                            echo form_error('pass_login');
                            $data = array(
                                'id' => 'pass_login',
                                'name' => 'pass_login',
                                'class' => 'form-control',
                                'value' => set_value('pass_login', ''),
                                'maxlegth' => '64',
                                'placeholder' => 'Hasło'
                            );

                            echo form_password($data);
                            echo '</div>';
                            ?>  

                            <div class="form-group">
                                <button class="btn btn-success form-control">Zaloguj się</button>
                            </div>

                            <div class="form-group text-right">
                                <p><a href="<?= site_url('panel/remember') ?>">Zapomniałem\am hasła</a></p>
                            </div>

                        </form>
                    </div>

                </div>

            </div>

            <div class="col-md-4" style="padding-left: 1em">

                <div class="panel panel-danger">
                    <div class="panel-heading text-center">
                        Zarejestruj się
                    </div>

                    <div class="panel-body">

                        <p>Nie masz jeszcze konta?</p>
                        <p>Dowiedz się jakie uzyskasz korzyści i się zarejestruj.</p>

                        <div class="form-group">
                            <a href="<?= site_url('rejestracja') ?>"><button class="btn btn-danger form-control">Zarejestruj się</button></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>