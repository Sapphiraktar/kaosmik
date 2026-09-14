<div class="row row-cols-sm-3 row-cols-1 g-3">
    <?php
    foreach($cantinaHeroes as $hero) : ?>
        <div class="col">
            <?= view_cell('HeroCell', ['character' => $hero]); ?>
        </div>
    <?php endforeach; ?>

</div>