
<section class="apparitionright l-map-section">
    <h2>Remplissez les champs</h2>
    <div class="l-map-section-container">
        <form action="" method="post">
            <div class="clearfix map-btns-container">
                <fieldset class="inputstyle postalcode">
                    <label for="zip_code"><?php echo $this->lang->line('adress'); ?></label>
                    <input type="text" id="zip_code" name="codepostal" value='4000'>
                    <input type="hidden" name="radius" id="radius" value="5000"/>
                </fieldset>
                <div class="zonedaction">
                    <p>Zone d'action</p>
                    <a href="#" id="zoomIn" class="btn-zonedaction"><?php echo $this->lang->line('zoom_in'); ?></a><a href="#" id="zoomOut" class="btn-zonedaction"><?php echo $this->lang->line('zoom_out'); ?></a>
                </div>
                <button type="submit" id="search_zipcode" class="btn btn-map-rechercher"><?php echo $this->lang->line('search'); ?></button>
            </div>
            <div class='clearfix map-database'>
                <div >
                    <div id="google-map" style="height:400px"></div>
                    <script>
                      /*function initMap() {
                        var uluru = {lat: -25.363, lng: 131.044};
                        var map = new google.maps.Map(document.getElementById('map'), {
                          zoom: 4,
                          center: uluru
                        });
                        var marker = new google.maps.Marker({
                          position: uluru,
                          map: map
                        });
                      }*/
                    </script>
                    <!--<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzw2qXTk0QCm_u5ejz2iduBH_d4Cv-4Y0&callback=initMap">
                    </script> -->
                </div>
                <div class=" clearfix">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="map_table">
                            <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('city'); ?></th>
                                    <th><?php echo $this->lang->line('zipcode'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                    
                    <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                    <button type="submit" name="load_zip_code" value="true" class="btn btn-codepostaux"><?php echo $this->lang->line('load_zip_code'); ?> <i class="fa fa-check"></i></button>
                    
                </div>
            </div>
        </form>
    </div>
</section>

    
