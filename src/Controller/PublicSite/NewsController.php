<?php

namespace App\Controller\PublicSite;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\News;

class NewsController extends AbstractController
{
    /**
     * @Route("/news/{page}", defaults={"page"=1}, name="public_news_list")
     */
    public function index(PaginatorInterface $paginator, Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $this->getDoctrine()
            ->getRepository(News::class)
            ->createQueryForPublic();

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $page/*page number*/,
            4/*limit per page*/
        );

        return $this->render('public_site/news/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/news/show/{slug}", name="public_news_single")
     */
    public function single($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $news = $this->getDoctrine()
            ->getRepository(News::class)
            ->findOneBySlugPublic($slug);

        if($news === null) {
            throw new HttpNotFoundException('News not found');
        }

        return $this->render('public_site/news/single.html.twig', [
            'news' => $news,
        ]);
    }
}
