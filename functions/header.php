<?php
	global $kms_options;
	if ( ! $kms_options ) $kms_options = get_kms_option();
	$custom_body_tags = $kms_options['custom_body_tags'];
	$logo = 'KASSY MARKUP';
	$locale = get_locale();
?>
<!doctype html>
<html lang="<?= $locale; ?>">
	<head>
		<?php get_template_part( 'template-parts/head' ); ?>
	</head>

	<body id="root" <?php body_class(); ?>>
		<?php
			if( !empty( $custom_body_tags ) ){ echo $custom_body_tags."\n"; }
		?>
		<header class="l-header">
			<div class="l-header-container c-case">
				<div class="l-header-brand">
					<a href="<?= _KMS_PRIMARY_; ?>" class="c-brand l-header-brand__wrap js-touch-hover">
						<p class="c-brand-logo l-header-brand__logo">Kassy Markup</p>
						<p class="c-brand-caption l-header-brand__caption">Coding & Web Engineering</p>
					</a>
				</div>
				<div class="l-header-nav">
					<div class="p-nav-toggle js-nav-toggle --opener js-touch-hover" aria-controls="global-nav" aria-expanded="false" aria-label="メニューを開く">
						<span class="bar --primary"></span><span class="bar"></span><span class="bar"></span>
					</div>
				</div>
			</div>
		</header>


		<?php get_template_part( 'template-parts/nav' ); ?>

		<main role="main" class="l-main" id="main-content">
