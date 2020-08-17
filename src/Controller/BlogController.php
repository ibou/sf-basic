<?php

namespace App\Controller;

use App\Entity\BlogPost;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/blog")
 */

class BlogController extends AbstractController
{

    /**
     * @Route("/", name="blog_list", methods={"GET"}, defaults={"page": 1}, requirements={"page"="\d+"})
     */
    public function list(int $page = 1, Request $request)
    {
        $limit = (int) $request->get('limit', 14);
        $repository = $this->getDoctrine()
            ->getRepository(BlogPost::class);
        $items = $repository->findAll();

        return $this->json([

            'page' => $page,
            'limit' => $limit,
            'data' => array_map(function (BlogPost $item) {
                return $this->generateUrl('blog_by_slug', [
                    'slug' => $item->getSlug()
                ]);
            }, $items)
        ]);
    }

    /**
     * @Route("/posts/{id}", name="blog_by_id", requirements={"id"="\d+"})
     * @ParamConverter("post", class="App:BlogPost")
     */
    public function post(BlogPost $post)
    {
        return $this->json(
            $post
        );
    }

    /**
     * @Route("/posts/{slug}", name="blog_by_slug") 
     */
    public function postBySlug(BlogPost $post)
    {
        return $this->json(
            $post
        );
    }

    /**
     * @Route("/add", name="blog_add", methods={"POST"})
     */
    public function add(Request $request, SerializerInterface $serializer)
    {
        $blogPost = $serializer->deserialize($request->getContent(), BlogPost::class, 'json');
        $em = $this->getDoctrine()->getManager();
        $em->persist($blogPost);
        $em->flush();
        return $this->json($blogPost);
    }

    /**
     *
     * @Route("/posts/{id}/delete", name="blog_delete", methods={"DELETE"})
     */
    public function delete(BlogPost $post)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
