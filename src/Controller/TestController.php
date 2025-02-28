<?php

declare(strict_types=1);

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Pimcore\Model\DataObject\Blog;
use Pimcore\Model\DataObject\Blog\Listing;
use Pimcore\Version;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends FrontendController
{
    #[Route('/blog', name: 'blog_list')]
    public function blogListAction(): Response
    {
        $blogs = new Blog\Listing();

        return $this->render('blog/list.html.twig', [
            'version' => Version::getVersion(),
            'blogs' => $blogs->getObjects(),
            'formatDate' => [$this, 'formatDate'],
        ]);
    }

    public function testAction(Request $request): Response
    {
        // Create a new Blog listing
        $blogListing = new Listing();

        // Get the objects
        $blogs = $blogListing->getObjects();

        return $this->json([
            'success' => true,
            'data' => $blogs,
        ]);
    }
}
