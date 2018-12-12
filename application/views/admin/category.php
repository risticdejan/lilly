<div class="main">
    <h3 class="col-sm-12">Administracija - Kategorije</h3>

    <div class="col-md-8">
        <h4>Kategorija - <?php echo $category_name;?></h4>

        <ul class="media-list">
            <?php foreach($all as $img) { ?>
            <li class="media">
                <div class="media-left">
                    <a href="#">
                        <img src="<?php echo site_url('/resources/uploads/'.$img->direktorijum .'/'. htmlspecialchars($img->slika));?>" alt=" <?php echo htmlspecialchars($img->slika);?>"  width="80"/>
                    </a>
                </div>
                <div class="media-body">
                    <span><b>Naziv slike: </b> <?php echo htmlspecialchars($img->slika);?></span><br/>
                    <span><b>direktorijum: </b> <?php echo PUBPATH.'/resources/uploads/'.$img->direktorijum ;?></span><br/>
                    <span><b>Kategorija: </b> <?php echo $img->kategorija;?></span><br/>

                </div>
            </li>
            <?php
            }
            ?>
        </ul>

    </div>
    <div class="col-md-4">
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