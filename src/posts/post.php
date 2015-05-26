<?php

class Post
{
    private $title;
    private $slug;
    private $published_at;
    private $illustration_original;
    private $illustration_preview;
    private $content_short;
    private $content;

    public function __construct($state)
    {
        $this->title = $state['title'];
        $this->slug = $state['slug'];
        $this->published_at = $state['published_at'];
        $this->illustration_original = $state['illustration_original'];
        $this->illustration_preview = $state['illustration_preview'];
        $this->content_short = $state['content_short'];
        $this->content = $state['content'];
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getPublishedAt()
    {
        return $this->published_at;
    }

    public function getIllustrationOriginal()
    {
        return $this->illustration_original;
    }

    public function getIllustrationPreview()
    {
        return $this->illustration_preview;
    }

    public function getContentShort()
    {
        return $this->content_short;
    }

    public function getContent()
    {
        return $this->content;
    }
}