
jQuery(document).ready(function($) {

    $('#stages_add_wishlist').click(function(e) {
        $.post(document.location.protocol +
               '//' +
               document.location.host +
               '/wp/wp-admin/admin-ajax.php',
            { action: 'stages_add_wishlist', postId: 100 },
            function(resp) {
                console.log(resp);
                alert(resp);
            });
    });
});