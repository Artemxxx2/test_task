<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\Metadata\GetCollection;
use App\Entity\Tag;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class TagController extends AbstractController
{
    public function __construct(private CollectionProvider $collectionProvider){}

    #[Route('/tags', name: 'tag_index')]
    public function index(Request $request): Response
    {
        $page = (int)$request->get('page',1);

        $operation = new GetCollection(
            class: Tag::class,
            paginationEnabled: true,
            paginationItemsPerPage: 30,
            paginationClientItemsPerPage: false, 
        );
        
        $tags = $this->collectionProvider->provide(
            $operation,
            [],
            [
                'request' => $request,
                'resource_class' => Tag::class,
                'filters' => ['page' => $page]
            ]
        );
        
        return $this->render('tags/tags.html.twig', [
            'tags' => $tags,
            'currentPage' => $tags->getCurrentPage(),
            'lastPage' => $tags->getLastPage(),
            'itemsPerPage' => $tags->getItemsPerPage()
        ]);
    }
}
