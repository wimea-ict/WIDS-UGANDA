<div class="table-responsive">

    <section>
        <h1><?= $news->ne_title ?></h1>
        <p><?= $news->ne_desc ?></p>
        <p><img src="<?php echo base_url(); ?>global/uploads/<?= $news->ne_img ?>"/></p>
        <button class="btn btn-success"> visits :<?= $news->ne_views ?></button>
    </section>

</div>

