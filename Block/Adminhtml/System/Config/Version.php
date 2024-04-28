<?php declare(strict_types=1);
/**
 * @author     Osiozekhai Aliu
 * @package    BIWAC_AssemblyService
 * @copyright  Copyright (c) 2024 Osiozekhai Aliu (https://github.com/aliuBIWAC)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BIWAC\AssemblyService\Block\Adminhtml\System\Config;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Serialize\Serializer\Json;

class Version extends Field
{
    private Json $json;
    private ComponentRegistrar $componentRegistrar;

    /**
     * @param ComponentRegistrar $componentRegistrar
     * @param Json $json
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        ComponentRegistrar $componentRegistrar,
        Json               $json,
        Context            $context,
        array              $data = []
    ) {
        parent::__construct($context, $data);
        $this->json = $json;
        $this->componentRegistrar = $componentRegistrar;
    }


    protected function _getElementHtml(AbstractElement $element): string
    {
        $element->setData('value', $this->getModuleVersion());

        return parent::_getElementHtml($element);
    }

    private function getModuleVersion(): string
    {
        $composerJsonPath = $this->componentRegistrar->getPath(
            ComponentRegistrar::MODULE,
            $this->getModuleName()
        ) . '/composer.json';

        if (file_exists($composerJsonPath)) {
            $composerJson = $this->json->unserialize(file_get_contents($composerJsonPath));
        }

        return $composerJson['version'] ?? 'Unknown';
    }
}
