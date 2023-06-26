<?php
/**
 * Notice service interface.
 */

namespace App\Service;

use App\Entity\Notice;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface NoticeServiceInterface.
 */
interface NoticeServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface;

    /**
     * Save entity.
     *
     * @param Notice $notice Notice entity
     */
    public function save(Notice $notice): void;

    /**
     * Delete entity.
     *
     * @param Notice $notice Notice entity
     */
    public function delete(Notice $notice): void;

    /**
     * Prepare filters.
     *
     * @param array $filters Filters
     */
    public function prepareFilters(array $filters): array;

    /**
     * Activate notice.
     *
     * @param Notice $notice Notice entity
     */
    public function activate(Notice $notice): void;

    /**
     * Deactivate notice.
     *
     * @param Notice $notice Notice entity
     */
    public function deactivate(Notice $notice): void;
}
