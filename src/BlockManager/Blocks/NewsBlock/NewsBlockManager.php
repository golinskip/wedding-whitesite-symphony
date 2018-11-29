<?php

namespace App\BlockManager\Blocks\NewsBlock;

use App\BlockManager\Base\BlockBase;
use App\BlockManager\Base\BlockModelInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use App\Entity\News;

class NewsBlockManager extends BlockBase
{
    public function getTwigParams(BlockModelInterface $model, Container $container, $attr) {
        $em = $container->get('doctrine.orm.entity_manager');
        $repository = $em->getRepository(News::class);
        if($attr['env'] == 'public') {
            $query = $repository->createQueryForPublic();
            $newsPath = "public_news_single";
            $newsListPath = 'public_news_list';
        } else {
            $query = $repository->createQueryForPrivate();
            $newsPath = "private_news_single";
            $newsListPath = 'private_news_list';
        }
        if($model->getLimit() > 0) {
            $query->setMaxResults($model->getLimit());
        }

        return [
            'news_list' => $query->getResult(),
            'news_path' => $newsPath,
            'news_list_path' => $newsListPath,
        ];
    }

    public function getTwigTemplate() {
        return '@BlockManagerTemplates/NewsBlock/index.html.twig';
    }
}