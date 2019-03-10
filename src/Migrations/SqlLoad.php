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
 * Date: 6/03/2019
 * Time: 09:56
 */
declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class SqlLoad
 * @package DoctrineMigrations
 */
class SqlLoad extends AbstractMigration
{
    /**
     * @var file pointer resource|null
     */
    private $handle;

    /**
     * @var integer
     */
    private $count;

    /**
     * up
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     */
    public function up(Schema $schema) : void
    {
        while(($line = $this->getSqlLine()) !== false) {
            $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
            $this->addSql($line);
        }
    }

    public function down(Schema $schema) : void
    {}

    /**
     * getSql
     * @param string $source
     */
    public function getSql(string $source): void
    {
        if (file_exists(__DIR__. '/'. $source))
            $this->handle = fopen(__DIR__. '/'. $source, "r");
        $this->count =0;
    }

    /**
     * getSqlLine
     * @return bool|string
     * @throws \Exception
     */
    private function getSqlLine()
    {
        if ($this->handle) {
            $sql = '';
            while (($line = fgets($this->handle)) !== false) {
                $line = trim($line, "\n\r");
                if (empty($line))
                    continue;
                if (mb_strpos($line, '--') === 0)
                    continue;
                if (mb_strpos($line, '#') === 0)
                    continue;
                $sql .= $line;
                try {
                    if (mb_strpos($line, ';', -1) !== false) {
                        $this->count++;
                        return $sql;
                    }
                } catch (\Exception $e) {
                    echo $line."\r\n";
                    echo strlen($line)."\r\n";
                    throw $e;
                }
            }
            fclose($this->handle);
            return false;
        }
        return false;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }
}