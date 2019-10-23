<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Service\Calculator;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends Controller
{
    private $calculator;
    private $postRespository;

    public function __construct(Calculator $calculator, PostRepository $postRepository)
    {
        $this->calculator = $calculator;
        $this->postRespository = $postRepository;
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function index(Request $request)
    {
        $result = $this->calculator->add(55, 42);

        $r = $this->render('blog/index.html.twig', [
            'result' => $result,
            'controller_name' => 'BlogController',
        ]);

        return $r;
    }

    /**
     * @Route("/calcul/{a}/{b}", name="calcul", requirements={"a"="\d+", "b"="\d+"})
     */
    public function add(int $a, int $b)
    {
        $result = $this->calculator->add($a, $b);

        return $this->render('blog/add.html.twig', [
            'a' => $a,
            'b' => $b,
            'result' => $result,
        ]);
    }

    /**
     * @Route("/posts", name="posts")
     */
    public function posts()
    {
        $posts = $this->postRespository->findAllPublishedPosts();

        return $this->render('blog/posts.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/post/{slug}", name="post_show")
     */
    public function show(string $slug)
    {
        $post = $this->postRespository->findOneBy([
            'slug' => $slug,
        ]);

        if ($post == null) {
            throw $this->createNotFoundException('Post not found');
        }

        return $this->render('blog/post.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @Route("/new/post", name="post_new")
     */
    public function new(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $this->getDoctrine()->getManager()->persist($post);
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash('success', 'Article enregistré !');

                return $this->redirectToRoute('post_new');
            }
        }

        return $this->render('blog/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
