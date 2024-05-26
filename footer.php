			<footer>

				<div class="footer_nav">
								<?php
									wp_nav_menu(
										array(
											'container'  => '',
											'items_wrap' => '%3$s',
											'menu' => 'footer',
										)
									);
								?>

				</div>

			</footer><!-- #site-footer -->

		<?php wp_footer(); 
		get_template_part('templates_part/modale');
		?>
	</body>
</html>
