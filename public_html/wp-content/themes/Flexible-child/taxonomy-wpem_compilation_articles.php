<?php
/**
 * Created by PhpStorm.
 * User: arti
 * Date: 05.07.15
 * Time: 7:24
 */
?>
<?php get_header(); ?>
<?php get_template_part('includes/breadcrumbs', 'index'); ?>

<?php
    // ###
    $compil = wp_get_post_terms( $post->ID, 'wpem_compilation_articles' );
    $issue_name = wpem_get_meta( $compil[0]->term_id, 'magazine_number', 'wpem_compilation_articles' );

    if (ICL_LANGUAGE_CODE=='ru')
    {
        $vipusk = 'Выпуск ';
    }
    elseif (ICL_LANGUAGE_CODE=='en')
    {
        $vipusk = 'Issue ';
    }

    // Вывод названия выпуска
    if ($issue_name != NULL)
    {
        echo '<div class="issue_name">' . $vipusk . $issue_name . '</div>';
    }
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <?php
//    $original_ID = icl_object_id( $post->ID, 'any', false, 'en' );
//    var_dump($original_ID);

    $custom_fields = get_post_custom($post->ID);

    $rus_authors_a  = maybe_unserialize($custom_fields['_wpem_article_author_fio_rus'][0]);
    $eng_authors_a  = maybe_unserialize($custom_fields['_wpem_article_author_fio_en'][0]);

    $rus_degree_a  = maybe_unserialize($custom_fields['_wpem_article_author_degree'][0]);
    $eng_degree_a  = maybe_unserialize($custom_fields['_wpem_article_author_degree_en'][0]);

    $rus_work_a  = maybe_unserialize($custom_fields['_wpem_article_author_work_rus'][0]);
    $eng_work_a  = maybe_unserialize($custom_fields['_wpem_article_author_work_en'][0]);

    $rus_authors  = implode(', ', maybe_unserialize($custom_fields['_wpem_article_author_fio_rus'][0]));
    $eng_authors  = implode(', ', maybe_unserialize($custom_fields['_wpem_article_author_fio_en'][0]));

    $rus_work  = implode(', ', maybe_unserialize($custom_fields['_wpem_article_author_work_rus'][0]));
    $eng_work  = implode(', ', maybe_unserialize($custom_fields['_wpem_article_author_work_en'][0]));

    $rus_article_name = mb_strtoupper($post->post_title, 'UTF-8');
    $eng_article_name = mb_strtoupper(maybe_unserialize($custom_fields['_wpem_article_title_en'][0]));

    $rus_annotation  = maybe_unserialize($custom_fields['_wpem_article_annotation_rus'][0]);
    $eng_annotation  = maybe_unserialize($custom_fields['_wpem_article_annotation_en'][0]);

    $rus_keywords  = maybe_unserialize($custom_fields['_wpem_article_keywords_rus'][0]);
    $eng_keywords  = maybe_unserialize($custom_fields['_wpem_article_keywords_en'][0]);

    $article_pages  = implode(' - ', maybe_unserialize($custom_fields['wpem_article_pages'][0]));

    $compil = wp_get_post_terms( $post->ID, 'wpem_compilation_articles' );
    $magazine_number = wpem_get_meta( $compil[0]->term_id, 'magazine_number', 'wpem_compilation_articles' );

    $category = wp_get_post_terms( $post->ID, 'wpem_article_category' );

    $new_pdf_url = $custom_fields['wpem_citation_pdf_url'][0];

    $post_link = get_permalink($post->ID);

    // CHECK lang
    if (ICL_LANGUAGE_CODE=='ru')
    {
        $title = $rus_article_name;
        $lang = '';
    }
    elseif (ICL_LANGUAGE_CODE=='en')
    {
        $title = $eng_article_name;
        $lang = 'en/';

        // Внедрение EN в URL если английская версия сайта
        $lang_en = array('en');
        $array_link = explode("/", $post_link);
        $chunk = array_chunk($array_link, 3);
        array_push($chunk[0], $lang_en[0]);
        $post_link = implode("/", array_merge($chunk[0], $chunk[1]));
    }


    $posts_array[$category[0]->name][] = array(
        'title_meta' => $title_meta,
        'title' => $title,
        'rus_authors' => $rus_authors,
        'rus_article_name' => $rus_article_name,
        'eng_authors' => $eng_authors,
        'eng_article_name' => $eng_article_name,
        'article_pages' => $article_pages,
        'new_pdf_url' => $new_pdf_url,
        'post_link' => $post_link,
    );



    ?>
<?php endwhile; // end of the loop. ?>

<?php foreach ($posts_array as $cat => $contents) : ?>
    <div class="article_category"><?php echo $cat; ?></div>
    <div class="post-content">
        <?php foreach ($contents as $content) : ?>
            <div style="padding-bottom: 20px;">
                <h4 style="padding: 0 0 20px 0;">
                    <a title="<?php echo $content['title_meta'];?>"
                       href="<?php echo $content['post_link']; ?>">
                        <?php echo $content['title']; ?>
                    </a>
                </h4>
                <?php
                    echo $content['rus_authors'].', '.
                        $content['eng_authors'].', '.
                        $content['rus_article_name'].' / '.
                        $content['eng_article_name'];

                    if ($content['article_pages'] != ' - ')
                    {
                        echo ', '.$content['article_pages'];
                    }
                ?>
                <div style="padding-bottom: 10px;">
                    <?php
                    // PDF
                    if ($content['new_pdf_url'] != null)
                    {
                        echo '<a href="' . $content['new_pdf_url'] . '">' . 'PDF' . '</a>';
                    }
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>

<?php get_footer(); ?>