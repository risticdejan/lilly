<div class="main">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="col-sm-12">Administracija - Bar kodovi</h3>
            <div class="col-md-4">
                <h4>Akcije</h4>

                <ul class="list-group">

                    <li class="list-group-item">
                        <a id="insert-csv" href="<?php echo site_url('barcode/insert');?>">insert CSV  u bazu</a>
                    </li>
                    <li class="list-group-item">
                        <a id="delete-csv" href="<?php echo site_url('barcode/delete');?>">brisanje CSV iz bazu</a>
                    </li>
                </ul>
                <p id="code-area"></p>
            </div>
            <div class="col-md-8">
                <h4>Pretraga bar kodova</h4>
                <?php echo form_open(site_url('barcode/autocomplete/search'),array('class' => 'form-inline', 'role' => 'form', 'id' => "search"));?>
                    <div class="form-group">
                        <input id="code" name="code" type="text" class="form-control" placeholder="Unesi kod" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input id="name" type="text" name="name" class="form-control" placeholder="Unesi naslov" autocomplete="off">
                    </div>
                    <button type="submit" class="btn btn-default">Pretraži</button>
                <?php echo form_close();?>
                <ul class="dropdown-menu"  role="menu" aria-labelledby="dropdownMenu"  id="DropdownSuggest"></ul>
            </div>
        </div>
    </div>
</div>

