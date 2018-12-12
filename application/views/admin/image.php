<div class="main">
    <h3 class="col-sm-12">Administracija - Prebacivanje slika</h3>
    <div class="col-md-4">
        <h4>Prebaci sliku</h4>
        <?php echo form_open_multipart(site_url('admin/image'),array('role' => 'form', 'id' => "upload_data"));?>

        <div class="form-group img-wrapper">
            <label for="image">Ubaci sliku: </label>
            <input type="file" id="image" name="image">
            <?php echo form_error('image','<span class="text-danger">','</span>'); ?>
        </div>

        <div class="loader"></div>

        <div class="form-group">
            <label for="kategorija" >Kategorija :</label>
            <select name="kategorija" id="kategorija" class="form-control">
                <?php foreach($categories as $category) { ?>
                    <option value="<?php echo $category->id;?>"><?php echo $category->naziv;?></option>
                    <?php
                }
                ?>
            </select>
            <?php echo form_error('kategorija','<span class="text-danger err">','</span>'); ?>
        </div>


        <div class="form-group">
            <button class="btn btn-lg btn-primary btn-block submit" type="submit">Prebaci</button>
        </div>
        <?php echo form_close();?>
    </div>
    <div class="col-md-8">
        <h4>Kategorije</h4>
        <ul class="list-group">
            <?php foreach($categories as $category) { ?>
                <li class="list-group-item">
                    <a href="<?php echo site_url('admin/category/'.$category->id);?>"><?php echo $category->naziv;?></a>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
</div>

