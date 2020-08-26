<?php
require_once("../../../wp-load.php");

//var_dump($_POST);

$orderby = 'meta_value_num';

if( $_POST['exclude'] && !empty($_POST['exclude']) ){
    $exclude = explode(",", $_POST['exclude']);
}else{
    $exclude = '';
}

$offset = ($_POST['offset'] && !empty($_POST['offset'])) ? $_POST['offset'] : 15;

$order = ($_POST['order'] && !empty($_POST['order'])) ? $_POST['order'] : 'DESC';
$numb = ( $_POST['type'] && !empty($_POST['type']) && $_POST['type'] == 'showMore') ? '3' : $offset;

$field = ($_POST['field'] && !empty($_POST['field'])) ? $_POST['field'] : 'rating';

if( !empty($field) ){
    $metaKey = ($_POST['field'] && !empty($_POST['field'])) ? $_POST['field'] : 'rating';
}

/**
 * default query
 */
$args = array(
    'posts_per_page' => $numb,
    //'offset'         => $offset,
    'post_type'      => 'products',
    'post__not_in'   => $exclude,
    'post_status'    =>'publish',
    //'meta_key'       => $metaKey,
    'orderby'        => $orderby,
    'order'          => $order
);

if( $_POST['type'] != 'showMore' ) $offset = 0;

if($field == 'is_new'){
    $args['meta_query'] = array(
            array(
                'key' => 'is_new',
                'value' => '1',
            )
        );

    $metaKey = 'rating';
}

if($field == 'is_top'){
    $args['meta_query'] = array(
            array(
                'key' => 'is_top',
                'value' => '1',
            )
        );

    $metaKey = 'rating';
}

$subjectsPopular = get_terms(array(
    'taxonomy'			=> 'subject',
    'meta_query'		=> array(
        array(
            'key'			=> 'is_popular',
            'value'			=> '1',
            'compare'		=> '='
        )
    )
));

foreach($subjectsPopular as $term){
    $subjectsPopularIds[] = $term->slug; 
}

if($field == 'popular'){
    $args['subject'] = $subjectsPopularIds;
    $metaKey = 'rating';
}

$args['meta_key'] = $metaKey;
$args['offset'] = $offset;

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