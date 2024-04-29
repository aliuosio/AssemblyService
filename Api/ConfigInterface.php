<?php declare(strict_types=1);
/**
 * @author     Osiozekhai Aliu
 * @package    BIWAC_AssemblyService
 * @copyright  Copyright (c) 2024 BIWAC
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BIWAC\AssemblyService\Api;


interface ConfigInterface
{

    public function isEnabled(): string;

    public function getGroupKey(): string;

    public function getSKU(): string;

    public function getAssemblyServicePrice(): string;

}
