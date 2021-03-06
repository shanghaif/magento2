<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Catalog\Block\Adminhtml\Product\Edit\Tab;

class AlertsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magento\Catalog\Block\Adminhtml\Product\Edit\Tab\Alerts
     */
    protected $alerts;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $scopeConfigMock;

    protected function setUp()
    {
        $helper = new \Magento\TestFramework\Helper\ObjectManager($this);
        $this->scopeConfigMock = $this->getMock('Magento\Framework\App\Config\ScopeConfigInterface');

        $this->alerts = $helper->getObject(
            'Magento\Catalog\Block\Adminhtml\Product\Edit\Tab\Alerts',
            ['scopeConfig' => $this->scopeConfigMock]
        );
    }

    /**
     * @param bool $priceAllow
     * @param bool $stockAllow
     * @param bool $canShowTab
     *
     * @dataProvider canShowTabDataProvider
     */
    public function testCanShowTab($priceAllow, $stockAllow, $canShowTab)
    {
        $valueMap = [
            [
                'catalog/productalert/allow_price',
                \Magento\Framework\Store\ScopeInterface::SCOPE_STORE,
                null,
                $priceAllow,
            ],
            [
                'catalog/productalert/allow_stock',
                \Magento\Framework\Store\ScopeInterface::SCOPE_STORE,
                null,
                $stockAllow
            ],
        ];
        $this->scopeConfigMock->expects($this->any())->method('getValue')->will($this->returnValueMap($valueMap));
        $this->assertEquals($canShowTab, $this->alerts->canShowTab());
    }

    public function canShowTabDataProvider()
    {
        return [
            'alert_price_and_stock_allow' => [true, true, true],
            'alert_price_is_allowed_and_stock_is_unallowed' => [true, false, true],
            'alert_price_is_unallowed_and_stock_is_allowed' => [false, true, true],
            'alert_price_is_unallowed_and_stock_is_unallowed' => [false, false, false]
        ];
    }
}
