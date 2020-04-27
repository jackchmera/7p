<form action="<?= site_url('wyszukiwanie') ?>" method="POST" id="clickable" name="clickable" class="col-md-8">

    <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />

    <div id="search">

        <div class="row" >
            <div class="col-md-12"><h3 style="padding:0; margin: 0">Czego szukasz?</h3></div>
        </div>

        <div class="row" style="margin-top: 1em">

            <div class="col-md-3">
                <label for="type">Rodzaj</label>
                <select id="type" name="type" class="form-control">
                    <?php
                    foreach ($kinds as $key) {

                        echo '<option value="' . $key['id'] . '">' . $key['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-3">
                <label for="rent_sold">Typ</label>
                <select id="rent_sold" name="rent_sold" class="form-control">
                    <option value="1">Sprzedaż</option>
                    <option value="0">Wynajem</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="no">Numer ogłoszenia</label>
                <input type="text" class="form-control" id="no" name="no" placeholder="Numer ogłoszenia">
            </div>

            <div class="col-md-3">
                <label for="area_from">Powierzchnia (od - do)</label><br/>
                <input type="text" class="" style="width: 40%" id="area_from" name="area_from" placeholder="Od" > -
                <input type="text" class="" style="width: 40%"   id="area_to" name="area_to" placeholder="Do" >
            </div>
        </div>

        <div class="row" style="padding-top: 1em">
            <div class="col-md-3">
                <label for="voivodeships">Województwo</label>
                <select id="voivodeships" name="voivodeships" class="form-control" onChange="districts()">
                    <option value="0">Cała Polska</option>
<?php
foreach ($voivodeships as $key) {

    echo '<option value="' . $key['id'] . '">' . $key['name'] . '</option>';
}
?>
                </select>
            </div>

            <div class="col-md-3">
                <label for="district">Powiat</label>
                <select id="district" name="district" class="form-control">
                    <option value="0">Wszystkie</option>
<?php
/* AJAX is filling out options */
?>
                </select>
            </div>

            <div class="col-md-3">
                <label for="town">Miejscowość / Gmina</label>
                <input type="text" class="form-control" id="town" name="town" placeholder="Miejscowość">
            </div>

            <div class="col-md-3">
                <label for="price">Cena</label><br/>
                <input type="text" class="" id="price_from" name="price_from" style="width: 40%" placeholder="Od" > -
                <input type="text" class="" id="price_to" name="price_to" style="width: 40%" placeholder="Do" >
            </div>
        </div>

    </div>

    <div class="row" style="margin-top: 2em">
        <div class="col-md-12">
            <input class="btn btn-default btn-lg" type="submit" value="Wyszukaj" />
        </div>
    </div>

    <div class="row" style="padding-top: 1em">
        <div class="col-md-12">

            <a href="#0" class="cd-top2"><img class="animated bounce" src="<?= base_url() ?>img/cd-top-arrow.svg" alt="nieruchomości"/></a>
        </div>
    </div>

</form>

<script type="text/javascript">

    // AJAX for DISTRICTS to SEARCH FORM
    function districts() {

        var e = document.getElementById('voivodeships');
        var index = e.options[e.selectedIndex].value;

        var form_data = {
<?= $csrf['name'] ?>: '<?= $csrf['hash'] ?>',
            index: index
        };

        $.ajax({
            url: "index.php/ajax/districts",
            type: 'POST',
            data: form_data,
            cache: false,
            success: function (msg) {
                x = document.getElementById('district').innerHTML = msg;
            }
        });

    }

</script>

