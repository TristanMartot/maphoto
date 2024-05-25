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

			<div>

					<div>

						<?php
							// Site title or logo.
							the_custom_logo();
						?>

					</div><!-- .header-titles -->

			</div><!-- .header-titles-wrapper -->

				<div>
					<nav aria-label="<?php echo esc_attr_x( 'Horizontal', 'menu', 'default' ); ?>">
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


				</div><!-- .header-navigation-wrapper -->

		</header><!-- #site-header -->

		<?php
	
