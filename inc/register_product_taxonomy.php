<?php
function register_product_taxonomy() {

    $productTerms = [
        'Subject' => 'Тематика',
        'Color' => 'Колір',
        'Material' => 'Матеріал',
        'Size' => 'Розмір'
    ];

    foreach($productTerms as $taxEnName => $taxUaName){
        register_taxonomy( 
            strtolower($taxEnName), 
            'products',
            array(
                'labels' => array(
                    'name'              => $taxUaName,
                    'singular_name'     => strtolower($taxEnName),
                    'search_items'      => 'Пошук',
                    'all_items'         => 'Всі',
                    'edit_item'         => 'Редагувати',
                    'update_item'       => 'Оновити',
                    'add_new_item'      => 'Додати нову',
                    'new_item_name'     => 'Нова',
                    'menu_name'         => $taxUaName,
                ),
                'hierarchical' => true,
                'sort' => true,
                'args' => array( 'orderby' => 'term_order' ),

                'public' => true,
                'rewrite' => true,
                'show_admin_column' => true
            )
        );
    }
}
add_action( 'init', 'register_product_taxonomy' );