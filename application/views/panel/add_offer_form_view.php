
<div style="background: #eeeeee; padding: 8em 0 2em 0">

    <div class="container">

        <div class="row">

            <div class="col-md-3">

                <?php if (!$this->session->userdata('login')) { ?>
                    <div class="panel panel-success">
                        <div class="panel-heading text-center"><h4>Jesteś pośrednikiem?</h4></div>

                        <div class="panel-body">
                            <a href="<?= site_url('login') ?>"><button class="btn btn-warning form-control">Zaloguj się</button></a>
                            <hr/>
                            <p>Nie masz jeszcze konta?</p>
                            <a href="<?= site_url('register') ?>"><button class="btn btn-danger form-control">Zarejestruj się </button></a>
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
                        <?php
                        switch ($type) {

                            case '1': $type_name = 'Obiekt komercyjny';
                                break;
                            case '2': $type_name = 'Dom';
                                break;
                            case '3': $type_name = 'Mieszkanie';
                                break;
                            case '4': $type_name = 'Lokal';
                                break;
                            case '5': $type_name = 'Działka';
                                break;
                        }
                        ?>
                        <h2>Dodawanie oferty: <?= $type_name ?></h2>
                        <a style="color: white" href="<?= site_url('dodaj') ?>">zmień</a>
                    </div>

                    <div class="panel-body">

                        <form action="<?= site_url('dodaj/' . $type) ?>" method="post">

                            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                            <input type="hidden" name="type" value="<?= $type ?>" />

                            <div class="form-group">
                                <?php
                                $data = array(
                                    'id' => 'title',
                                    'name' => 'title',
                                    'maxlenght' => '255',
                                    'value' => set_value('title', ''),
                                    'placeholder' => 'Tytuł oferty',
                                    'class' => 'form-control'
                                );
                                echo '<div class="col-md-12">' . form_label('Tytuł <sup>*</sup>', 'title') . '</div>';
                                echo '<div class="col-md-12">' . form_input($data) . '</div>';
                                echo form_error('title');
                                ?>
                            </div>

                            <div class="form-group">
                                <?php
                                $data = array(
                                    'id' => 'price',
                                    'name' => 'price',
                                    'maxlenght' => '9',
                                    'value' => set_value('price', ''),
                                    'placeholder' => 'Cena',
                                    'class' => 'form-control'
                                );
                                echo '<div class="col-md-12">' . form_label('Cena <sup>*</sup>', 'price') . '</div>';
                                echo '<div class="col-md-5"><div class="input-group"><div class="input-group-addon">PLN</div>' . form_input($data) . '<div class="input-group-addon">.00</div></div></div>';
                                echo form_error('price');
                                ?>
                            </div>


                            <?php
                            if ($type != '5') {
                                ?>

                                <div class="form-group">
                                    <?php
                                    $data = array(
                                        'id' => 'area',
                                        'name' => 'area',
                                        'maxlenght' => '9',
                                        'value' => set_value('area', ''),
                                        'placeholder' => 'Powierzchnia',
                                        'class' => 'form-control'
                                    );
                                    echo '<div class="col-md-12">' . form_label('Powierzchnia (w m<sup>2</sup>)', 'area') . '</div>';
                                    echo '<div class="col-md-5">' . form_input($data) . '</div>';
                                    echo form_error('area');
                                    ?>
                                </div>

                                <?php
                            }
                            ?>

                            <?php
                            if ($type == '1' || $type == '2' || $type == '5') {
                                ?>
                                <div class="form-group">
                                    <?php
                                    $data = array(
                                        'id' => 'full_area',
                                        'name' => 'full_area',
                                        'maxlenght' => '9',
                                        'value' => set_value('full_area', ''),
                                        'placeholder' => 'Powierzchnia działki',
                                        'class' => 'form-control'
                                    );
                                    echo '<div class="col-md-12">' . form_label('Powierzchnia działki (w m<sup>2</sup>)', 'full_area') . '</div>';
                                    echo '<div class="col-md-3">' . form_input($data) . '</div>';
                                    echo form_error('area');
                                    ?>
                                </div>

                                <?php
                            }
                            ?>


                            <?php
                            if ($type != '5') {
                                ?>

                                <div class="form-group">

                                    <div class="col-md-12">
                                        <label class="label-control" for="market">Rynek <sup>*</sup></label>
                                    </div>

                                    <div class="col-md-3">
                                        <select class="form-control" id="market" name="market">
                                            <option value="1">Pierwotny</option>
                                            <option value="2">Wtórny</option>
                                        </select>
                                    </div>

                                </div>

                                <?php
                            }
                            ?>

                            <div class="form-group">
                                <div class="col-md-12"><hr/></div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12"><h4>Lokalizacja</h4></div>
                                <hr/>
                            </div>

                            <div class="form-group col-md-12">

                                <div class="col-md-3">
                                    <label for="voivodeships">Województwo <sup>*</sup></label>
                                    <select id="voivodeships" name="voivodeships" class="form-control" onChange="districts()">
                                        <?php
                                        foreach ($voivodeships as $key) {

                                            echo '<option value="' . $key['id'] . '">' . $key['name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="district">Powiat <sup>*</sup></label>
                                    <select id="district" name="district" class="form-control">
                                        <?php
                                        foreach ($districts as $key) {

                                            echo '<option value="' . $key['id'] . '">' . $key['name'] . '</optnion>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-3">                                            
                                    <?php
                                    $data = array(
                                        'id' => 'community',
                                        'name' => 'community',
                                        'maxlenght' => '255',
                                        'value' => set_value('community', ''),
                                        'placeholder' => 'Gmina',
                                        'class' => 'form-control'
                                    );
                                    echo form_label('Gmina', 'community');
                                    echo form_input($data);
                                    echo form_error('community');
                                    ?>
                                </div>

                            </div>

                            <div class="form-group col-md-12">

                                <div class="col-md-3"> 
                                    <?php
                                    $data = array(
                                        'id' => 'town',
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

                                <div class="col-md-3"> 
                                    <?php
                                    $data = array(
                                        'id' => 'street',
                                        'name' => 'street',
                                        'maxlenght' => '255',
                                        'value' => set_value('street', ''),
                                        'placeholder' => 'Ulica lub osiedle',
                                        'class' => 'form-control'
                                    );
                                    echo form_label('Ulica lub osiedle', 'street');
                                    echo form_input($data);
                                    echo form_error('street');
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12"><hr/></div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12"><h4>Informacje szczegółowe</h4></div>
                                <hr/>
                            </div>

                            <div class="form-group">
                                <?php
                                $data = array(
                                    'id' => 'description',
                                    'name' => 'description',
                                    'value' => set_value('description', ''),
                                    'placeholder' => 'Opis szczegółowy',
                                    'class' => 'form-control'
                                );
                                echo '<div class="col-md-12">' . form_label('Opis <sup>*</sup>', 'description') . '</div>';
                                echo '<div class="col-md-12">' . form_textarea($data) . '</div>';
                                echo form_error('description');
                                ?>
                            </div>

                            <div class="form-group">

                                <?php
                                if ($type != '5') {
                                    ?>
                                    <div class="col-md-3">
                                        <label for="status">Stan wykończenia</label>
                                        <select id="status" class="form-control" name="status">
                                            <option value="">-</option>
                                            <option value="1">gotowy/a</option>
                                            <option value="2">do wykończenia</option>
                                            <option value="3">do remontu</option>
                                            <option value="4">stan surowy otwarty</option>
                                            <option value="5">stan surowy zamknięty</option>
                                        </select>    
                                    </div>

                                    <div class="col-md-3">
                                        <?php
                                        $data = array(
                                            'id' => 'year',
                                            'name' => 'year',
                                            'maxlenght' => '9',
                                            'value' => set_value('year', ''),
                                            'placeholder' => 'Rok budowy',
                                            'class' => 'form-control'
                                        );
                                        echo form_label('Rok budowy', 'year');
                                        echo form_input($data);
                                        echo form_error('year');
                                        ?>
                                    </div>

                                    <?php
                                } else {
                                    ?>
                                    <div class="col-md-3"> 
                                        <label for="area_type">Typ działki</label>
                                        <select id="area_type" class="form-control" name="area_type">
                                            <option value="">-</option>
                                            <option value="1">budowlana</option>
                                            <option value="2">rolna</option>
                                            <option value="3">rekreacyjna</option>
                                            <option value="4">pod inwestycję</option>
                                            <option value="5">leśna</option>
                                            <option value="6">rolno-budowlana</option>
                                            <option value="7">siedliskowa</option>
                                            <option value="8">inna</option>
                                        </select>
                                    </div>


                                    <?php
                                }

                                if ($type == '2') {
                                    ?>

                                    <div class="col-md-3"> 
                                        <label for="construction_kind">Rodzaj zabudowy</label>
                                        <select id="construction_kind" class="form-control" name="construction_kind">
                                            <option value="">-</option>
                                            <option value="1">wolnostojący</option>
                                            <option value="2">bliźniak</option>
                                            <option value="3">szeregowiec</option>
                                            <option value="4">kamienica</option>
                                            <option value="5">dworek/pałac</option>
                                            <option value="6">gospodarstwo</option>
                                        </select>
                                    </div>

                                    <?php
                                }
                                ?>
                                <?php
                                if ($type == '1') {
                                    ?>

                                    <div class="col-md-3"> 
                                        <label for="construction_type">Typ zabudowy</label>
                                        <select id="construction_type" class="form-control" name="construction_type">
                                            <option value="">-</option>
                                            <option value="1">stalowa</option>
                                            <option value="2">murowana</option>
                                            <option value="3">wiata</option>
                                            <option value="4">namiotowa</option>
                                            <option value="5">drewniana</option>
                                            <option value="6">szklana</option>
                                        </select>
                                    </div>

                                    <?php
                                }
                                ?>

                                <?php
                                if ($type == '2' || $type == '3' || $type == '4') {
                                    ?>

                                    <div class="col-md-3"> 
                                        <label for="rooms">Liczba pokoi</label>
                                        <select id="rooms" class="form-control" name="rooms">
                                            <option value="">-</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">10+</option>
                                        </select>
                                    </div>

                                    <?php
                                }
                                ?>

                                <?php
                                if ($type == '1' || $type == '2' || $type == '3') {
                                    ?>

                                    <div class="col-md-3"> 
                                        <label for="floors">Liczba pięter</label>
                                        <select id="floors" class="form-control" name="rooms">
                                            <option value="">-</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">3+</option>
                                        </select>
                                    </div>

                                    <?php
                                }
                                ?>

                                <?php
                                if ($type == '3' && $type == '4') {
                                    ?>

                                    <div class="col-md-3"> 
                                        <label for="floor">Piętro</label>
                                        <select id="floor" class="form-control" name="floor">
                                            <option value="">-</option>
                                            <option value="-1">suterena</option>
                                            <option value="0">parter</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">10+</option>
                                        </select>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                            if ($type = '5') {
                                ?>
                                <div class="form-group">
                                    <div class="col-md-12"><hr/></div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12"><h4>Działka posiada</h4></div>
                                    <hr/>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-2">
                                        <input type="checkbox" name="water" value="1" /> woda
                                    </div>
                                    <div class="col-md-2">
                                        <input type="checkbox" name="gas" value="1" /> gaz
                                    </div>
                                    <div class="col-md-2">
                                        <input type="checkbox" name="electric" value="1" /> prąd
                                    </div>
                                    <div class="col-md-2">
                                        <input type="checkbox" name="sewers" value="1" /> kanalizacja
                                    </div>

                                </div>

                                <div class="form-group">
                                    <div class="col-md-12"><hr/></div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12"><h4>Dojazd</h4></div>
                                    <hr/>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-4">
                                        <input type="checkbox" name="hard" value="1" /> utwardzony
                                    </div>
                                    <div class="col-md-4">
                                        <input type="checkbox" name="soft" value="1" /> nieutwardzony
                                    </div>
                                    <div class="col-md-4">
                                        <input type="checkbox" name="asfalt" value="1" /> asfaltowy
                                    </div>

                                </div>



                                <?php
                            }
                            ?>

                            <div class="form-group">
                                <div class="col-md-12"><hr/></div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12"><button style="float:right" class="btn btn-primary">Publikuj</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    // AJAX for DISTRICTS to ADD OFFER FORM
    function districts() {

        var e = document.getElementById('voivodeships');
        var index = e.options[e.selectedIndex].value;

        var form_data = {
<?= $csrf['name'] ?>: '<?= $csrf['hash'] ?>',
            index: index
        };

        $.ajax({
            url: "../../index.php/ajax/districts_for_posting",
            type: 'POST',
            data: form_data,
            cache: false,
            success: function (msg) {
                console.log( msg );
                x = document.getElementById('district').innerHTML = msg;
            }
        });

    }

</script>