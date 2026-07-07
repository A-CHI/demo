<?php
	global $kms_options;
	if ( ! $kms_options ) $kms_options = get_kms_option();
	$custom_head = $kms_options['custom_head'];
	$favicon_img = $kms_options['favicon'];
	$app_img = $kms_options['app'];
	$ogp_img_id = $kms_options['ogp_img'];
	if( !empty($ogp_img_id) ){
		$ogp_src = wp_get_attachment_image_src( $ogp_img_id, 'full');
		$ogp_img = $ogp_src[0];//var_dump($ogp_img);
	}else{
		$ogp_img = 'https://placehold.jp/1200x630.png?text=Noimage';
	}


?>
		<base href="<?= home_url(); ?>" target="_self">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<meta name="format-detection" content="telephone=no">

		<!--オーバーヘッド対策-->
		<link rel="preconnect" href="https://www.googletagmanager.com">
		<link rel="dns-prefetch" href="https://www.googletagmanager.com">

		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=M+PLUS+1:wght@100..900&family=lato&family=Josefin+Sans&family=Montserrat:wght@400;700&family=Noto+Sans+JP:wght@300;400;500;600;700&family=Noto+Serif+JP:wght@300;400;500;600;700;900&family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

		<meta name="description" content="<?= get_seo_description(); ?>">
		<?php
			if( !empty( $favicon_img ) ){
					$favicon_src = media_src( $favicon_img, 'full' );
				echo '
				<link rel="icon" href="'. $favicon_src .'" type="image/x-icon">';
			}
			if( !empty( $app_img ) ){
				$app_src = media_src( $app_img, 'full' );
				echo '
				<link rel="apple-touch-icon" sizes="180x180" href="'. $app_src .'">
				<link rel="shortcut icon" href="'. $app_src .'">';
			}

			wp_head();
			if( !empty( $custom_head ) ){ echo $custom_head."\n"; } ?>
