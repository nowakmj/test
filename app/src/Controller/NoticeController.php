<?php
/**
 * Notice controller.
 */

namespace App\Controller;

use App\Entity\Notice;
use App\Service\NoticeService;
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
     * Notice service.
     */
    private NoticeService $noticeService;

    /**
     * Constructor.
     */
    public function __construct(NoticeService $noticeService)
    {
        $this->noticeService = $noticeService;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(name: 'notice_index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $pagination = $this->noticeService->getPaginatedList(
            $request->query->getInt('page', 1)
        );

        return $this->render('notice/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param Notice $notice Notice
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'notice_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    public function show(Notice $notice): Response
    {
        return $this->render('notice/show.html.twig', ['notice' => $notice]);
    }
}
