<?php
/*
/ * カスタム投稿タイプ・カスタムタクソノミー設定
/ * 一覧表示数変更
/ * ダッシュボード 項目追加
/ * パーマリンク変更・リダイレクト処理
*/

// カスタム投稿タイプ・カスタムタクソノミー ------------------------------------------------------------------
if (function_exists('register_post_type')) {
    //add_action('init', 'custom_register_post_type');
    function custom_register_post_type( $data_only = false ) {

        // --- 1. 各投稿タイプの設定 ---
        $post_types = [
            'lp' => [
                'label' => 'LP',
                'has_archive'        => true,
            ],


        ];

        // --- 2. 各タクソノミーの設定 ---
        $taxonomies = [
            'site_type' => [
                'label'      => 'サイト種別',
                'post_types' => 'lp',
				'hierarchical' => true,
            ],

        ];

        // 管理画面などで「配列データだけ」が欲しい場合は、ここで返す
        if ( $data_only ) {
            return [
                'post_types' => $post_types,
                'taxonomies' => $taxonomies
            ];
        }


        // 投稿タイプ配列が空でない場合のみ実行
        if (!empty($post_types)) {
            foreach ($post_types as $slug => $args) {
                $defaults = [
                    'label'              => $args['label'],
                    'public'             => true,
                    'publicly_queryable' => true,
                    'menu_position'      => 5,
                    'show_ui'            => true,
                    'query_var'          => true,
                    'capability_type'    => 'post',
                    'has_archive'        => true,
                    'hierarchical'       => false,
                    'rewrite'            => true,
                    'show_in_rest'       => true,
                    'supports'           => ['title', 'editor', 'thumbnail'],
                    'labels' => [
                        'name'          => $args['label'],
                        'singular_name' => $args['label'],
                        'add_new_item'  => $args['label'] . 'を追加',
                        'edit_item'     => $args['label'] . 'を編集',
                    ],
                ];

                $final_args = array_merge($defaults, $args);
                register_post_type($slug, $final_args);
            }
        }

        // タクソノミー配列が空でない場合のみ実行
        if (!empty($taxonomies)) {
            foreach ($taxonomies as $slug => $args) {
                // post_typesが指定されていない場合のフォールバック
                $post_target = $args['post_types'] ?? 'post';
				$tax_label = $args['label'] ?? $slug;

                $defaults = [
                    'hierarchical'      => true,
                    'public'            => true,
                    'show_ui'           => true,
                    'show_admin_column' => true,
                    'show_in_nav_menus' => true,
                    'show_tagcloud'     => true,
                    'show_in_rest'      => true,
                    'query_var'         => true,
                    'rewrite'           => true,
                    'labels' => [
                        'name'          => $tax_label,
                        'singular_name' => $tax_label,
                        'all_items'     => $tax_label . '一覧',
                        'add_new_item'  => '新しい' . $tax_label . 'を追加',
                        'edit_item'     => $tax_label . 'を編集',
                    ],
                ];

                unset($args['post_types']);
                $final_args = array_merge($defaults, $args);

                register_taxonomy($slug, $post_target, $final_args);
            }
        }
    }
}

/* 一覧表示数変更 */
//add_action( 'pre_get_posts', 'custompost_custom_query_vars' );
function custompost_custom_query_vars( $query ) {
	/* @var $query WP_Query */
	if ( !is_admin() && $query->is_main_query()) {
		if ( is_post_type_archive( 'custompost' ) ) {
			$query->set( 'posts_per_page' , 12 );
		}
	}
	return $query;
}


// パーマリンク変更
//add_filter( 'post_type_link', 'change_custom_post_type_permalink_to_id', 10, 2 );
function change_custom_post_type_permalink_to_id( $post_link, $post ) {
    $custom_post_type_name = _KMS_TYPE_CASE_;

    if ( $custom_post_type_name === $post->post_type ) {
        return home_url( '/'.$custom_post_type_name.'/' . $post->ID );
    }
    return $post_link;
}

// リダイレクト処理
//add_action( 'template_redirect', 'redirect_old_custom_post_type_permalink' );
function redirect_old_custom_post_type_permalink() {
    $custom_post_type_name = _KMS_TYPE_CASE_; 
    if ( is_singular( $custom_post_type_name ) && strpos( $_SERVER['REQUEST_URI'], $custom_post_type_name ) !== false ) {
        global $post;
        if ( empty( $post->ID ) ) {
            return;
        }

        $new_url = home_url( '/'.$custom_post_type_name.'/' . $post->ID );
        if ( $_SERVER['REQUEST_URI'] !== parse_url( $new_url, PHP_URL_PATH ) ) {
            wp_redirect( $new_url, 301 );
            exit;
        }
    }
}

