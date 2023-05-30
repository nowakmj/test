<?php
/**
 * Notice service.
 */

namespace App\Service;

use App\Entity\Notice;
use App\Repository\NoticeRepository;
use Doctrine\ORM\NonUniqueResultException;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
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
     * Category service.
     */
    private CategoryServiceInterface $categoryService;

    /**
     * Constructor.
     *
     * @param NoticeRepository     $noticeRepository Notice repository
     * @param PaginatorInterface $paginator      Paginator
     * @param CategoryServiceInterface $categoryService Category Service
     */
    public function __construct(NoticeRepository $noticeRepository, PaginatorInterface $paginator, CategoryServiceInterface $categoryService)
    {
        $this->noticeRepository = $noticeRepository;
        $this->paginator = $paginator;
        $this->categoryService = $categoryService;
    }

    /**
     * Get paginated list.
     *
     * @param int                $page    Page number
     * @param array<string, int> $filters Filters array
     *
     * @return PaginationInterface<SlidingPagination> Paginated list
     */
    public function getPaginatedList(int $page,  array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->noticeRepository->queryAll($filters),
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

    /**
     * Prepare filters for the tasks list.
     *
     * @param array<string, int> $filters Raw filters from request
     *
     * @return array<string, object> Result array of filters
     * @throws NonUniqueResultException
     */
    public function prepareFilters(array $filters): array
    {
        $resultFilters = [];
        if (!empty($filters['category_id'])) {
            $category = $this->categoryService->findOneById($filters['category_id']);
            if (null !== $category) {
                $resultFilters['category'] = $category;
            }
        }
        return $resultFilters;
    }
}
