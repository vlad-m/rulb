<?php
/**
 * Created by PhpStorm.
 * User: arti
 * Date: 04.07.15
 * Time: 18:37
 */
    get_header(); // Подключаем хедер
?>

<?php get_template_part('includes/breadcrumbs', 'index'); ?>

<?php
    if ( is_single() )
    {
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

        $references  = maybe_unserialize($custom_fields['_wpem_article_literary_sources'][0]);

        $email  = implode(', ', maybe_unserialize($custom_fields['_wpem_article_author_email'][0]));
        $mailto = '<a href="mailto:' . $email . '">' . $email . '</a>';

        // Получение PDF
//        $post_name = $post->post_name . '?pdf=true';
//        $post_guid = '?post_type=wpem-article&p=' . $post->ID . '?preview=true' . '&pdf=true';
//        $pdf_url = $post_name != null ? $post_name : $post_guid;
        $new_pdf_url = $custom_fields['wpem_citation_pdf_url'][0];

        $article_doi  = maybe_unserialize($custom_fields['wpem_article_doi'][0]);
    }
?>

<!--PRE-->
<?php //echo '<pre>' . print_r($custom_fields, TRUE) . '</pre>'; ?>
<?php echo '<pre>' . print_r($first_page, TRUE) . '</pre>'; ?>

<!--PRE END-->

    <div id="content-area" class="clearfix fullwidth">
        <div id="left-area">
            <div class="post-content">

                <div id="et_pt_blog" class="responsive">

                    <?php // Шапка статьи
                        if ( is_single() )
                        {
                            echo '<div class="article_id"><b>Art#: </b>' . ($post->ID) . '</div>';
                            // DOI
                            if (($article_doi[wpem_citation_doi_url] and $article_doi[wpem_citation_doi_name]) != null)
                            {
                                echo '<div class="article_doi"><b>DOI: </b>' .
                                     '<a href="http://' . $article_doi[wpem_citation_doi_url] . '" target="_blank">' . $article_doi[wpem_citation_doi_name] . '</a>'
                                    . '</div>';
                            }
                            // PDF
                            if ($new_pdf_url != null)
                            {
                                echo '<div class="article_pdf_url"><a href="' . $new_pdf_url . '">' . 'PDF' . '</a></div>';
                            }

                            // Автор
                            echo '<div class="rus_authors">' . $rus_authors.'<br>' . '</div>';
                            // Работа
                            echo '<div class="rus_work">' . $rus_work.'<br>' . '</div>';
                            // Название статьи
                            echo '<div class="rus_article_name">' . $rus_article_name.'<br>' . '</div>';
                            // Анотация
                            echo '<div class="rus_annotation" ><span>Аннотация</span><div clsss="clearfix"></div>' . $rus_annotation . '</div>';
                            // Ключевые слова
                            echo '<div class="rus_keywords"><b>Ключевые слова: </b>' . ($rus_keywords) . '</div>';
                            // Количество сраниц
                            if ($article_pages != ' - ')
                            {
                                echo '<div class="article_pages"><b>Количество страниц: </b>' . $article_pages. '</div>';
                            }

                            echo '<br>';

                            echo '<div class="eng_authors">' . $eng_authors . '</div>';
                            echo '<div class="eng_work">' . $eng_work . '</div>';
                            echo '<div class="eng_article_name">' . $eng_article_name . '</div>';
                            echo '<div class="eng_annotation" ><span>Abstract</span><div clsss="clearfix"></div>' . $eng_annotation . '</div>';
                            echo '<div class="eng_keywords"><b>Keywords: </b>' . $eng_keywords . '</div>';
                            if ($article_pages != ' - ')
                            {
                                echo '<div class="article_pages"><b>Pages: </b>' . ($article_pages) . '</div>';
                            }
                            // Почта
                            echo '<div class="author_email"><b>Почта авторов / Author Email: </b>' . $mailto . '</div>';

                        }
                    ?>

                    <?php the_content(); // Текст статьи ?>

                    <?php //  вывод спика литературы
                        echo '<div class="references">Список литературы / References: </div>';
                        echo '<div class="article_references"><ol>';
                        foreach($references as $key => $val) {
                            echo '<li>' . $val . '</li>';
                        }

                        echo '</div></ol>';

                        echo '<br>';
                    ?>

                    <?php // Копирайт
                        echo '<a rel="license" href="http://creativecommons.org/licenses/by/4.0/"><img alt="Лицензия Creative Commons - Creative Common Licence" style="border-width:0" src="http://i.creativecommons.org/l/by/4.0/88x31.png" /></a><br />Это произведение доступно по – This material is available under <a rel="license" href="http://creativecommons.org/licenses/by/4.0/"> Creative Commons «Attribution» («Атрибуция») 4.0 Всемирная</a>';
                    ?>

                </div>
            </div>
        </div>
    </div>
    <?php get_footer(); // Подключаем футер ?>