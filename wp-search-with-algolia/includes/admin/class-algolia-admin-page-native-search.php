<?php
/**
 * Algolia_Admin_Page_Native_Search class file.
 *
 * @author  WebDevStudios <contact@webdevstudios.com>
 * @since   1.0.0
 *
 * @package WebDevStudios\WPSWA
 */

/**
 * Class Algolia_Admin_Page_Native_Search
 *
 * @since 1.0.0
 */
class Algolia_Admin_Page_Native_Search {

	/**
	 * Admin page slug.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @var string
	 */
	private $slug = 'algolia-search-page';

	/**
	 * Admin page capabilities.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @var string
	 */
	private $capability = 'manage_options';

	/**
	 * Admin page section.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @var string
	 */
	private $section = 'algolia_section_native_search';

	/**
	 * Admin page option group.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @var string
	 */
	private $option_group = 'algolia_native_search';

	/**
	 * The Algolia_Plugin instance.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @var Algolia_Plugin
	 */
	private $plugin;

	/**
	 * Algolia_Admin_Page_Native_Search constructor.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @param Algolia_Plugin $plugin The Algolia_Plugin instance.
	 */
	public function __construct( Algolia_Plugin $plugin ) {
		$this->plugin = $plugin;

		add_action( 'admin_menu', array( $this, 'add_page' ) );
		add_action( 'admin_init', array( $this, 'add_settings' ) );
		add_action( 'admin_notices', array( $this, 'display_errors' ) );
	}

	/**
	 * Add submenu page.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 */
	public function add_page() {
		add_submenu_page(
			'algolia',
			esc_html__( 'Search Page', 'wp-search-with-algolia' ),
			esc_html__( 'Search Page', 'wp-search-with-algolia' ),
			$this->capability,
			$this->slug,
			array( $this, 'display_page' ),
			0
		);
	}

	/**
	 * Add settings.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 */
	public function add_settings() {
		add_settings_section(
			$this->section,
			null,
			array( $this, 'print_section_settings' ),
			$this->slug
		);

		add_settings_field(
			'algolia_override_native_search',
			esc_html__( 'Search results', 'wp-search-with-algolia' ),
			array( $this, 'override_native_search_callback' ),
			$this->slug,
			$this->section
		);

		add_settings_field(
			'algolia_instantsearch_template_version',
			esc_html__( 'Instantsearch Template version', 'wp-search-with-algolia' ),
			[ $this, 'instantsearch_template_version' ],
			$this->slug,
			$this->section
		);

		register_setting( $this->option_group, 'algolia_override_native_search', array( $this, 'sanitize_override_native_search' ) );

		register_setting( $this->option_group, 'algolia_instantsearch_template_version', [
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'legacy'
		] );
	}

	/**
	 * Override native search callback.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 */
	public function override_native_search_callback() {
		$value = $this->plugin->get_settings()->get_override_native_search();

		require_once dirname( __FILE__ ) . '/partials/form-override-search-option.php';
	}

	/**
	 * Get Instantsearch template version
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  2.9.0
	 */
	public function instantsearch_template_version() {
		$value = $this->plugin->get_settings()->get_instantsearch_template_version();

		require_once dirname( __FILE__ ) . '/partials/form-override-search-version-option.php';
	}

	/**
	 * Sanitize override native search.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @param string $value The value to sanitize.
	 *
	 * @return array
	 */
	public function sanitize_override_native_search( $value ) {

		if ( 'backend' === $value ) {
			add_settings_error(
				$this->option_group,
				'native_search_enabled',
				esc_html__( 'WordPress search is now based on Algolia!', 'wp-search-with-algolia' ),
				'updated'
			);
		} elseif ( 'instantsearch' === $value ) {
			add_settings_error(
				$this->option_group,
				'native_search_enabled',
				esc_html__( 'WordPress search is now based on Algolia instantsearch.js!', 'wp-search-with-algolia' ),
				'updated'
			);
		} else {
			$value = 'native';
			add_settings_error(
				$this->option_group,
				'native_search_disabled',
				esc_html__( 'You chose to keep the WordPress native search instead of Algolia. If you are using the autocomplete feature of the plugin we highly recommend you turn Algolia search on instead of the WordPress native search.', 'wp-search-with-algolia' ),
				'updated'
			);
		}

		return $value;
	}

	/**
	 * Display the page.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 */
	public function display_page() {
		require_once dirname( __FILE__ ) . '/partials/page-search.php';
	}

	/**
	 * Display the errors.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function display_errors() {
		settings_errors( $this->option_group );

		if ( defined( 'ALGOLIA_HIDE_HELP_NOTICES' ) && ALGOLIA_HIDE_HELP_NOTICES ) {
			return;
		}

		$settings = $this->plugin->get_settings();

		if ( ! $settings->should_override_search_in_backend() && ! $settings->should_override_search_with_instantsearch() ) {
			return;
		}

		$maybe_get_page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS );

		$searchable_posts_index = $this->plugin->get_index( 'searchable_posts' );
		if ( false === $searchable_posts_index->is_enabled() && ( ! empty( $maybe_get_page ) ) && $maybe_get_page === $this->slug ) {
			// translators: placeholder contains the link to the indexing page.
			$message = sprintf( __( 'Searchable posts index needs to be checked on the <a href="%s">Algolia: Indexing page</a> for the search results to be powered by Algolia.', 'wp-search-with-algolia' ), esc_url( admin_url( 'admin.php?page=algolia-indexing' ) ) );
			echo '<div class="error notice">
					  <p>' . wp_kses_post( $message ) . '</p>
				  </div>';
		}
	}

	/**
	 * Prints the section text.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 */
	public function print_section_settings() {
		echo '<p>' . esc_html__( 'By enabling these settings to override the native WordPress search, your search results will be powered by Algolia\'s typo-tolerant & relevant search algorithms.', 'wp-search-with-algolia' ) . '</p>';

		echo '<p>' . sprintf(
			'<strong>%1$s</strong> - %2$s',
			esc_html__( 'Re-index All Content', 'wp-search-with-algolia' ),
			esc_html__( 'Resubmit all of your content to the Algolia search API. Search results will be updated once the re-index has completed.', 'wp-search-with-algolia' )
		) . '</p>';

		echo '<p>' . sprintf(
			'<strong>%1$s</strong> - %2$s <strong>%3$s</strong>',
			esc_html__( 'Push Settings', 'wp-search-with-algolia' ),
			esc_html__( 'Sync your search index settings to code-based overrides and plugin defaults.', 'wp-search-with-algolia' ),
			esc_html__( 'WARNING this will override or reset configuration changes originally made within your Algolia dashboard.', 'wp-search-with-algolia' )
		) . '</p>';

		// @Todo: replace this with a check on the searchable_posts_index.
		$indices = $this->plugin->get_indices(
			array(
				'enabled'  => true,
				'contains' => 'posts',
			)
		);

		if ( empty( $indices ) ) {
			echo '<div class="error-message"><p>' .
					esc_html( __( 'You have no index containing only posts yet. Please index some content with the "Re-index All Content" button above.', 'wp-search-with-algolia' ) ) .
					'</p></div>';
		}
	}
}
