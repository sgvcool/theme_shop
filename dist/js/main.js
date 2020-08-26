$(document).ready(function () {

    /**
     * show more
     */
    var offset = ( $('.show-more').attr('data-offset') != '') ? $('.show-more').attr('data-offset') : 15;
    offset = parseInt(offset);
    $(".show-more").on('click',
        function () {
            let excludeIds = $(this).attr('data-ids');

            let order = $(this).attr('data-order');
            let field = $(this).attr('data-field');

            

            $.ajax({
                url: "/wp-content/themes/theme_shop/ajax.php",
                type: "POST",
                cache: !0,
                data: "type=showMore&offset=" + offset + "&exclude=" + excludeIds + "&order=" + order + "&field=" + field,
                
                success: function (data) {
                    offset += 3;
                    $("#load-cont").append(data);

                    $('.show-more').attr('data-offset', offset);
                },

                error: function () {
                    alert("Error"), $(this).hide();
                }
            });
        }   
    );

    /**
     * ajax sort
     */
    $(".product_sort__panel span").on('click', function () {

        let order = $(this).attr('data-order');
        let field = $(this).attr('data-field');
        let excludeIds = $('.show-more').attr('data-ids');

        let offset = $('.show-more').attr('data-offset');

        console.log(offset);

        $('.show-more').attr('data-order', order);
        $('.show-more').attr('data-field', field);

        $.ajax({
            url: "/wp-content/themes/theme_shop/ajax.php",
            type: "POST",
            cache: !0,
            data: "type=sort&exclude=" + excludeIds + "&order=" + order + "&field=" + field + "&offset="+ offset,
            success: function (data) {
                $("#load-cont").html(data)
            },
            error: function () {
                alert("Error"), $(this).hide();
            }
        });
    });

});