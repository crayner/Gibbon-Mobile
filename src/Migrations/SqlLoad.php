<?php
/**
 * Created by PhpStorm.
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

            if (strpos($line, 'CREATE TABLE') !== false)
            {
                $engine = strpos($line, 'ENGINE=');
                $line = substr($line, 0, $engine) . ' ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;';
                $line = str_replace('CHARACTER SET utf8', 'COLLATE utf8_general_ci', $line);
            }

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
        $this->count = 0;
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