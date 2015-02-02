<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Author Bio Box Frontend class.
 */
class Author_Bio_Box_Frontend {

	/**
	 * Initialize the frontend actions.
	 */
	public function __construct() {
		// Load public-facing style sheet.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

		// Display the box.
		add_filter( 'the_content', array( $this, 'display' ), 9999 );
	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @return void
	 */
	public function enqueue_styles() {
		wp_register_style( 'author-bio-box-styles', Author_Bio_Box::get_assets_url() . 'css/author-bio-box.css', array(), Author_Bio_Box::VERSION, 'all' );
	}

	/**
	 * Checks if can display the box.
	 *
	 * @param  array $settings Author Bio Box settings.
	 *
	 * @return bool
	 */
	protected function is_display( $settings ) {
		$display = false;

		if ( 'posts' == $settings['display'] ) {
			$display = is_single();
		} else if ( 'home_posts' == $settings['display'] ) {
			$display = is_single() || is_home();
		}

		return apply_filters( 'authorbiobox_display', $display );
	}

	/**
	 * HTML of the box.
	 *
	 * @param  array $settings Author Bio Box settings.
	 *
	 * @return string          Author Bio Box HTML.
	 */
	public static function view( $settings, $user_id = NULL ) {

		// Load the styles.
		wp_enqueue_style( 'author-bio-box-styles' );
                
                if (is_null($user_id)) {
                    $user_id = get_the_author_meta('ID');
                }

		// Set the gravatar size.
		$gravatar = ! empty( $settings['gravatar'] ) ? $settings['gravatar'] : 70;

		// Set the social icons
		$social = apply_filters( 'authorbiobox_social_data', array(
			'website'    => get_the_author_meta( 'user_url', $user_id ),
			'facebook'   => get_the_author_meta( 'facebook', $user_id ),
			'twitter'    => get_the_author_meta( 'twitter', $user_id ),
			'googleplus' => get_the_author_meta( 'googleplus', $user_id ),
			'linkedin'   => get_the_author_meta( 'linkedin', $user_id ),
			'flickr'	 => get_the_author_meta( 'flickr', $user_id ),
			'tumblr'	 => get_the_author_meta( 'tumblr', $user_id ),
			'vimeo'		 => get_the_author_meta( 'vimeo',$user_id ),
			'youtube'	 => get_the_author_meta( 'youtube',$user_id ),
			'instagram'	 => get_the_author_meta( 'instagram',$user_id ),
			'pinterest'	 => get_the_author_meta( 'pinterest',$user_id )
		) );

		// Set the styes.
		$styles = sprintf(
			'background: %1$s; border-top: %2$spx %3$s %4$s; border-bottom: %2$spx %3$s %4$s; color: %5$s',
			$settings['background_color'],
			$settings['border_size'],
			$settings['border_style'],
			$settings['border_color'],
			$settings['text_color']
		);

		$html = '<div id="author-bio-box" style="' . $styles . '; clear:both">';
                $html .= '<div class="bio-gravatar" style="float:left;">' . get_avatar( $user_id, $gravatar ) . '</div>';
		$html .= '<h3 style="display:inline-block"><a style="color: ' . $settings['title_color'] . ';" href="' . esc_url( get_author_posts_url( $user_id ) ) . '" title="' . esc_attr( __( 'All posts by', 'author-bio-box' ) . ' ' . get_the_author_meta( 'display_name',$user_id ) ) .'" rel="author">' . get_the_author_meta( 'display_name',$user_id ) . '</a></h3>';
		
                $html .= '<span style="margin-left: 1em;">';

		foreach ( $social as $key => $value ) {
			if ( ! empty( $value ) ) {
				$html .= '<a target="_blank" href="' . esc_url( $value ) . '" class="bio-icon bio-icon-' . $key . '"></a>';
			}
		}
                
                $html .= "</span>";

		$html .= '<p class="bio-description">' . apply_filters( 'authorbiobox_author_description', get_the_author_meta( 'description', $user_id ) ) . '</p>';
                
                
                // 加入EMAIL
                $email = get_the_author_meta('email', $user_id);
                $html .= '<a style=""  href="mailto:'.$email.'" target="_blank">
                            <div class="ui labeled icon teal button" style="padding: .6em .8em;margin-right:0.5em;">
                                <i class="mail outline icon"></i>
                                寄送EMAIL
                            </div>
                          </a>';
                
                $last_login = get_user_meta( $user_id, 'wp-last-login', true );
                
                if ($last_login === '') {
                    $last_login = 'NEVER';
                }
                $html .= '<div class="ui label" style="padding: .6em .8em;text-shadow:rgba(255, 255, 255, 0.8) 0px 0px 0px;font-weight:normal;margin-right:0.5em;">
                    <i class="calendar icon"></i> 最後登入時間
                    <a class="detail">'.$last_login.'</a>
</div>';
                
                $post_count = count_user_posts( $user_id , 'post' );
                //$post_count = get_the_author_meta( 'ID' );
                $html .= '<div class="ui label" style="padding: .6em .8em;text-shadow:rgba(255, 255, 255, 0.8) 0px 0px 0px;font-weight:normal;margin-right:0.5em;">
                    <i class="write icon"></i> 已發佈篇數
                    <a class="detail"> '.$post_count.'</a>
</div>';
                
                
		$html .= '</div>';
                

		return $html;
	}

	/**
	 * Insert the box in the content.
	 *
	 * @param  string $content WP the content.
	 *
	 * @return string          WP the content with Author Bio Box.
	 */
	public function display( $content ) {
		// Get the settings.
		$settings = get_option( 'authorbiobox_settings' );

		if ( $this->is_display( $settings ) ) {
			return $content . self::view( $settings );
		}

		return $content;
	}

}

new Author_Bio_Box_Frontend();
