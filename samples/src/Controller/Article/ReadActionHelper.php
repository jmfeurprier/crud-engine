<?php

namespace App\Controller\Article;

use App\Entity\Article;
use App\Service\ArticleCommentsResolverInterface;
use Jmf\CrudEngine\Controller\Helpers\ReadActionHelperBase;
use Override;
use Symfony\Component\HttpFoundation\Request;

class ReadActionHelper extends ReadActionHelperBase
{
    public function __construct(
        private readonly ArticleCommentsResolverInterface $articleCommentsResolver,
    ) {
    }

    #[Override]
    public function getViewVariables(
        Request $request,
        object $entity,
    ): array {
        /* @var Article $entity */

        return [
            'comments' => $this->articleCommentsResolver->resolve($entity),
        ];
    }
}
