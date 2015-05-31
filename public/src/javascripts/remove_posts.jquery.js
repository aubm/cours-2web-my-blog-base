(function($) {
    $(document).ready(function() {
        $(".remove-post").click(function() {
            var postId = $(this).data().postId;

            // Perform Ajax request
            $.ajax({
                url: "/admin/delete-post.php",
                method: "POST",
                data: {
                    post_id: postId
                }
            }).done(function(responseBody, textStatus, xhr) {
                if (xhr.status === 204) {
                    $("#post-" + postId).remove();
                }
            });
        });
    });
})(jQuery);