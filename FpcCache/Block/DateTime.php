<?php

namespace Training\FpcCache\Block;

use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\View\Element\Context;

class DateTime extends AbstractBlock
{
    /**
     * @var string
     */
    private $now;

    public function __construct(Context $context, \DateTimeImmutable $now, array $data)
    {
        parent::__construct($context, $data);
        $this->now = $now->format('Y-m-d H:i:s');
    }

    protected function _toHtml()
    {
        return $this->now;
    }
}
