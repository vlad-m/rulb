<!DOCTYPE html>
<!--[if IE 6]>
<html xmlns="http://www.w3.org/1999/xhtml" id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html xmlns="http://www.w3.org/1999/xhtml" id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html xmlns="http://www.w3.org/1999/xhtml" id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title><?php
		if ( ICL_LANGUAGE_CODE=='ru' )
		{
			echo elegant_titles();
		}
		if ( is_single() && ICL_LANGUAGE_CODE=='en')
		{
			$custom_fields = get_post_custom($post->ID);
			$eng_article_name = mb_strtoupper(maybe_unserialize($custom_fields['_wpem_article_title_en'][0]));
			echo $eng_article_name." | Russian Linguistic Bulletin";
		}
		elseif ( ICL_LANGUAGE_CODE=='en' )
		{
			elegant_titles();
		}
		?></title>

	<?php elegant_description();?>
	<?php elegant_keywords();?>
	<?php elegant_canonical(); ?>

	<?php do_action('et_head_meta'); ?>

	<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<!--[if lt IE 7]>
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie6style.css" />
	<![endif]-->
	<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie7style.css" />
	<![endif]-->
	<!--[if IE 8]>
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie8style.css" />
	<![endif]-->
	<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->

    <?php // Вывод мета данных для статьи
        if (is_single() == TRUE)
        {
            $custom_fields = get_post_custom($post->ID);
            $article_doi  = maybe_unserialize($custom_fields['wpem_article_doi'][0]);
            $rus_authors  = implode(', ', maybe_unserialize($custom_fields['_wpem_article_author_fio_rus'][0]));
            $article_pages  = implode(' - ', maybe_unserialize($custom_fields['wpem_article_pages'][0]));
            $email  = implode(', ', maybe_unserialize($custom_fields['_wpem_article_author_email'][0]));

            $post_name = $post->post_name . '?pdf=true';
            $post_guid = '?post_type=wpem-article&p=' . $post->ID . '?preview=true' . '&pdf=true';
            $pdf_url = $post_name != null ? $post_name : $post_guid;

            $citation_title = '<meta name="citation_title" content="">';
            $citation_author = '<meta name="citation_author" content="">';
            $citation_publication_date = '<meta name="citation_publication_date" content="">';
            $citation_journal_title = '<meta name="citation_journal_title" content="">';
            $citation_issn = '<meta name="citation_issn" content="">';
            $citation_issue = '<meta name="citation_issue" content="">';
            $citation_firstpage = '<meta name="citation_firstpage" content="">';
            $citation_lastpage = '<meta name="citation_lastpage" content="">';
            //$citation_pdf_url = '<meta name="citation_pdf_url" content="">';
            $citation_doi = '<meta name="citation_doi" content="'.$article_doi[wpem_citation_doi_name].'">';
            $citation_author_email = '<meta name="citation_author_email" content="">';

            echo $citation_doi;

            echo wpem_ptint_head_meta();
        }
    ?>

	<script type="text/javascript">
		document.documentElement.className = 'js';
	</script>

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div id="container">
<div style="position: absolute;
top: 30px;
right: 0;"><a href="https://www.facebook.com/rulb.journal" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/fb3sm.png"></a> <a href="https://twitter.com/RulbEditors" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/twsm.png"></a> <a href="http://vk.com/rulborg" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/vksm.png"></a> </div>		<?php do_action('et_header_top'); ?>
		<header class="clearfix">
			<div id="logo-area">
				<?php $bloginfo_name = get_bloginfo( 'name' ); ?>
				<h1 id="logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( $bloginfo_name ); ?>"><?php if ( 'false' == et_get_option( 'flexible_logo_image', 'false' ) || '' == et_get_option( 'flexible_logo' ) ) echo apply_filters( 'et_logo_markup', $bloginfo_name ); else echo '<img src="' . esc_url( et_get_option( 'flexible_logo' ) ) . '" alt="' . esc_attr( $bloginfo_name ) . '" />'; ?></a>
				</h1>
				<h2><?php bloginfo( 'description' ); ?></h2>
			</div>

			<nav id="top-menu">
				<?php
					$menuClass = 'nav';
					if ( et_get_option('flexible_disable_toptier') == 'on' ) $menuClass .= ' et_disable_top_tier';
					$primaryNav = '';
					if (function_exists('wp_nav_menu')) {
						$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'echo' => false ) );
					}
					if ($primaryNav == '') { ?>
						<ul class="<?php echo esc_attr( $menuClass ); ?>">
							<?php if (et_get_option('flexible_home_link') == 'on') { ?>
								<li <?php if (is_home()) echo('class="current_page_item"') ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','Flexible') ?></a></li>
							<?php }; ?>

							<?php show_page_menu($menuClass,false,false); ?>
							<?php show_categories_menu($menuClass,false); ?>
						</ul>
					<?php }
					else echo($primaryNav);
				?>
			</nav> <!-- end #top-menu -->

			<?php if ( ( $phone_num = et_get_option('flexible_phone_num') ) && '' != $phone_num ) echo '<span id="phone">' . $phone_num . '</span>'; ?>
		</header>
		<div id="main-area">
			<?php do_action('et_header_menu'); ?>