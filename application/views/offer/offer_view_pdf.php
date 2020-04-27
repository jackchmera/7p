
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h2><?=$offer['town']?> - <?=$offer['type_name']?> - <?=$offer['area'];?> m2</h2>
                                <p>Na sprzedaż <?=$offer['type_name']?>, <?=$offer['town'];?>, <?=$offer['voivodeship_name'];?>, powiat <?=$offer['community'];?></p>
                                <p><b>Numer oferty:</b> <?=$offer['no']?></p>
                            </div>

                            <div class="panel-body">
                                
                                <div id="gallery">
                                    
                                    <?php
                                    
                                        echo '<img src="'.base_url().'imports/'.$offer['ftp']['directory'].'/unziped/'.$offer['image']['name'].'" alt="Nieruchomości" />';
                                    
                                    ?>
                                </div>

                                <div class="table-responsive">
                                    <table class="table text-center">
                                        <thead class="text-center">
                                        <th class="text-center">Cena</th>
                                        <th class="text-center">Powierzchnia</th>
                                        <th class="text-center">Liczba pokoi</th>
                                        <th class="text-center">Piętro</th>
                                        </thead>
                                            <tr>
                                                <td><?=$offer['price'];?> zł<br/><span style="color: gray; font-size: 0.9em"><?=intval($offer['price']/$offer['area']);?> / m<sup>2</sup></span></td>
                                                <td><?=$offer['area'];?> m<sup>2</sup></td>
                                                <td><?=$offer['rooms'];?></td>
                                                <td><?=$offer['floor'];?> / <?=$offer['floors'];?> </td>
                                        </tr>
                                    </table>
                                    
                                    <p><b>Opis:</b></p>
                                    <div style='text-align: justify'><?=$offer['description'];?></div>
                                </div>
                                
                                <div class="row">
                                    <h3>Dane kontaktowe:</h3>
                                    <p><b><?=$offer['agent_name']?></b></p>
                                    <p>Tel. <?=$offer['agent_tel_kom']?></p>
                                </div>

                            </div>
                        </div>