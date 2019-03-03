<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon, Flexible & Open School System
 * Copyright (C) 2010, Ross Parker
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program in the LICENCE file.
 * If not, see <http://www.gnu.org/licenses/>.
 *
 * Gibbon-Mobile
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 2/03/2019
 * Time: 10:09
 */

namespace App\Manager;


use App\Util\VersionHelper;

class VersionManager
{

    /**
     * @var SettingManager
     */
    private $settingManager;

    /**
     * @return SettingManager
     */
    public function getSettingManager(): SettingManager
    {
        return $this->settingManager;
    }

    /**
     * @param SettingManager $settingManager
     * @return VersionManager
     */
    public function setSettingManager(SettingManager $settingManager): VersionManager
    {
        $this->settingManager = $settingManager;
        return $this;
    }

    /**
     * checkVersion
     * @return bool
     */
    public function checkVersion(): bool
    {
        $gVersion = $this->getSettingManager()->getSettingByScopeAsString('System', 'version');

        //Check Gibbon Version
        $versionCorrect = false;
        foreach(VersionHelper::GIBBON as $version)
        {
            if (version_compare($gVersion, $version, '='))
            {
                $versionCorrect = true;
                break;
            }
        }
        if (!$versionCorrect) {
            $this->getSettingManager()->getMessageManager()->add('danger', 'version.incompatible', ['%{version}' => VersionHelper::VERSION, '%{gVersion}' => $gVersion],'mobile');
            return false;
        }

        //Is the version using cutting edge.
        $cuttingEdge = $this->getSettingManager()->getSettingByScopeAsBoolean('System', 'cuttingEdgeCode');
        if (VersionHelper::CUTTING_EDGE_CODE || $cuttingEdge !== VersionHelper::CUTTING_EDGE_CODE || true) {
            $cuttingEdgeLine = $this->getSettingManager()->getSettingByScopeAsInteger('System', 'cuttingEdgeCodeLine');
            if ($cuttingEdge !== VersionHelper::CUTTING_EDGE_CODE) {
                if (VersionHelper::CUTTING_EDGE_CODE)
                    $this->getSettingManager()->getMessageManager()->add('danger', 'version.cutting_edge.expected', ['%{version}' => VersionHelper::VERSION, '%{gVersion}' => $gVersion],'mobile');
                else
                    $this->getSettingManager()->getMessageManager()->add('danger', 'version.cutting_edge.not', ['%{version}' => VersionHelper::VERSION, '%{gVersion}' => $gVersion],'mobile');
                return false;
            }
            if (! in_array($cuttingEdgeLine, VersionHelper::CUTTING_EDGE_CODE_LINE)) {
                $this->getSettingManager()->getMessageManager()->add('danger', 'version.cutting_edge.line', ['%{version}' => VersionHelper::VERSION, '%{gVersion}' => $gVersion, '%{line}' => implode(', ', VersionHelper::CUTTING_EDGE_CODE_LINE), '%{gLine}' => $cuttingEdgeLine, '%count%' => count(VersionHelper::CUTTING_EDGE_CODE_LINE)],'mobile');
                return false;
            }
        }

        return true;
    }
}