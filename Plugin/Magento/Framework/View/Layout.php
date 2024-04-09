<?php

/**
 * Created by Steven.
 */

declare(strict_types=1);

namespace EBoost\LayoutUpdate\Plugin\Magento\Framework\View;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template;

class Layout
{
    const CONFIG_PATH_DUMP_FRONTEND = 'dev/debug/layout_debugger_dump_enabled_frontend';
    protected $pageConfig;
    protected $config;

    public function __construct(
        \Magento\Framework\View\Page\Config $pageConfig,
        ScopeConfigInterface $config
    ) {
        $this->pageConfig = $pageConfig;
        $this->config = $config;
    }


    public function beforeGetOutput(
        \Magento\Framework\View\LayoutInterface $subject
    ) {
        if (! $this->config->isSetFlag(self::CONFIG_PATH_DUMP_FRONTEND)) {
            return;
        }

        // $subject->publicBuild();

        $subject->addBlock(Template::class, 'layout_debugger', 'after.body.start');
        /** @var Template $block */
        $block = $subject->getBlock('layout_debugger');
        $block->setTemplate('EBoost_LayoutUpdate::debug.phtml');

        $document = new \DOMDocument();
        $document->formatOutput = true;
        $node = $document->createElement('outputElements');
        $document->appendChild($node);


        $outputProperty = new \ReflectionProperty($subject, '_output');
        $outputProperty->setAccessible(true);
        $output = $outputProperty->getValue($subject);

        $structureProperty = new \ReflectionProperty($subject, 'structure');
        $structureProperty->setAccessible(true);
        $structure = $structureProperty->getValue($subject);

        foreach ($output as $output) {
            $child = $this->renderDebugXmlChild($output, $output, $document, $subject, $structure);
            $node->appendChild($child);
        }

        $block->setData('pageLayout', $this->pageConfig->getPageLayout());
        $block->setData('handles', $subject->getUpdate()->getHandles());
        $block->setData('serializedLayout', $document->saveHTML());
    }

    /**
     * Render Debug Xml
     *
     * @param [string] $name
     * @param [string] $alias
     * @param \DOMDocument $document
     * @param \Magento\Framework\View\Layout $layout
     * @param \Magento\Framework\View\Layout\Data\Structure $structure
     * @return \DOMElement
     */
    protected function renderDebugXmlChild($name, $alias, $document, $layout, $structure)
    {
        $element = $structure->getElement($name);
        $children = $structure->getChildren($name);
        $node = $document->createElement($element['type']);
        $node->setAttribute('name', $name);

        if ($alias && $name !== $alias) {
            $node->setAttribute('as', $alias);
        }

        if (!empty($element['display'])) {
            $node->setAttribute('display', $element['display']);
        }

        if ($element['type'] === 'block') {
            $block = $layout->getBlock($name);
            $node->setAttribute('class', get_class($block));

            if ($block instanceof Template
                && $block->getTemplate()
            ) {
                $node->setAttribute('template', $block->getTemplate());
            }
        }

        foreach ($children as $childName => $alias) {
            $child = $this->renderDebugXmlChild($childName, $alias, $document, $layout, $structure);
            $node->appendChild($child);
        }

        return $node;
    }
}
