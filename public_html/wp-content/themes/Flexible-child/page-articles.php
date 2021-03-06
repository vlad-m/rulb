<?php
/*
Template Name: Архив сборников
*/
?>
<?php
$et_ptemplate_settings = array();
$et_ptemplate_settings = maybe_unserialize( get_post_meta( get_the_ID(), 'et_ptemplate_settings', true ) );

$fullwidth = isset( $et_ptemplate_settings['et_fullwidthpage'] ) ? (bool) $et_ptemplate_settings['et_fullwidthpage'] : false;

$et_ptemplate_blogstyle = isset( $et_ptemplate_settings['et_ptemplate_blogstyle'] ) ? (bool) $et_ptemplate_settings['et_ptemplate_blogstyle'] : false;

$et_ptemplate_showthumb = isset( $et_ptemplate_settings['et_ptemplate_showthumb'] ) ? (bool) $et_ptemplate_settings['et_ptemplate_showthumb'] : false;

$blog_cats = isset( $et_ptemplate_settings['et_ptemplate_blogcats'] ) ? (array) $et_ptemplate_settings['et_ptemplate_blogcats'] : array();
$et_ptemplate_blog_perpage = isset( $et_ptemplate_settings['et_ptemplate_blog_perpage'] ) ? (int) $et_ptemplate_settings['et_ptemplate_blog_perpage'] : 10;
?>

<?php get_header(); ?>

<?php get_template_part('includes/breadcrumbs', 'page'); ?>

<?php
$args = [
    'orderby'       => 'id',
    'order'         => 'ASC',
    'hide_empty'    => true,
    'exclude'       => array(),
    'exclude_tree'  => array(),
    'include'       => array(),
    'number'        => '',
    'fields'        => 'all',
    'slug'          => '',
    'parent'         => '',
    'hierarchical'  => true,
    'child_of'      => 0,
    'get'           => 'all', // ставим all чтобы получить все термины
    'name__like'    => '',
    'pad_counts'    => false,
    'offset'        => '',
    'search'        => '',
    'cache_domain'  => 'core',
    'name'          => '', // str/arr поле name для получения термина по нему.
    'childless'     => false, // true не получит (пропустит) термины у которых есть дочерние термины.
];

$tax = 'wpem_compilation_articles';

$myterms = get_terms($tax, $args);

// CHECK lang
if (ICL_LANGUAGE_CODE=='ru')
{
    $lang = '';
    $vipusk = 'Выпуск ';
}
elseif (ICL_LANGUAGE_CODE=='en')
{
    $lang = '/en';
    $vipusk = 'Issue ';
}
?>

<!-- Вывод статей -->

<div id="content-area" class="clearfix<?php if ( $fullwidth ) echo ' fullwidth'; ?>">
	<div id="left-area">
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class('entry clearfix'); ?>>
				<h1 class="page_title"><?php the_title(); ?></h1>

				<div class="post-content">
					<?php the_content(); ?>

                    <table class="article_table" border="1">
                        <?php
                            foreach ( $myterms as $term )
                            {
                                $magazine_number = wpem_get_meta( $term->term_id, 'magazine_number', $tax );

                                $print_date = wpem_get_meta( $term->term_id, 'print_date', $tax );
                                //$deadline_date = wpem_get_meta( $term->term_id, 'deadline_date', $tax );

                                $pdate = date('Y', strtotime($print_date));

                                // Формируем массив с датами и выпусками
                                $article_compil[$pdate][$magazine_number] = array($term);
                            }

                            foreach ($article_compil as $date => $compil)
                            {
                                echo '<tr>';
                                echo '<td>'.$date.'</td>';
                                echo '<td>';

                                foreach ($compil as $t => $p)
                                {
                                    echo '<ul>';
                                    echo '<a href="'.$lang.'/'.$p[0]->taxonomy.'/'.$p[0]->slug.'">'.$vipusk.$t.'</a>';

                                    // Получаем URL pdf файла
                                    //$compilation_link = wpem_get_meta( $p[0]->term_id, 'compilation_link', $tax );

                                    // Ссылка на PDF сбоорника статей
                                    $manual_pdf = wpem_get_meta( $p[0]->term_id, 'manual_pdf', $tax );

                                    if ( $manual_pdf != NULL ) // проверка существования PDF
                                    {
                                        //echo ' - '.'<a href="'.$compilation_link[0].'">'.'PDF'.'</a>';
                                        echo ' - '.'<a href="'.$manual_pdf.'" target="_blank">'.'PDF'.'</a>';
                                    }
                                    echo '</ul>';
                                }

                                echo '</td>';
                                echo '</tr>';
                            }
                        ?>
                    </table>

				</div> <!-- end .post-content -->
			</article> <!-- end .entry -->
		<?php endwhile; // end of the loop. ?>
	</div> <!-- end #left_area -->

	<?php if ( ! $fullwidth ) get_sidebar(); ?>
</div> 	<!-- end #content-area -->

<?php get_footer(); ?>