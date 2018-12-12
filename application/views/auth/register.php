<div class="main">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="row">
                <h1>Registracija: </h1>
            </div>


            <?php echo form_open(site_url('register'),array('class' => 'form-horizontal', 'role' => 'form'));?>
            <div class="form-group">
                <label for="name" >Ime: </label>
                <input type="text" id="name" class="form-control" name="name" placeholder="Unsite vapše ime">
                <?php echo form_error('name','<span class="text-danger err">','</span>'); ?>
            </div>

            <div class="form-group">
                <label for="email" ><?php echo lang("login_email");?> :</label>
                <input type="email" id="email" class="form-control" name="email" placeholder="<?php echo lang("login_email_placeholder");?>" value="<?php echo set_value('email');?>">
                <?php echo form_error('email','<span class="text-danger">','</span>'); ?>
            </div>
            <div class="form-group">
                <label for="password" ><?php echo lang("login_password");?> :</label>
                <input type="password" id="password" class="form-control" name="password" placeholder="<?php echo lang("login_password_placeholder");?>">
                <?php echo form_error('password','<span class="text-danger err">','</span>'); ?>
            </div>

            <div class="form-group">
                <button class="btn btn-lg btn-primary btn-block submit" type="submit">Registruj se</button>
            </div>
            <?php echo form_close();?>


        </div>
    </div>
</div>


