			<footer>

				<div>
								<?php
									wp_nav_menu(
										array(
											'container'  => '',
											'items_wrap' => '%3$s',
											'menu' => 'menu_footer',
										)
									);
								?>

				</div>

			</footer><!-- #site-footer -->

		<?php wp_footer(); ?>

	</body>
</html>
