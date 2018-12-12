
<div class="main">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="col-sm-12">Administracija - Bar kodovi</h3>
            <div class="col-md-8">
                <h4>Barkodovi</h4>

                <ul class="list-group">
                    <?php foreach($res as $r) {
                    ?>
                    <li class="list-group-item">
                        <span><b>Code: </b> <?php echo  htmlspecialchars(trim($r->code,'"'));?></span> <span><b>Naslov: </b><?php echo htmlspecialchars(trim($r->name,'"'));?></span>
                    </li>
                    <?php
                    }
                    ?>

                </ul>

            </div>
        </div>
    </div>
</div>

