<?php

declare(strict_types=1);

namespace Hordieiev\Demo\Api\Service\FrontendArea\Account;

/**
 * Interface OrderHistoryCountInterface
 *
 * @api
 */
interface OrderHistoryCountInterface
{
    /**
     * @return string
     */
    public function execute(): string;
}
