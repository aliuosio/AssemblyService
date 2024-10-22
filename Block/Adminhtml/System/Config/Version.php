<?php declare(strict_types=1);
/**
 * @author     Osiozekhai Aliu
 * @package    Osio_AssemblyService
 * @copyright  Copyright (c) 2024 Osio
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Osio\AssemblyService\Block\Adminhtml\System\Config;


use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Serialize\Serializer\Json;

class Version extends Field
{

    /**
     * @param ComponentRegistrar $componentRegistrar
     * @param Json $json
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        readonly private ComponentRegistrar $componentRegistrar,
        readonly private Json               $json,
        readonly private Context            $context,
        array              $data = []
    ) {
        parent::__construct($context, $data);
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
