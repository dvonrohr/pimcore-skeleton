<?php

declare(strict_types=1);

namespace App\Controller;

use DateTime;
use Pimcore\Controller\FrontendController;
use Pimcore\Model\DataObject\Blog;
use Pimcore\Model\DataObject\Post;
use Pimcore\Version;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for handling blog and post related actions.
 *
 * tst
 * This controller provides actions for:
 * - Listing all blog entries
 * - Showing detailed blog views
 * - Showing detailed post views
 *
 * @category   Controller
 *
 * @version    2.0
 *
 * @since      1.0
 *
 * @author     Daniel von Rohr <daniel.vonrohr@example.com>
 *
 * @see       https://github.com/yourusername/pimcore-skeleton
 * @see        \Pimcore\Controller\FrontendController
 */
class BlogController extends FrontendController
{
    /**
     * Renders the blog list page with all available blog entries.
     *
     * Lists all blog entries and provides them to the view along with
     * the current Pimcore version and a date formatting helper.
     *
     * @return Response Returns rendered blog list view
     *
     * @throws \Exception If blog listing cannot be retrieved
     *
     * @since  1.0
     *
     * @example GET /blog
     */
    #[Route('/blog1', name: 'blog_list')]
    public function blogListAction(): Response
    {
        $blogs = new Blog\Listing();

        return $this->render('blog/list.html.twig', [
            'version' => Version::getVersion(),
            'blogs' => $blogs->getObjects(),
            'formatDate' => [$this, 'formatDate'],
        ]);
    }

    /**
     * Blog index action.
     */
    public function indexAction(Request $request): Response
    {
        $blogListing = new Blog\Listing();

        return $this->render('blog/index.html.twig', [
            'blogs' => $blogListing->getObjects(),
        ]);
    }

    /**
     * Renders the detail page for a specific blog entry.
     *
     * Fetches and displays a single blog entry based on its ID.
     * If the blog entry is not found, a 404 error is thrown.
     *
     * @param int $id The ID of the blog entry to display
     *
     * @return Response Returns rendered blog detail view
     *
     * @throws NotFoundHttpException If the blog entry is not found
     * @throws \Exception            If blog entry cannot be retrieved
     *
     * @since  1.0
     *
     * @example GET /blog/123
     *
     * @see   https://your-docs.com/api/blog/{id}
     */
    #[Route('/blog/{id}', name: 'blog_detail', requirements: [
        'id' => '\d+',
    ])]
    public function blogDetailAction(Request $request, int $id): Response
    {
        $a = 3;
        $b = 5;

        $blog = Blog::getById($id);

        if (! $blog instanceof Blog) {
            throw $this->createNotFoundException('Blog not found');
        }

        return $this->render('blog/detail.html.twig', [
            'blog' => $blog,
            'formatDate' => [$this, 'formatDate'],
        ]);
    }

    /**
     * Renders the detail page for a specific post.
     *
     * Fetches and displays a single post based on its ID.
     * If the post is not found, a 404 error is thrown.
     *
     * @param int $id The ID of the post to display
     *
     * @return Response Returns rendered post detail view
     *
     * @throws NotFoundHttpException If the post is not found
     * @throws \Exception            If post cannot be retrieved
     *
     * @since  1.5
     *
     * @example GET /post/456
     *
     * @todo   Add pagination for comments
     */
    #[Route('/post/{id}', name: 'post_detail', requirements: [
        'id' => '\d+',
    ])]
    public function postDetailAction(Request $request, int $id): Response
    {
        $post = Post::getById($id);

        if (! $post instanceof Post) {
            throw $this->createNotFoundException('Post not found');
        }

        return $this->render('blog/post.html.twig', [
            'post' => $post,
            'formatDate' => [$this, 'formatDate'],
        ]);
    }

    /**
     * Formats a date according to the blog's standard format.
     *
     * This helper method formats a DateTime object into a standardized
     * string representation. If null is provided, an empty string is returned.
     *
     * @internal This method is only used internally for formatting dates in templates
     *
     * @api
     *
     * @param DateTime|null $date The date to format
     *
     * @return string The formatted date string in format 'd.m.Y' or empty string if date is null
     *
     * @deprecated since version 2.0, use Twig's date filter instead: {{ date|date('d.m.Y') }}
     * @see        https://twig.symfony.com/doc/3.x/filters/date.html
     * @since      1.0
     *
     * @example    formatDate(new DateTime('2024-01-15')) // returns "15.01.2024"
     * @example    formatDate(null) // returns ""
     */
    public static function formatDate(?DateTime $date): string
    {
        if (! $date) {
            return '';
        }

        return $date->format('d.m.Y');
    }
}
