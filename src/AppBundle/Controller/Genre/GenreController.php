<?php

namespace AppBundle\Controller\Genre;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends Controller {
    /**
     * @Route("/genre", name="genre_list")
     */
    public function listAction() {
        return $this->render("Genre/list.html.twig");
    }
}