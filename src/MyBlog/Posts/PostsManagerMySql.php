<?php

namespace MyBlog\Posts;

use MyBlog\Database\MySqlDatabase;
use MyBlog\Utils\FilesHelper;
use MyBlog\Validation\HasValidationErrorsException;
use MyBlog\Validation\ValidationError;
use MyBlog\Validation\ValidationErrorsCollection;

class PostsManagerMySql implements PostsManagerInterface
{
    /**
     * @var MySqlDatabase
     */
    private $db;

    private $posts_original_images_dir;
    private $posts_original_thumbnails_dir;

    public function __construct($posts_original_images_dir, $posts_original_thumbnails_dir)
    {
        $this->db = MySqlDatabase::getInstance();

        $this->posts_original_images_dir = $posts_original_images_dir;
        $this->posts_original_thumbnails_dir = $posts_original_thumbnails_dir;
    }

    public function getAllPosts()
    {
        $posts = [];
        $statement = $this->db->prepare('SELECT * FROM posts');
        $statement->execute();
        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $posts[] = new Post($row);
        }
        return $posts;
    }

    public function getOnePostBySlug($post_slug)
    {
        $post = null;
        $statement = $this->db->prepare('SELECT * FROM posts WHERE slug = :slug');
        $statement->bindParam('slug', $post_slug);
        $statement->execute();
        $row = $statement->fetch(\PDO::FETCH_ASSOC);
        if ($row) {
            $post = new Post($row);
        }
        return $post;
    }

    public function getOnePostById($post_id)
    {
        $post = null;
        $statement = $this->db->prepare('SELECT * FROM posts WHERE id = :id');
        $statement->bindParam('id', $post_id);
        $statement->execute();
        $row = $statement->fetch(\PDO::FETCH_ASSOC);
        if ($row) {
            $post = new Post($row);
        }
        return $post;
    }

    public function validatePost(Post $post)
    {
        $validation_errors_collection = new ValidationErrorsCollection();

        // Validate title
        $post_title = $post->getTitle();
        if (!$post_title) {
            $validation_errors_collection->addValidationError(
                new ValidationError('title', 'Vous devez renseigner un titre')
            );
        }

        // Validate slug
        $post_slug = $post->getSlug();
        if ($post_slug) {
            if (!preg_match('#^[a-z0-9\-]+$#', $post_slug)) {
                $validation_errors_collection->addValidationError(
                    new ValidationError('slug', 'Le format de l\'alias est invalide')
                );
            } else {
                if ($this->getOnePostBySlug($post_slug)) {
                    $validation_errors_collection->addValidationError(
                        new ValidationError('slug', 'Un article utilise déjà cet alias')
                    );
                }
            }
        } else {
            $validation_errors_collection->addValidationError(
                new ValidationError('slug', 'Vous devez renseigner un alias')
            );
        }

        // Validate illustration_original
        $post_illustration_original = $post->getIllustrationOriginal();
        if (!$post_illustration_original) {
            $post_uploaded_illustration_original = $post->getUploadedIllustrationOriginal();
            if (!$post_uploaded_illustration_original) {
                $validation_errors_collection->addValidationError(
                    new ValidationError('illustration_original', 'Vous devez choisir une image pour illustrer l\'article')
                );
            } else {
                if (!in_array($post_uploaded_illustration_original->getType(),
                    ['image/png', 'image/jpg', 'image/jpeg', 'image/gif'])
                ) {
                    $validation_errors_collection->addValidationError(
                        new ValidationError('illustration_original',
                            'Le format du fichier n\'est pas autorisé')
                    );
                }
            }
        }

        // Validation illustration_preview
        $post_illustration_preview = $post->getIllustrationPreview();
        if (!$post_illustration_preview) {
            $post_uploaded_illustration_preview = $post->getUploadedIllustrationPreview();
            if (!$post_uploaded_illustration_preview) {
                $validation_errors_collection->addValidationError(
                    new ValidationError('illustration_preview',
                        'Vous devez choisir une image pour la prévisualisation de l\'article')
                );
            } else {
                if (!in_array($post_uploaded_illustration_preview->getType(),
                    ['image/png', 'image/jpg', 'image/jpeg', 'image/gif'])
                ) {
                    $validation_errors_collection->addValidationError(
                        new ValidationError('illustration_preview',
                            'Le format du fichier n\'est pas autorisé')
                    );
                }
            }
        }

        // Validate content_short
        $post_content_short = $post->getContentShort();
        if (!$post_content_short) {
            $validation_errors_collection->addValidationError(
                new ValidationError('content_short',
                    'Vous devez renseigner une version courte pour le contenu de l\'article')
            );
        }

        // Validate content
        $post_content = $post->getContent();
        if (!$post_content) {
            $validation_errors_collection->addValidationError(
                new ValidationError('content', 'Vous devez renseigner le contenu de l\'article')
            );
        }

        if ($validation_errors_collection->getErrorsCount() > 0) {
            $exception = new HasValidationErrorsException();
            $exception->setValidationErrorsCollection($validation_errors_collection);
            throw $exception;
        }
    }

    public function savePost(Post $post)
    {
        $files_helper = new FilesHelper();

        if ($post->getUploadedIllustrationOriginal()) {
            $illustration_original_filename =
                $files_helper->moveRequestFile($post->getUploadedIllustrationOriginal(), $this->posts_original_images_dir);
            $post->setIllustrationOriginal($illustration_original_filename);
        }

        if ($post->getUploadedIllustrationPreview()) {
            $illustration_preview_filename =
                $files_helper->moveRequestFile($post->getUploadedIllustrationPreview(), $this->posts_original_thumbnails_dir);
            $post->setIllustrationPreview($illustration_preview_filename);
        }

        if (!$post->getId()) {
            $this->_insertNewPost($post);
        }
    }

    private function _insertNewPost(Post $post)
    {
        $query = 'INSERT INTO posts (title, slug, published_at, illustration_original, illustration_preview, content_short, content)';
        $query .= 'VALUES (:title, :slug, :published_at, :illustration_original, :illustration_preview, :content_short, :content)';
        $statement = $this->db->prepare($query);
        $statement->bindValue('title', $post->getTitle());
        $statement->bindValue('slug', $post->getSlug());
        $statement->bindValue('published_at', $post->getPublishedAt('Y-m-d h:i:s'));
        $statement->bindValue('illustration_original', $post->getIllustrationOriginal());
        $statement->bindValue('illustration_preview', $post->getIllustrationPreview());
        $statement->bindValue('content_short', $post->getContentShort());
        $statement->bindValue('content', $post->getContent());
        $statement->execute();
    }
}
