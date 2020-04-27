<div style="background: #eeeeee; padding: 8em 0 2em 0">
    <div class="container">
        <div class="row">
            <div class="col-md-3">

                <?php if (!$this->session->userdata('login')) { ?>
                    <div class="panel panel-success">
                        <div class="panel-heading text-center"><h4>Prowadzisz biuro nieruchomości lub jesteś deweloperem?</h4></div>

                        <div class="panel-body">
                            <a href="<?= site_url('zaloguj') ?>"><button class="btn btn-warning form-control">Zaloguj się</button></a>
                            <hr/>
                            <p>Nie masz jeszcze konta?</p>
                            <a href="<?= site_url('rejestracja') ?>"><button class="btn btn-danger form-control">Zarejestruj się </button></a>
                        </div>
                    </div>
                <?php
                } else {

                    $this->load->view('panel/leftmenu_panel');
                }
                ?>
            </div>

            <div class="col-md-9" style="padding-left: 1em">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h2>Dodawanie oferty</h2>
                    </div>

                    <div class="panel-body">
                        <p>Co jest przedmiotem oferty?</p>
                        <p><a href="<?= site_url('dodaj/1') ?>"><button class="btn btn-primary form-control">Obiekt komercyjny</button></a></p>
                        <p><a href="<?= site_url('dodaj/2') ?>"><button class="btn btn-warning form-control">Domy</button></a></p>
                        <p><a href="<?= site_url('dodaj/3') ?>"><button class="btn btn-danger form-control">Mieszkania</button></a></p>
                        <p><a href="<?= site_url('dodaj/4') ?>"><button class="btn btn-success form-control">Lokale użytkowe</button></a></p>
                        <p><a href="<?= site_url('dodaj/5') ?>"><button class="btn btn-default form-control">Działki</button></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>