
<div class="main">
    <h3 class="col-sm-12">Administracija - Prodajna mesta</h3>
    <div class="col-md-4">

        <h4>Dodajete novo prodajno mesto:</h4>


        <?php echo form_open(site_url('admin/send/data'),array('role' => 'form', 'id' => "send_data"));?>
        <div class="form-group">
            <label for="naziv" >Naziv :</label>
            <input type="text" id="naziv" class="form-control" name="naziv" placeholder="" value="<?php echo set_value('naziv');?>">
            <?php echo form_error('naziv','<span class="text-danger">','</span>'); ?>
        </div>
        <div class="form-group">
            <label for="adresa" >Adresa :</label>
            <input type="text" id="adresa" class="form-control" name="adresa" placeholder="" value="<?php echo set_value('adresa');?>">
            <?php echo form_error('adresa','<span class="text-danger">','</span>'); ?>
        </div>



        <div class="form-group">
            <label for="grad" >Grad :</label>
            <select name="grad" id="grad" class="form-control" data-url="<?php echo site_url('admin/update/list/opstine');?>">
                <?php foreach($cities as $city) { ?>
                    <option value="<?php echo $city->id;?>"><?php echo $city->naziv;?></option>
                    <?php
                }
                ?>
            </select>
            <?php echo form_error('grad','<span class="text-danger err">','</span>'); ?>
        </div>

        <div class="form-group">
            <label for="opstina" >Opstina :</label>
            <select name="opstina" id="opstina" class="form-control">
                <?php foreach($tonwshipes as $tonwship) { ?>
                    <option value="<?php echo $tonwship->id;?>"><?php echo $tonwship->naziv;?></option>
                    <?php
                }
                ?>
            </select>
            <?php echo form_error('opstina','<span class="text-danger err">','</span>'); ?>
        </div>


        <div class="form-group">
            <label for="lat" >Lat :</label>
            <input type="number" step="any" id="lat" class="form-control" name="lat" placeholder="">
            <?php echo form_error('lat','<span class="text-danger err">','</span>'); ?>
        </div>

        <div class="form-group">
            <label for="lon" >Lon :</label>
            <input type="number" step="any" id="lon" class="form-control" name="lon" placeholder="">
            <?php echo form_error('lot','<span class="text-danger err">','</span>'); ?>
        </div>
        <div class="form-group">
            <button class="btn btn-lg btn-primary btn-block submit" type="submit">Sačuvaj</button>
        </div>
        <?php echo form_close();?>
        <br/><br/>
    </div>
    <div class="col-md-8">

        <h4>
            Prodajna mesta:
        </h4>
        <div class="table-responsive">
            <table class="table table-condensed">
                <thead>
                <tr>
                    <th>Naziv</th>
                    <th>Adresa</th>
                    <th>Grad</th>
                    <th>Opstina</th>
                    <th>lat</th>
                    <th>lon</th>
                </tr>
                </thead>
                <tbody id="store_list" data-url="<?php echo site_url('admin/update/list/store');?>">
                <?php
                if(!empty($stores)) {
                    foreach ($stores as $store) {
                        ?>
                        <tr>
                            <td><?php echo isset($store->naziv) ? htmlspecialchars($store->naziv): ''; ?></td>
                            <td><?php echo isset($store->adresa) ? htmlspecialchars($store->adresa): ''; ?></td>
                            <td><?php echo isset($store->grad) ? htmlspecialchars($store->grad): ''; ?></td>
                            <td><?php echo isset($store->opstina) ? htmlspecialchars($store->opstina): ''; ?></td>
                            <td><?php echo isset($store->lat) ? htmlspecialchars($store->lat): ''; ?></td>
                            <td><?php echo isset($store->lon) ? htmlspecialchars($store->lon): ''; ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>


    </div>
</div>