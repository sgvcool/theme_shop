<?php get_header(); ?>
<div class="container" style="max-width: 700px; margin: auto">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h1><?php the_title();?></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="block-title">
                Top 15
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <ul class="product-list__container">
                <?php
                /**
                 * get top 10
                 */
                $subjectsTop10 = get_terms(array(
                    'taxonomy'			=> 'subject',
                    'meta_query'		=> array(
                        'relation'		=> 'AND',
                        array(
                            'key'			=> 'show_in_sb',
                            'value'			=> '1',
                            'compare'		=> '='
                        ),

                        array(
                            'key'			=> 'is_popular',
                            'value'			=> '1',
                            'compare'		=> '='
                        ),

                         array(
                            'key'			=> 'specialization',
                            'value'         => serialize(array('1','3','5')),
                            'compare'       => '==',
                         ),

                    )
                ));

                foreach($subjectsTop10 as $term){
                    $alterTerms10[] = $term->slug; 
                }

                $topProductId = [];
                $args = array(
                    'posts_per_page' => 10,
                    'post_type' => 'products',
                    'post_status'=>'publish',

                    'meta_query' => array(
                        array(
                            'key' => 'is_promotional',
                            'value' => '0',
                        ),
                    ),

                    'color' => 'blue',
                    'material' => 'metal',
                    'size' => 'l',
                    'subject' => $alterTerms10,

                    'meta_key' =>'rating',
					'orderby' => 'meta_value_num',
                    'order'    => 'DESC'
                );

                query_posts($args);
                if ( have_posts() ) while ( have_posts() ) : the_post();
                    $topProductId[] = $post->ID; ?>
                    <li class="product-list__item">
                        <div class='product-list-item__img-block'>
                            <a href="<?php the_permalink();?>">
                                <?php the_post_thumbnail('product');?>
                            </a>
                        </div>
                        <?php the_title(); ?>
                    </li>
                <?php
                endwhile;
                wp_reset_query(); 
               

                /**
                 * get top 5
                 */
                $subjectsTop5 = get_terms(array(
                    'taxonomy'			=> 'subject',
                    'meta_query'		=> array(
                        'relation'		=> 'AND',
                        array(
                            'key'			=> 'show_in_sb',
                            'value'			=> '1',
                            'compare'		=> '='
                        ),

                        array(
                            'key'			=> 'is_popular',
                            'value'			=> '1',
                            'compare'		=> '='
                        ),

                         array(
                            'key'			=> 'specialization',
                            'value'         => serialize(array('2','4')),
                            'compare'       => '==',
                         ),

                    )
                ));

                foreach($subjectsTop5 as $term){
                    $alterTerms5[] = $term->slug; 
                }

                $args = array(
                    'posts_per_page' => 5,
                    'post_type' => 'products',
                    'post_status'=>'publish',

                    'meta_query' => array(
                        array(
                            'key' => 'is_promotional',
                            'value' => '0',
                        ),
                    ),

                    'color' => array('red','green'),
                    'material' => array('wooden', 'plastic'),
                    'size' => 'xl',
                    'subject' => $alterTerms5,

                    'meta_key' =>'rating',
					'orderby' => 'meta_value_num',
                    'order'    => 'DESC'
                );

                query_posts($args);
                if ( have_posts() ) while ( have_posts() ) : the_post(); 
                    $topProductId[] = $post->ID;?>
                    <li class="product-list__item">
                        <div class='product-list-item__img-block'>
                            <a href="<?php the_permalink();?>">
                                <?php the_post_thumbnail('product');?>
                            </a>
                        </div>
                        <?php the_title(); ?>
                    </li>
                <?php
                endwhile;
                wp_reset_query(); 
                ?>

            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="block-title">
                всі шнші товари
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 product_sort__panel">
            <div><strong>Сортування:</stong></div>

            <span data-field="price" data-order="ASC">від дешевшого</span>
            <span data-field="price" data-order="DESC">від дорожчого</span>
            <span data-field="rating" data-order="DESC">за рейтингом</span>

            <span data-field="is_new" data-order="">За новизною</span>
            <span data-field="is_top" data-order="">за топовістю</span>
            <span data-field="popular" data-order="">за популярністю</span>

        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <ul class="product-list__container" id="load-cont">
                <?php

                $args = array(
                    'posts_per_page' => 15,
                    'post_type' => 'products',
                    'post__not_in' => $topProductId,
                    'post_status'=>'publish',
                    'meta_key' =>'rating',
					'orderby' => 'meta_value_num',
                    'order'    => 'DESC'
                );

                query_posts($args);
                if ( have_posts() ) while ( have_posts() ) : the_post();
                
                    ?>
                    <li class="product-list__item">
                        <div class='product-list-item__img-block'>
                            <a href="<?php the_permalink();?>">
                                <?php the_post_thumbnail('product');?>
                            </a>
                        </div>
                        <div>
                            Рейтинг: <?php $rating = round(get_field('rating', $post->ID));?>
                            <div class="product-list-item__rating_block">
                                <?php 
                                if($rating > 0){
                                    for($i = 1; $i <= $rating; $i++){ ?>
                                        <input name="rating" value="<?=$i?>" id="rating_<?=$i?>" type="radio" />
                                        <label for="rating_<?=$i?>" class="label_rating"></label>
                                    <?php }
                                }else{
                                    for($i = 1; $i <= 5; $i++){ ?>
                                        <input name="rating" value="<?=$i?>" id="rating_<?=$i?>" type="radio" />
                                        <label for="rating_<?=$i?>" class="label_rating noactive"></label>
                                    <?php }
                                }
                                    
                                ?>
                            </div>
                        </div>
                        <?php the_title(); ?>
                        <div class="product-list-item__price">
                            Ціна: <strong><?php echo get_field('price', $post->ID);?> грн.</strong>
                        </div>
                    </li>
                <?php
                endwhile;
                wp_reset_query(); 
                ?>
            </ul>

            <div 
                class = "show-more" 
                data-offset = "15" 
                data-field = ""
                data-order = "DESC"
                data-ids = "<?=implode(",", $topProductId);?>">
                показати більше
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php the_content(); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>