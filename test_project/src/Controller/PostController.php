<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class PostController extends AbstractController
{
    public function __construct(private CollectionProvider $collectionProvider){}

    #[Route('/', name: 'post_index')]
    public function index(Request $request): Response
    {
        $operation = new GetCollection(
            class: Post::class,
            filters: ['post.filter_tag'] 
        );
        
        $posts = $this->collectionProvider->provide(
            $operation,
            [],
            ['request' => $request]
        );

        return $this->render('posts/posts.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/posts/{id}', name: 'post_show')]
    #[ParamConverter('post', class: 'App\Entity\Post')]
    public function show(Post $post): Response
    {
        return $this->render('posts/post.html.twig', [
            'post' => $post,
        ]);
    }
}
