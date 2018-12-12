<div class="main">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">

            <h1>Promena lozinke</h1>



            <?php echo form_open(site_url().'reset/password/token/'.$token); ?>
            <div class="form-group">
                <label for="password" >Lozinka:</label>
                <input type="password" id="password" class="form-control" name="password">
                <?php echo form_error('password','<span class="text-danger err">','</span>'); ?>
            </div>
            <div class="form-group">
                <label for="passconf" >Postvrdi lozinku :</label>
                <input type="password" id="passconf" class="form-control" name="passconf" >
                <?php echo form_error('passconf','<span class="text-danger err">','</span>'); ?>
            </div>
            <div class="form-group">
                <button class="btn btn-lg btn-primary btn-block" type="submit">Posalji</button>
            </div>
            <?php echo form_close(); ?>




        </div>
    </div>
</div>


