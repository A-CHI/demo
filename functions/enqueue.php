<?php
/**
 * enqueue.php - テーマのスクリプトとスタイルの登録・最適化
 */
defined('ABSPATH') || exit;

class Kms_Theme_Assets {

    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_filter('style_loader_tag', [$this, 'async_style_loader'], 10, 2);
        add_filter('script_loader_tag', [$this, 'defer_script_loader'], 10, 2);
    }

    /**
     * スクリプトとスタイルの登録
     */
    public function enqueue_scripts() {
        if (is_admin()) return;

        // --- 1. JS / jQuery ---
        wp_deregister_script('jquery');
        wp_register_script(
            'jquery', 
            'https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js', 
            array(), 
            '3.7.1', 
            false
        );
        wp_enqueue_script('jquery');
        
        $common_js_path = _SCRIPT_PATH_ .'/common.js';
        wp_enqueue_script('common-js', _SCRIPT_URI_ . '/common.js', array('jquery'), $this->get_ftime($common_js_path), true);

        wp_enqueue_script('heightline', _SCRIPT_URI_ . '/jquery.heightline.js', array('jquery'), null, true);
        wp_enqueue_script('swiper-js', 'https://unpkg.com/swiper@7/swiper-bundle.min.js', array(), null, true);
        
        $index_js_path = _SCRIPT_PATH_ .'/index.js';
        wp_enqueue_script('index-js', _SCRIPT_URI_ . '/index.js', array('jquery'), $this->get_ftime($index_js_path), true);

        // --- 2. スタイルシート ---
        wp_enqueue_style('yakuhanjp', 'https://cdn.jsdelivr.net/npm/yakuhanjp@3.4.1/dist/css/yakuhanjp-noto.min.css');
        wp_enqueue_style('swiper-css', 'https://unpkg.com/swiper@7/swiper-bundle.min.css');
        wp_enqueue_style('material-symbols', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined');

        $theme_css_path = _STYLE_PATH_ . '/theme.css';
        wp_enqueue_style('theme-css', _STYLE_URI_ . '/theme.css', array(), $this->get_ftime($theme_css_path));

        if (!is_user_logged_in()) {
            wp_deregister_style('dashicons');
            wp_deregister_style('admin-bar');
        }
    }

    /**
     * CSSを非同期化
     */
    public function async_style_loader($tag, $handle) {
        $async_handles = array('yakuhanjp', 'swiper-css', 'material-symbols');
        if (in_array($handle, $async_handles)) {
            return str_replace("rel='stylesheet'", "rel='stylesheet' media='print' onload=\"this.media='all'\"", $tag);
        }
        return $tag;
    }

    /**
     * すべてのJSをdefer化
     */
    public function defer_script_loader($tag, $handle) {
        if ($handle === 'jquery') return $tag;
        
        if (!is_admin()) {
            return str_replace(' src', ' defer src', $tag);
        }
        return $tag;
    }

    /**
     * キャッシュ対策
     */
    private function get_ftime($relative_path) {
        $path = get_template_directory() . $relative_path;
        return file_exists($path) ? filemtime($path) : '1.0.0';
    }
}

new Kms_Theme_Assets();