<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 11/12/2018
 * Time: 13:18
 */
namespace App\Provider;

use App\Entity\I18n;
use App\Manager\Traits\EntityTrait;
use Doctrine\ORM\NoResultException;

/**
 * Class I18nProvider
 * @package App\Provider
 */
class I18nProvider
{
    use EntityTrait;

    /**
     * @var string
     */
    private $entityName = I18n::class;

    /**
     * getDateFormat
     * @param string $locale
     * @return string
     */
    public function getDateFormatPHP(string $locale = 'en_GB'): string
    {
        try {
            $result = $this->getRepository()->createQueryBuilder('i')
                ->select('i.dateFormatPHP')
                ->where('i.code = :locale')
                ->setParameter('locale', $locale)
                ->getQuery()
                ->getSingleScalarResult();
        } catch( NoResultException $e) {
            $result = 'd/m/Y';
        }

        return $result;
    }
}