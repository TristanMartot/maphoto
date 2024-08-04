<div class="nav_mob_container hidden">
    <div class="nav_mob_header">
        <div>
            <?php
            // Récupérer les attributs de l'image avec l'ID 8
            $image_attributes = wp_get_attachment_image_src(8, 'medium'); 
            ?>
            <!-- Lien vers la page d'accueil avec le logo -->
            <a href="/">
                <img src="<?php echo esc_url($image_attributes[0]); ?>" alt="Logo" />
            </a>
        </div>
        <!-- Croix de fermeture -->
        <div class="cross"></div>
    </div>
    <div class="nav_mob_body">
        <nav aria-label="<?php echo esc_attr_x('Horizontal', 'menu', 'default'); ?>">
            <ul>
                <?php
                // Affichage du menu de navigation
                wp_nav_menu([
                    'container'  => '',
                    'items_wrap' => '%3$s',
                    'menu'       => 'menu',
                ]);
                ?>
            </ul>
        </nav>
    </div>
</div>
