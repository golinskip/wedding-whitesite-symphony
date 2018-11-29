<?php

namespace App\Controller\PrivateSite;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\News;

class NewsController extends AbstractController
{
    /**
     * @Route("/news/{page}", defaults={"page"=1}, name="private_news_list")
     */
    public function index(PaginatorInterface $paginator, Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $this->getDoctrine()
            ->getRepository(News::class)
            ->createQueryForPrivate();

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $page/*page number*/,
            4/*limit per page*/
        );

        return $this->render('private_site/news/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/news/show/{slug}", name="private_news_single")
     */
    public function single($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $news = $this->getDoctrine()
            ->getRepository(News::class)
            ->findOneBySlugPrivate($slug);

        if($news === null) {
            throw new HttpNotFoundException('News not found');
        }

        return $this->render('private_site/news/single.html.twig', [
            'news' => $news,
        ]);
    }
}
