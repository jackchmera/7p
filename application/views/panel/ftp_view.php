<div style="background: #eeeeee; padding: 8em 0 2em 0">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php
                $this->load->view('panel/leftmenu_panel');
                ?>
            </div>

            <div class="col-md-9" style="padding-left: 1em">
                <div class="panel panel-primary">
                    <div class="panel-heading">Rejestracja konta wymiany danych</div>
                    <div class="panel-body">
                        <p>Dziękujemy za przesłanie zgłoszenia.</p>
                        <p>W ciągu 48 godzin na twój adres zostaną przasłane dane niezbędne do korzystania z konta wymiany danych</p>
                        <p><a href="<?= site_url('panel/panel') ?>"><button class="btn btn-primary">Powrót</button></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>