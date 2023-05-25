<?php
/**
 * Notice service.
 */

namespace App\Service;

use App\Entity\Notice;
use App\Repository\NoticeRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class NoticeService.
 */
class NoticeService implements NoticeServiceInterface
{
    /**
     * Notice repository.
     */
    private NoticeRepository $noticeRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param NoticeRepository     $noticeRepository Notice repository
     * @param PaginatorInterface $paginator      Paginator
     */
    public function __construct(NoticeRepository $noticeRepository, PaginatorInterface $paginator)
    {
        $this->noticeRepository = $noticeRepository;
        $this->paginator = $paginator;
    }

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->noticeRepository->queryAll(),
            $page,
            NoticeRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Notice $notice Notice entity
     */
    public function save(Notice $notice): void
    {
        if ($notice->getId() == null) {
            $notice->setCreatedAt(new \DateTimeImmutable());
        }
        $notice->setUpdatedAt(new \DateTimeImmutable());
        $this->noticeRepository->save($notice);
    }

    /**
     * Delete entity.
     *
     * @param Notice $notice Notice entity
     */
    public function delete(Notice $notice): void
    {
        $this->noticeRepository->delete($notice);
    }
}
