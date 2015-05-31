(function () {
    window.addEventListener("load", function () {
        var postsList = document.getElementById("posts-list");
        var removeButtonElements = document.querySelectorAll(".remove-post");
        for (var i = 0; i < removeButtonElements.length; i++) {
            var removeButtonElement = removeButtonElements[i];
            removeButtonElement.addEventListener("click", function() {
                var postId = this.getAttribute("data-post-id");
                var requestBody = "post_id=" + postId;

                // Perform Ajax request
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        console.log(xhr.status);
                        if (xhr.status === 204) {
                            var postElement = document.getElementById("post-" + postId);
                            postsList.removeChild(postElement);
                        }
                    }
                };
                xhr.open("POST", "/admin/delete-post.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.setRequestHeader("Content-length", requestBody.length);
                xhr.setRequestHeader("Connection", "close");
                xhr.send(requestBody);
            });
        }
    });
})();