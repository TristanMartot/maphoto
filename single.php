<?php
/*
Template Name: Page
Template Post Type: page
*/
 

get_header(); // Inclut le header.php du thème
?>

<main id="main" class="site-main">
    <div class="page_parent_container">
    <?php
        // La boucle principale WordPress pour afficher le contenu de la page
        while ( have_posts() ) :
            the_post();
            the_content();
        endwhile; // End of the loop.
        ?>
    </div>
</main><!-- #main -->

<?php
get_footer(); // Inclut le footer.php du thème
?>