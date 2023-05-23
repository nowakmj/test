<?php
/**
 * Notice controller.
 */

namespace App\Controller;

use App\Entity\Notice;
use App\Repository\NoticeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class NoticeController.
 */
#[Route('/notice')]
class NoticeController extends AbstractController
{
    /**
     * Index action.
     *
     * @param Request            $request        HTTP Request
     * @param NoticeRepository     $noticeRepository Notice repository
     * @param PaginatorInterface $paginator      Paginator
     *
     * @return Response HTTP response
     */
    #[Route(name: 'notice_index', methods: 'GET')]
    public function index(Request $request, NoticeRepository $noticeRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $noticeRepository->queryAll(),
            $request->query->getInt('page', 1),
            NoticeRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render('notice/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param Notice $notice Notice entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'notice_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET',
    )]
    public function show(Notice $notice): Response
    {
        return $this->render(
            'notice/show.html.twig',
            ['notice' => $notice]
        );
    }
}
