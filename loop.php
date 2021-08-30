<div class="container">
    <?php
    if (have_posts()) : ?>
        <?php
        while (have_posts()) :
            the_post();
        ?>
            <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
            <div class="post">
                <?php the_excerpt(); ?>
            </div>
        <?php endwhile;
    else : ?>
        <p>Désolé pour l'instant il n'y a pas d'article </p>
    <?php endif; ?>
</div><!-- endcontaier -->