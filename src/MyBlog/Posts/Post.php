<?php

namespace MyBlog\Posts;

class Post
{
    private $id;
    private $title;
    private $slug;
    private $published_at;
    private $illustration_original;
    private $illustration_preview;
    private $content_short;
    private $content;

    public function __construct($state)
    {
        $this->id = $state['id'];
        $this->title = $state['title'];
        $this->slug = $state['slug'];
        $this->published_at = $state['published_at'];
        $this->illustration_original = $state['illustration_original'];
        $this->illustration_preview = $state['illustration_preview'];
        $this->content_short = $state['content_short'];
        $this->content = $state['content'];
    }

    public function getId()
    {
        return $this->id;
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
        $week_days_map = [
            '1' => 'Lundi', '2' => 'Mardi', '3' => 'Mercredi', '4' => 'Jeudi',
            '5' => 'Vendredi', '6' => 'Samedi', '7' => 'Dimanche'
        ];
        $months_map = [
            '1' => 'Janvier', '2' => 'Février', '3' => 'Mars', '4' => 'Avril',
            '5' => 'Mai', '6' => 'Juin', '7' => 'Juillet', '8' => 'Août',
            '9' => 'Septembre', '10' => 'Octobre', '11' => 'Novembre',
            '12' => 'Décembre'
        ];

        $published_at = new \Datetime($this->published_at);

        $date_string = '';
        $date_string .= $week_days_map[$published_at->format('N')] . ' ';
        $date_string .= $published_at->format('d') . ' ';
        $date_string .= $months_map[$published_at->format('n')] . ' ';
        $date_string .= $published_at->format('Y');
        return $date_string;
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