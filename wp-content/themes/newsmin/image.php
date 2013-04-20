<?php
get_header(); ?>

	<div class="content">

<div class="big-pic">
                       <a href="<?php echo wp_get_attachment_url($post->ID); ?>">
                         <?php echo     wp_get_attachment_image( $post->ID, 'large' ); ?></a>
		</div>
  <div class="prev-pic"> 
                    <h6><?php previous_image_link(false,__( 'Previous image', 'newsmin' )) ?></h6>
                  
  </div>

   <div class="next-pic">
                   <h6><?php next_image_link(false,'Next image') ?></h6>
                  
  </div><br />  
	<?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?><br />		
			
			<?php
				get_template_part( 'loop', 'image' );
			?>

		</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
