<div class="main">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="row">
                <h1>Promena lozinke</h1>
            </div>

            <?php echo form_open(site_url('/reset/password'),array('class' => 'form-horizontal', 'role' => 'form', 'id' => "email_form"));?>
            <div class="form-group">
                <label for="email" ><?php echo lang("login_email");?> :</label>
                <input type="email" id="email" class="form-control" name="email" placeholder="<?php echo lang("login_email_placeholder");?>" value="<?php echo set_value('email');?>">
                <?php echo form_error('email','<span class="text-danger">','</span>'); ?>
            </div>

            <div class="form-group">
                <button class="btn btn-lg btn-primary btn-block submit" type="submit">Posalji</button>
            </div>
            <?php echo form_close();?>


        </div>
    </div>
</div>


