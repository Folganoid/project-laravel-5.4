<?php

namespace Corp\Repositories;

use Corp\Article;

class ArticlesRepository extends Repository
{

    public function __construct(Article $articles)
    {
        $this->model = $articles;
    }

    public function one($alias, $attr = []) {

        $article = parent::one($alias, $attr);

        if($article && !empty($attr)) {
            $article->load('comment');
            $article->comment->load('user');
        }

     return $article;

    }

}