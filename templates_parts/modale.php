<div class="container">
<div class="modale">
<?php
$image_contact = wp_get_attachment_image_src( '47' , 'large' ); 
?>
<img src="<?php echo $image_contact[0]; ?>" height="<?php echo $image_contact[2]; ?>">
<? echo do_shortcode('[contact-form-7 id="c6b4a9d" title="Formulaire de contact 1"]'); ?>
</div>    
</div>
