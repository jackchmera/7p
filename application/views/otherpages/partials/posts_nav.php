<?php

  echo '<div class="panel panel-info">';
                                echo '<div class="panel-heading">Menu</div>';
                                echo '<div class="list-group">';
        foreach($nav as $key){
                        

                              
                                
                                
                                echo '<a href="'.site_url('news/'.$key['position'].'/'.$key['id']).'"><button type="button" class="list-group-item"><span class="glyphicon glyphicon-hand-right" aria-hidden="true"></span> '.$key['name'].'</button></a>';
                            
                      
                            
                            }
                            
                                
                                echo '</div>';
                                
                                
                                
                                echo '</div>';
                  
                  