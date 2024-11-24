jQuery(function($) {
    $(document.body).on('added_to_cart removed_from_cart', function() {
        $.post(cart_params.ajax_url, {
            action: 'update_cart_count'
        }, function(response) {
            $('.header-cart .cart-count').text(response);
        });
    });
});
