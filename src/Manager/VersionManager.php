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
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 2/03/2019
 * Time: 10:09
 */
namespace App\Manager;

use App\Util\VersionHelper;
use Symfony\Component\Yaml\Yaml;

/**
 * Class VersionManager
 * @package App\Manager
 */
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
     * @var string|null
     */
    private $gibbonVersion;

    /**
     * @var string
     */
    private $gibbonVersionStatus = 'Not Checked';

    /**
     * @return string
     */
    public function getGibbonVersionStatus(): string
    {
        return $this->gibbonVersionStatus;
    }

    /**
     * @param string $gibbonVersionStatus
     * @return VersionManager
     */
    public function setGibbonVersionStatus(string $gibbonVersionStatus): VersionManager
    {
        $this->gibbonVersionStatus = $gibbonVersionStatus;
        return $this;
    }

    /**
     * checkVersion
     * @return bool
     */
    public function checkVersion(): bool
    {
        $this->gibbonVersion = $this->getSettingManager()->getSettingByScopeAsString('System', 'version');

        //Check Gibbon Version
        $versionCorrect = false;
        foreach(VersionHelper::GIBBON as $version)
        {
            if (version_compare($this->gibbonVersion, $version, '='))
            {
                $versionCorrect = true;
                break;
            }
        }
        if (!$versionCorrect) {
            $this->getSettingManager()->getMessageManager()->add('danger', 'version.incompatible', ['%{version}' => VersionHelper::VERSION, '%{gVersion}' => $this->gibbonVersion],'mobile');
            $this->setGibbonVersionStatus(sprinf('The Mobile software (Version %s) installed is not compatible with the installed version (%s) of Gibbon.', VersionHelper::VERSION, $this->gibbonVersion));
            return false;
        }

        //Is the version using cutting edge.
        $cuttingEdge = $this->getSettingManager()->getSettingByScopeAsBoolean('System', 'cuttingEdgeCode');
        if (VersionHelper::CUTTING_EDGE_CODE || $cuttingEdge !== VersionHelper::CUTTING_EDGE_CODE || true) {
            $cuttingEdgeLine = $this->countCuttingEdgeLines();
            if ($cuttingEdge !== VersionHelper::CUTTING_EDGE_CODE) {
                if (VersionHelper::CUTTING_EDGE_CODE)
                    $this->getSettingManager()->getMessageManager()->add('danger', 'version.cutting_edge.expected', ['%{version}' => VersionHelper::VERSION, '%{gVersion}' => $this->gibbonVersion],'mobile');
                else
                    $this->getSettingManager()->getMessageManager()->add('danger', 'version.cutting_edge.not', ['%{version}' => VersionHelper::VERSION, '%{gVersion}' => $this->gibbonVersion],'mobile');
                $this->setGibbonVersionStatus('Cutting Edge Setting not correct.');
                return false;
            }
            if (! in_array($cuttingEdgeLine, VersionHelper::CUTTING_EDGE_CODE_LINE)) {
                $this->getSettingManager()->getMessageManager()->add('danger', 'version.cutting_edge.line', ['%{version}' => VersionHelper::VERSION, '%{gVersion}' => $this->gibbonVersion, '%{line}' => implode(', ', VersionHelper::CUTTING_EDGE_CODE_LINE), '%{gLine}' => $cuttingEdgeLine, '%count%' => count(VersionHelper::CUTTING_EDGE_CODE_LINE)],'mobile');
                //$this->setGibbonVersionStatus(sprintf('Cutting Edge Line is not correct for Version %s. Available %s, Must be one of: %s in file %s', $this->gibbonVersion, $cuttingEdgeLine, implode(', ', VersionHelper::CUTTING_EDGE_CODE_LINE), $this->getSettingManager()->getParameter('gibbon_document_root') . '/CHANGEDB.php'));
                return false;
            }
        }
        $this->setGibbonVersionStatus('No problem found');
        return true;
    }

    /**
     * getGibbonVersion
     * @return string|null
     */
    public function getGibbonVersion(): ?string
    {
        return $this->gibbonVersion;
    }

    /**
     * setGibbonVersion
     * @param string|null $gibbonVersion
     * @return VersionManager
     */
    public function setGibbonVersion(?string $gibbonVersion): VersionManager
    {
        $this->gibbonVersion = $gibbonVersion;
        return $this;
    }

    /**
     * @var array|null
     */
    private $versionData;

    /**
     * countCuttingEdgeLines
     * @return int
     */
    private function countCuttingEdgeLines(): int
    {
        $sql = [];
        require $this->getSettingManager()->getParameter('gibbon_document_root') . '/CHANGEDB.php';

        foreach($sql as $item) {
            if ($item[0] === $this->gibbonVersion) {
                $updates = $item[1];
                break;
            }
        }

        $x = mb_substr_count($updates, ';end');

        return intval($x);
    }

    /**
     * loadVersionInformation
     * @throws \Exception
     */
    public function loadVersionInformation()
    {
        $fileName = 'http://gibhelp.craigrayner.com/Download/version.yaml/';
        $this->setGibbonVersion($this->getSettingManager()->getSettingByScopeAsString('System', 'version'));

        try {
            $contents = file_get_contents($fileName);
        } catch (\Exception $e) {
            $this->getSettingManager()->getMessageManager()->add('danger', 'Gibbon Responsive was not able to get details of the version available.', [], 'mobile');
        }

        $this->versionData = Yaml::parse($contents);
        $this->getGibbonDetails();

        $possible = $this->matchVersion($this->versionData[$this->getGibbonVersion()]);
        if (empty($possible))
            $this->getSettingManager()->getMessageManager()->add('danger', 'Gibbon Responsive does not have a valid version to run for Gibbon Version "%{version}"', ['%{version}' => $this->gibbonDetails['version']], 'mobile');
        else
            $this->getSettingManager()->getMessageManager()->add('danger', 'Gibbon Responsive needs to be upgraded to version "%{version}"', ['%{version}' => $possible], 'mobile');

        return $this;
    }

    /**
     * @var array
     */
    private $gibbonDetails;

    /**
     * getGibbonDetails
     * @return array
     * @throws \Exception
     */
    public function getGibbonDetails(): array
    {
        if (! empty($this->gibbonDetails))
            return $this->gibbonDetails;
        $this->gibbonDetails = [];
        $this->gibbonDetails['version'] = $this->getGibbonVersion();
        $this->gibbonDetails['cuttingEdge'] = $this->getSettingManager()->getSettingByScopeAsBoolean('System', 'cuttingEdgeCode');


        if ($this->gibbonDetails['cuttingEdge']) {
            $this->gibbonDetails['cuttingEdgeLine'] = $this->getSettingManager()->getSettingByScopeAsInteger('System', 'cuttingEdgeCodeLine');
            $this->gibbonDetails['cuttingEdgeLineFound'] = $this->countCuttingEdgeLines();
            if ($this->gibbonDetails['cuttingEdgeLineFound'] === $this->gibbonDetails['cuttingEdgeLine'])
                $this->getSettingManager()->getMessageManager()->add('warning', 'Gibbon is running cutting edge code, but has updates that have not been applied.  The administrator needs to update the system fully.', [], 'mobile');
        }

        return $this->gibbonDetails;
    }

    private function matchVersion($versions)
    {
        $possible = '';
        foreach(($versions ?: []) as $version=>$details)
        {
            if ($this->gibbonDetails['cuttingEdge'] === $details['cutting_edge'] && $this->gibbonDetails['cuttingEdge'])
            {
                if (in_array($this->gibbonDetails['cuttingEdgeLineFound'], $details['cutting_edge_line'])) {
                    $possible = $version;
                    break ;
                }
            }
        }
        return $possible;
    }
}