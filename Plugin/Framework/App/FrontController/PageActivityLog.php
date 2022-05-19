<?php

declare(strict_types=1);

namespace Hordieiev\Demo\Plugin\Framework\App\FrontController;

use Magento\Framework\App\FrontController as Subject;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Psr\Log\LoggerInterface;

/**
 * Class PageActivityLog
 */
class PageActivityLog
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var RemoteAddress
     */
    private $remoteAddress;

    /**
     * @param LoggerInterface $logger
     * @param RemoteAddress $remoteAddress
     */
    public function __construct(
        LoggerInterface $logger,
        RemoteAddress $remoteAddress
    ) {
        $this->logger = $logger;
        $this->remoteAddress = $remoteAddress;
    }

    /**
     * @param Subject $subject
     * @param RequestInterface $request
     *
     * @return void
     */
    public function beforeDispatch(
        Subject $subject,
        RequestInterface $request
    ): void {
        $this->logger->debug(
            sprintf(
                '<Page Title>: %s <Page URL> - %s <Client IP>: %s',
                $request->getFrontName(),
                $request->getPathInfo(),
                $this->remoteAddress->getRemoteAddress()
            )
        );
    }
}
