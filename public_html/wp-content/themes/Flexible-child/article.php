<?php
/**
 * Created by PhpStorm.
 * User: arti
 * Date: 01.07.15
 * Time: 20:46
 */

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

    }


    if ( is_single() )
    {
        echo '<div style="font-weight: bold;">' . ($rus_authors.'<br>') . '</div>';
        echo '<br>';
        echo ($rus_work.'<br>');
        echo '<br>';
        echo '<div style="font-weight: bold;">' . ($rus_article_name.'<br>') . '</div>';
        echo '<br>';
        echo '<div style="float:right; font-style: italic; font-weight: bold;">' . Аннотация . '</div>';
        echo '<div style="clear: both;">' . '</div>';
        echo ($rus_annotation.'<br>');
        echo '<br>';
        echo '<span style="font-weight: bold;">Keywords: </span>' . ($rus_keywords.'<br>');

        echo '<br>';
        echo '<br>';

        echo '<div style="font-weight: bold;">' . ($eng_authors.'<br>') . '</div>';
        echo '<br>';
        echo ($eng_work.'<br>');
        echo '<br>';
        echo '<div style="font-weight: bold;">' . ($eng_article_name.'<br>') . '</div>';
        echo '<br>';
        echo '<div style="float:right; font-style: italic; font-weight: bold;">' . Annotation . '</div>';
        echo '<div style="clear: both;">' . '</div>';
        echo ($eng_annotation.'<br>');
        echo '<br>';
        echo '<span style="font-weight: bold;">Keywords: </span>' . ($eng_keywords.'<br>');

        echo '<br>';
        echo '<br>';
    }
?>

