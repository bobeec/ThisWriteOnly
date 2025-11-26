<?php
/**
 * Custom Search Form
 *
 * @package BLOGthemeWP
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label class="screen-reader-text" for="search-field">
        <?php esc_html_e( '検索:', 'blogthemewp' ); ?>
    </label>
    <input type="search" 
           id="search-field" 
           class="search-field" 
           placeholder="<?php esc_attr_e( '検索...', 'blogthemewp' ); ?>" 
           value="<?php echo get_search_query(); ?>" 
           name="s">
    <button type="submit" class="search-submit">
        <span class="screen-reader-text"><?php esc_html_e( '検索', 'blogthemewp' ); ?></span>
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
    </button>
</form>
