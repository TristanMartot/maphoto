<!DOCTYPE html>

<html <?php language_attributes(); ?>>

	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" >
		<link rel="profile" href="https://gmpg.org/xfn/11">

		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?>>

		<?php
		wp_body_open();
		?>

		<header>
			<div class="header_container">
				<div>

						<?php
						//logo.
						$image_attributes = wp_get_attachment_image_src( '8' , 'medium' ); 
						?>
						<a href="/"><img src="<?php echo $image_attributes[0]; ?>" /></a>

				</div>

				<div>
					<nav class="nav_desktop" aria-label="<?php echo esc_attr_x( 'Horizontal', 'menu', 'default' ); ?>">
								<ul>

								<?php
									wp_nav_menu(
										array(
											'container'  => '',
											'items_wrap' => '%3$s',
											'menu' => 'menu',
										)
									);
								?>
								</ul>

							</nav><!-- .primary-menu-wrapper -->
							
							<div class="toggle"></div>
							<?php get_template_part('templates_parts/nav_mobile'); ?>


				</div><!-- .header-navigation-wrapper -->
			</div>
		</header><!-- #site-header -->

		<?php
	
