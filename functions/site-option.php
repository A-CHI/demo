<?php
define('_KMS_PRIMARY_','https://kassy-markup.com');
define('__USE_BLOCK_EDITOR__', true);

if( !__USE_BLOCK_EDITOR__ ) {
    add_filter('use_block_editor_for_post', '__return_false', 10);
    add_action('wp_enqueue_scripts', 'remove_block_editor_inline_styles', 100);
}

// テーマの関数群インクルード
require get_template_directory() . '/functions/inc/enqueue.php';
require get_template_directory() . '/functions/inc/seo.php';
require get_template_directory() . '/functions/inc/custom_post.php';
require get_template_directory() . '/functions/inc/custom_thumbnails.php';
require get_template_directory() . '/functions/inc/custom_nav.php';
require get_template_directory() . '/functions/inc/shortcode.php';
require get_template_directory() . '/functions/inc/view_count.php';
require get_template_directory() . '/functions/inc/toc.php';
require get_template_directory() . '/functions/inc/pwa.php';
require get_template_directory() . '/functions/inc/recapture.php';
//require get_template_directory() . '/functions/inc/manage.php';
//require get_template_directory() . '/functions/inc/formmail.php';
//require get_template_directory() . '/functions/inc/custom-field.php';

/*
Add functions
**************************************************************************************/
//自動整形機能を無効化
add_action( 'wp', 'disable_page_wpautop' );
function disable_page_wpautop() {
	if ( is_page() ):
    remove_filter( 'the_content', 'wpautop' );
    remove_filter('the_excerpt', 'wpautop');
  endif;
}

//ブロックエディター関連の削除
function remove_block_editor_inline_styles() {
    wp_dequeue_style('global-styles');
    wp_dequeue_style('classic-theme-styles');
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
}


//投稿者アーカイブ
add_action( 'template_redirect', 'author_archive_redirect' );
function author_archive_redirect() {
    if ( is_author() ) {
        wp_redirect( home_url());
        exit;
    }
}

//REST API
add_filter( 'rest_endpoints', 'author_rest_endpoints', 10, 1 );
function author_rest_endpoints( $endpoints ) {
    if ( isset( $endpoints['/wp/v2/users'] ) ) {
        unset( $endpoints['/wp/v2/users'] );
    }
    if ( isset( $endpoints['/wp/v2/users/(?P[\d]+)'] ) ) {
        unset( $endpoints['/wp/v2/users/(?P[\d]+)'] );
    }
    return $endpoints;
}

/**
 * ユーザー（投稿者一覧）のサイトマップ出力を停止する
 */
add_filter('wp_sitemaps_add_provider', function($provider, $name) {
    if ('users' === $name) {
        return false;
    }
    return $provider;
}, 10, 2);


// canonical で末尾のスラッシュを廃止
add_filter('get_canonical_url', 'remove_canonical_trailing_slash'); 
function remove_canonical_trailing_slash($url) {
    return rtrim($url, '/');
}



