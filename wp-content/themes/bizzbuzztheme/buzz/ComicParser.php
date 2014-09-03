<?php
  class ComicParser {
    public $comicId;
    public $comic;
    public $thumbnail;
    public $cover;
    public $pages;
    public $images;
    public $authors;
    public $writer;
    public $illustrator;
    public $title;
    public $excerpt;
    public $content;
    public $related;
    public $publishDate;
    public $license;
    public $tags;

    function __construct($comic) {
      $this->comic = $comic;
      $this->comicId = $comic->ID;
    }

    function getTags() {
      if($this->tags) {
        return $this->tags;
      }

      return $this->tags = get_the_terms($comic->ID, "tag");
    }

    function getId() {
      return $this->comicId;
    }

    function getPublishDate() {
      if ($this->publishDate) {
        return $this->publishDate;
      }

      $publish_meta = get_post_meta($this->comicId, "publishdate", true);
      if ($publish_meta && sizeof($publish_meta)>0) {
        return $this->publishDate = $publish_meta[0]["date"];
      }
    }

    function getLicense() {
      if ($this->license) {
        return $this->license;
      }

      $license_meta = get_post_meta($this->comicId, "license", true);
      if ($license_meta && sizeof($license_meta)>0) {
        return $this->license = $license_meta[0]["license"];
      }
    }


    function getPages() {
      if ($this->pages) {
        return $this->pages;
      }

      $pages_meta = get_post_meta($this->comicId, "Pages", true);
      $pages = Array();
      if (sizeof($pages_meta)>0) {
        foreach($pages_meta as $page) {
          $url = $page["url"];
          $coordinates = explode("\n",$page["coordinates"]);
          array_push($pages, array(
            "url" => $url,
            "coordinates" => $coordinates
          ));
        }
      }

      return $this->pages = $pages;
    }

    function getPagesForJs() {
      return json_encode($this->getPages());
    }

    function getContent() {
      if ($this->content) {
        return $this->content;
      }

      return $this->content = $this->comic->post_content;
    }

    function getExcerpt() {
      if ($this->excerpt) {
        return $this->excerpt;
      }

      return $this->excerpt = $this->comic->post_excerpt;
    }

    function getTitle() {
      if ($this->title) {
        return $this->title;
      }

      return $this->title = $this->comic->post_title;
    }

    function getImages() {
      $this->images = get_post_meta( $this->comicId, 'images', true ); 
    }

    function getAuthors() {
      $this->authors = get_post_meta( $this->comicId, 'authors', true ); 
    }

    function getWriter() {
      if ($this->writer) {
        return $this->writer;
      }

      $this->getAuthors();

      if($this->authors && $this->authors[0]["writer"]) {
        return $this->writer = $this->authors[0]["writer"];
      }
    }

    function getIllustrator() {
      if ($this->illustrator) {
        return $this->illustrator;
      }

      $this->getAuthors();

      if($this->authors && $this->authors[0]["illustrator"]) {
        return $this->illustrator = $this->authors[0]["illustrator"];
      }
    }

    function getThumbnail() {
      if ($this->thumbnail) {
        return $this->thumbnail;
      }

      $this->getImages();

      if($this->images && $this->images[0]["thumbnail"]) {
        return $this->thumbnail = $this->images[0]["thumbnail"];
      }
    }

    function getCover() {
      if ($this->cover) {
        return $this->cover;
      }

      $this->getImages();

      if($this->images && $this->images[0]["cover"]) {
        return $this->cover = $this->images[0]["cover"];
      }
    }
    
  }
