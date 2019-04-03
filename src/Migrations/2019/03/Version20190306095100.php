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
 * Date: 6/03/2019
 * Time: 09:52
 */
declare(strict_types=1);

namespace DoctrineMigrations;

use App\Migrations\SqlLoad;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class Version20190306095100
 * @package DoctrineMigrations
 */
final class Version20190306095100 extends SqlLoad implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on "mysql".');
        $this->addSql('ALTER DATABASE `'.$schema->getName().'` CHARACTER SET utf8 COLLATE utf8_unicode_ci;');

        $this->getSql('Gibbon-v17.sql');
        parent::up($schema);

        $this->getSql('gibbon_demo.sql');
        parent::up($schema);

        $this->getSql('CuttingEdge.sql');
        parent::up($schema);
        $cuttingEdge = $this->getCount();

        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql("UPDATE `gibbonSetting` SET `value` = '".$this->container->getParameter('gibbon_document_root')."' WHERE `scope` = 'System' AND `name` = 'absolutePath'");

        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql("UPDATE `gibbonSetting` SET `value` = '18.0.00' WHERE `scope` = 'System' AND `name` = 'version'");

        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql("UPDATE `gibbonSetting` SET `value` = 'Y' WHERE `scope` = 'System' AND `name` = 'cuttingEdgeCode'");

        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql("UPDATE `gibbonSetting` SET `value` = '".strval($cuttingEdge ?: '0')."' WHERE `scope` = 'System' AND `name` = 'cuttingEdgeCodeLine'");
    }
}