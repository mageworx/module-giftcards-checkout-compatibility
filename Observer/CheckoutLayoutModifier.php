<?php
/**
 * Copyright © MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\GiftCardsCheckout\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class CheckoutLayoutModifier
 */
class CheckoutLayoutModifier implements ObserverInterface
{
    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        /** @var \MageWorx\Checkout\Api\LayoutModiferAccess $subject */
        $subject = $observer->getSubject();
        /** @var array $jsLayout */
        $jsLayout = &$subject->getJsLayout();

        $nameInLayout = 'mageworxGiftcards';
        // Copy element
        $originalElement = $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
        ['payment']['children']['afterMethods']['children'][$nameInLayout];

        // Remove original element from layout
        unset(
            $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
            ['payment']['children']['afterMethods']['children'][$nameInLayout]
        );

        $originalElement['config']['template'] = 'MageWorx_GiftCardsCheckout/summary/additional-inputs/mageworx-gift-cards-form';

        // @TODO: Update child components here

        $jsLayout['components']['checkout']['children']['sidebar']['children']['additionalInputs']['children'][$nameInLayout] =
            $originalElement;

        $jsLayout['components']['checkout']['children']['sidebar']['children']['summary']['children']['totals']
        ['children']['mageworx_giftcards']['config']['template'] = 'MageWorx_GiftCardsCheckout/summary/totals/mageworx-gift-cards';
    }
}
