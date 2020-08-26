<?php 
require_once '../../../wp-load.php';
global $wpdb;

$thumbnail_id = 36; //default image

$shippingMethod = [
    'Нова пошта',
    'Укрпошта',
    'Кур`єром'
];

$paymentMethod = [
    'Карткою',
    'Готівкою'
];

$sizeTerms = [9,8,10];
$colorTerms = [3,2,4];
$materialTerms = [11,12,13];
$subjectTerms = [14,23,24,25,26,27,28,29,30,31,32,15,33,34,35,36,37,38,16,17,18,19,20,21,22];

/**
 * @params $fieldName - field name
 * @params $fieldValue - field value
 * @params $postId - product id
 * @return true
 */
function setProductField($fieldName, $fieldValue, $postId){
    update_field($fieldName, $fieldValue, $postId);
}

$wpdb->query('START TRANSACTION');
for($i = 1; $i <= 1000; $i++){

    $price = rand(300, 500);
    $priceWithDiscont = $price - rand(50,100);
    $rating = rand(0,50);

    $productFields = [
        'price'              => $price,
        'price_with_discont' => $priceWithDiscont,
        'shipping_method'    => array_rand(array_flip($shippingMethod)),
        'payment_method'     => array_rand(array_flip($paymentMethod),1),
        'is_available'       => rand(0,1),
        'is_promotional'     => rand(0,1),
        'is_new'             => rand(0,1),
        'is_top'             => rand(0,1),
        'rating'             => ( ($rating > 0) ? ($rating /10) : 0 )
    ];

    $post_data = array(
        'post_title'    => 'Товар '.$i,
        'post_type'     => 'products',
        'post_content'  => 'post content',
        'post_status'   => 'publish',
        'post_author'   => 1
    );
    $postId = wp_insert_post($post_data);

    if(!is_wp_error($postId)){

        /**
         * add image
         */
        update_post_meta( $postId, '_thumbnail_id', $thumbnail_id);

        /**
         * set product fields
         */
        foreach($productFields as $fieldName => $fieldValue) {
            setProductField($fieldName, $fieldValue, $postId);
        }

        /**
         * add product terms (color, size, material)
         */
        wp_set_object_terms( 
            $postId, 
            array(
                $colorTerms[rand(0,2)]
            ),
            'color'
        );

        wp_set_object_terms( 
            $postId, 
            array(
                $sizeTerms[rand(0,2)]
            ),
            'size'
        );

        wp_set_object_terms( 
            $postId, 
            array(
                $materialTerms[rand(0,2)]
            ),
            'material'
        );
        
        wp_set_object_terms( 
            $postId, 
            array(
                $subjectTerms[rand(0,24)], 
                $subjectTerms[rand(0,24)], 
                $subjectTerms[rand(0,24)], 
                $subjectTerms[rand(0,24)],
                $subjectTerms[rand(0,24)]
            ),
            'subject'
        );
            
    }else{
        echo 'something wrong in wp_insert_post process';
    }
}

try {
    $wpdb->query('COMMIT');
} catch (Exception $e) {
    $wpdb->query('ROLLBACK');
    echo 'Somthing wrong in import script: ',  $e->getMessage(), "\n";
}

echo "************************************************************************************ \n";    
echo "************************************** Import is ready ***************************** \n";    
echo "************************************** ********************************************* \n";      
    
exit();