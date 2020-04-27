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
                    <div class="panel-heading">Płatność</div>
                    <div class="panel-body">
                        <?php
                        // jesli konto jest aktywne - oplacone lub nie
                        if ($user['notActive'] && $user['type'] == '1') {
                            ?>
                            <p>Konto nie jest aktywne.</p>
                            <p>W celu uzyskania możliwości promowania ofert w naszym serwisie - prosimy o aktywowanie konta.</p>
                            <p><a href="https://ssl.dotpay.pl/t2/?id=235261&amount=29&description=Aktywacja na 3 miesiące&control=<?= $user['id'] ?>&email=<?= $user['mail'] ?>&url=http://www.dompgn.pl/index.php/panel/payment&urlc=http://www.dompgn.pl/index.php/payment/confirmDotpay"><button class="btn btn-warning form-control">Aktywacja na 3 miesiące: 29zł</button></a></p>
                            <p><a href="https://ssl.dotpay.pl/t2/?id=235261&amount=49&description=Aktywacja na 6 miesiące&control=<?= $user['id'] ?>&email=<?= $user['mail'] ?>&url=http://www.dompgn.pl/index.php/panel/payment&urlc=http://www.dompgn.pl/index.php/payment/confirmDotpay"><button class="btn btn-danger form-control">Aktywacja na 6 miesiące: 49zł</button></a></p>
    <?php
} elseif ($user['type'] == '1') {
    echo '<p>Konto jest aktywne do: ' . $user['active'] . '</p>';
} else {
    ?>
                            <p>Aktualnie korzystają Państwo z 3 miesięcznego okresu bezpłatnego.</p>
                            <p><a href="<?= site_url('panel/panel') ?>"><button class="btn btn-primary">Powrót</button></a></p>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>                   