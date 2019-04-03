<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 8/01/2019
 * Time: 10:57
 */
namespace App\Provider;

use App\Entity\AttendanceCode;
use App\Manager\Traits\EntityTrait;

/**
 * Class AttendanceCodeProvider
 * @package App\Provider
 */
class AttendanceCodeProvider
{
    use EntityTrait;

    /**
     * @var string
     */
    private $entityName = AttendanceCode::class;

    /**
     * findActive
     * @return array
     * @throws \Exception
     */
    public function findActive(bool $asArray = false): array
    {
        return $this->getRepository()->findActive($asArray);
    }

    /**
     * @var array|null
     */
    private $selectArray;

    /**
     * createSelectArray
     * @return array
     * @throws \Exception
     */
    public function createSelectArray(): array
    {
        if (! empty($this->selectArray)) {
            $this->selectArray = [];
            foreach ($this->findActive() as $item) {
                $this->selectArray[$item->getId()] = $item->getName();
            }
        }
        return $this->selectArray;
    }
}