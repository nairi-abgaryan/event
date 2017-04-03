<?php

namespace AppBundle\Controller;

use AppBundle\Entity\News;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/news")
 */
class NewsController extends FOSRestController
{
    /**
     * @Route("/", name="news")
     */
    public function listAction()
    {
        $news = $this->get("app.news_manager")->findAll();
        return $this->render(":show:news.html.twig", [
            "news"=>$news
        ]);
    }

    /**
     * @Route("/", name="news")
     */
    public function retrieveAction()
    {
        $news = $this->get("app.news_manager")->findAll();
        return $this->render(":show:news.html.twig", [
            "news"=>$news
        ]);
    }

    /**
     * @Route("/{id}/", name="news")
     * @param News $news
     * @return mixed
     */
    public function newsAction(News $news)
    {
        return $this->render(":news:news.html.twig", [
            "news"=>$news
        ]);
    }
}