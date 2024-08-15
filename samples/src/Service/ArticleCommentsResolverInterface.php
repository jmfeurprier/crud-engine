<?php

namespace App\Service;

use App\Entity\Article;
use App\Entity\Comment;

interface ArticleCommentsResolverInterface
{
    /**
     * @return Comment[]
     */
    public function resolve(Article $article): iterable;
}
