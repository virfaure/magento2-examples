<?php

namespace Training\LogFrontendPostRequest\Plugin\Request;

use Magento\Framework\App\RequestInterface;

class AroundDispatchPlugin
{
    /**
     * Logging instance
     * @var \Training\LogFrontendPostRequest\Logger\Logger
     */
    protected $logger;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    private $date;

    /**
     * @param \Training\LogFrontendPostRequest\Logger\Logger $logger
     */
    public function __construct(
        \Training\LogFrontendPostRequest\Logger\Logger $logger,
        \Magento\Framework\Stdlib\DateTime\DateTime $date
    ) {
        $this->logger = $logger;
        $this->date = $date;
    }

    /**
     * @param RequestInterface $request
     * @param \Closure $proceed
     * @return mixed
     */
    public function aroundDispatch(
        \Magento\Framework\App\ActionInterface $subject,
        \Closure $proceed,
        RequestInterface $request
    ) {
        $startTime = $this->date->gmtTimestamp();

        $returnValue = $proceed($request);
        $this->logTimeIfPostRequest($request, $startTime);

        return $returnValue;
    }

    /**
     * @param RequestInterface $request
     * @param int $startTime
     */
    private function logTimeIfPostRequest(RequestInterface $request, $startTime)
    {
        if ($request->isPost()) {
            $endTime = $this->date->gmtTimestamp();
            $date = $this->date->gmtDate('d-m-y');
            $time = $this->date->gmtDate('H:i:s');
            $processedTime = $this->date->gmtDate('s', ($startTime-$endTime));

            $this->logger->info('------------------------------------------');
            $this->logger->info(__('Date: %1', $date));
            $this->logger->info(__('Time: %1', $time));
            $this->logger->info(__('Url: %1', $request->getPathInfo()));
            $this->logger->info(__('Processing Time : %1s', $processedTime));
        }
    }
}
