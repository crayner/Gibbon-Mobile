<?php
/**
 * Created by PhpStorm.
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

        $this->addSql("INSERT INTO `gibbonPerson` (`gibbonPersonID`, `title`, `surname`, `firstName`, `preferredName`, `officialName`, `nameInCharacters`, `gender`, `username`, `password`, `passwordStrong`, `passwordStrongSalt`, `passwordForceReset`, `status`, `canLogin`, `gibbonRoleIDPrimary`, `gibbonRoleIDAll`, `dob`, `email`, `emailAlternate`, `image_240`, `lastIPAddress`, `lastTimestamp`, `lastFailIPAddress`, `lastFailTimestamp`, `failCount`, `address1`, `address1District`, `address1Country`, `address2`, `address2District`, `address2Country`, `phone1Type`, `phone1CountryCode`, `phone1`, `phone3Type`, `phone3CountryCode`, `phone3`, `phone2Type`, `phone2CountryCode`, `phone2`, `phone4Type`, `phone4CountryCode`, `phone4`, `website`, `languageFirst`, `languageSecond`, `languageThird`, `countryOfBirth`, `birthCertificateScan`, `ethnicity`, `citizenship1`, `citizenship1Passport`, `citizenship1PassportScan`, `citizenship2`, `citizenship2Passport`, `religion`, `nationalIDCardNumber`, `nationalIDCardScan`, `residencyStatus`, `visaExpiryDate`, `profession`, `employer`, `jobTitle`, `emergency1Name`, `emergency1Number1`, `emergency1Number2`, `emergency1Relationship`, `emergency2Name`, `emergency2Number1`, `emergency2Number2`, `emergency2Relationship`, `gibbonHouseID`, `studentID`, `dateStart`, `dateEnd`, `gibbonSchoolYearIDClassOf`, `lastSchool`, `nextSchool`, `departureReason`, `transport`, `transportNotes`, `calendarFeedPersonal`, `viewCalendarSchool`, `viewCalendarPersonal`, `viewCalendarSpaceBooking`, `gibbonApplicationFormID`, `lockerNumber`, `vehicleRegistration`, `personalBackground`, `messengerLastBubble`, `privacy`, `dayType`, `gibbonThemeIDPersonal`, `gibboni18nIDPersonal`, `studentAgreements`, `googleAPIRefreshToken`, `receiveNotificationEmails`, `fields`) VALUES
(0000000001, 'Mr.', 'Rayner', 'Craig', 'Craig', 'Craig Rayner', '', 'M', 'craigray', '', '9083eb19471acff1e664790abcdd327f1e1e7d3ef71994331182e7566b095909', 'abCDfFiknprRSwxXYz0346', 'N', 'Full', 'Y', 001, '001', NULL, 'craig@craigrayner.com', NULL, NULL, '10.0.0.138', '2019-04-03 23:16:20', NULL, NULL, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', NULL, '', NULL, NULL, NULL, '', '', '', '', '', '', 'Y', 'Y', 'N', NULL, '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '', 'Y', '');
");

        $this->addSql("UPDATE `gibbonSetting` SET `value` = '".$this->container->getParameter('gibbon_document_root')."' WHERE `scope` = 'System' AND `name` = 'absolutePath'");

        $this->addSql("UPDATE `gibbonSetting` SET `value` = '18.0.00' WHERE `scope` = 'System' AND `name` = 'version'");

        $this->addSql("UPDATE `gibbonSetting` SET `value` = 'Y' WHERE `scope` = 'System' AND `name` = 'cuttingEdgeCode'");

        $this->addSql("UPDATE `gibbonSetting` SET `value` = '".strval($cuttingEdge ?: '0')."' WHERE `scope` = 'System' AND `name` = 'cuttingEdgeCodeLine'");
    }
}