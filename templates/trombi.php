<?php
/**
 * Affichage d'un parent élu
 */

?>
<article <?php post_class() ?>>

    <?php the_post_thumbnail( 'medium' ); ?>
    <?php the_title('<h2 class="entry-title">', '</h2>') ?>
</article>
