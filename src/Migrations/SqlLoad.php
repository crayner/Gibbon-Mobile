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
    public function up(Schema $schema) : void
    {
        foreach($this->sql as $line) {
            $this->addSql($line);
        }
    }

    public function down(Schema $schema) : void
    {}

    /**
     * @var array|null
     */
    private $sql = [];

    /**
     * @return array|null
     */
    public function getSql(string $source): ?array
    {
        $sql = [];
        if (file_exists(__DIR__. '/'. $source))
            $sql = file(__DIR__. '/'. $source);
        $x = 0;
        foreach($sql as $line)
        {
            if (empty($line))
                continue;
            if (mb_strpos($line, '--') === 0)
                continue;
            $this->sql[$x] = (!empty($this->sql[$x]) ? $this->sql[$x] : '') . $line;
            if (mb_strpos($line, ';', -1) !== false)
                $x++;
        }
        return $this->sql;
    }
}