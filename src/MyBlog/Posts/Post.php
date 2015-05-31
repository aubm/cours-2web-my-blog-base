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

    public function __construct($state = [])
    {
        if (isset($state['id'])) $this->id = $state['id'];
        if (isset($state['title'])) $this->title = $state['title'];
        if (isset($state['slug'])) $this->slug = $state['slug'];
        if (isset($state['illustration_original'])) $this->illustration_original = $state['illustration_original'];
        if (isset($state['illustration_preview'])) $this->illustration_preview = $state['illustration_preview'];
        if (isset($state['content_short'])) $this->content_short = $state['content_short'];
        if (isset($state['content'])) $this->content = $state['content'];

        if (isset($state['published_at'])) {
            $this->published_at = new \Datetime($state['published_at']);
        } else {
            $this->published_at = new \Datetime();
        }
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

    public function getPublishedAt($format = null)
    {
        if ($format !== null && is_string($format)) {
            return $this->published_at->format($format);
        }

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

        $date_string = '';
        $date_string .= $week_days_map[$this->published_at->format('N')] . ' ';
        $date_string .= $this->published_at->format('d') . ' ';
        $date_string .= $months_map[$this->published_at->format('n')] . ' ';
        $date_string .= $this->published_at->format('Y');
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