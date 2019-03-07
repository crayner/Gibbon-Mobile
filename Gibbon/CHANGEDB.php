<?php

//USE ;end TO SEPARATE SQL STATEMENTS. DON'T USE ;end IN ANY OTHER PLACES!

$sql = [];
$count = 0;

$sql[$count][0] = '18.0.00';
$sql[$count][1] = "
DELETE FROM gibbonAction WHERE gibbonModuleID=(SELECT gibbonModuleID FROM gibbonModule WHERE name='Planner') AND name='Staff Likes';end
DROP TABLE gibbonLike;end
UPDATE gibboni18n SET active='Y' WHERE code='ur_IN';end
UPDATE gibboni18n SET code='ur_PK', name='پاکستان - اُردُو', active='Y' WHERE code='ur_IN';end
ALTER TABLE `gibbonActivityAttendance` CHANGE `gibbonPersonIDTaker` `gibbonPersonIDTaker` INT(10) UNSIGNED ZEROFILL NOT NULL;end
ALTER TABLE `gibbonActivityAttendance` CHANGE `gibbonPersonIDTaker` `gibbonPersonIDTaker` INT(10) UNSIGNED ZEROFILL NOT NULL;end
ALTER TABLE `gibbonApplicationForm` CHANGE `surname` `surname` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '', CHANGE `firstName` `firstName` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '', CHANGE `preferredName` `preferredName` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';end
ALTER TABLE `gibbonApplicationForm` CHANGE `parent1gender` `parent1gender` ENUM('M','F','Other','Unspecified') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Unspecified', CHANGE `parent2gender` `parent2gender` ENUM('M','F','Other','Unspecified') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Unspecified';end
ALTER TABLE `gibbonApplicationForm` CHANGE `parent1surname` `parent1surname` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '', CHANGE `parent1firstName` `parent1firstName` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '', CHANGE `parent1preferredName` `parent1preferredName` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '', CHANGE `parent2surname` `parent2surname` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '', CHANGE `parent2firstName` `parent2firstName` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '', CHANGE `parent2preferredName` `parent2preferredName` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '';end
ALTER TABLE `gibbonCountry` ADD PRIMARY KEY(`printable_name`);end
ALTER TABLE `gibbonFinanceBudgetCycleAllocation` CHANGE `gibbonFinanceBudgetID` `gibbonFinanceBudgetID` INT(4) UNSIGNED ZEROFILL NOT NULL;end
ALTER TABLE `gibbonFirstAid` CHANGE `gibbonCourseClassID` `gibbonCourseClassID` INT(8) UNSIGNED ZEROFILL NULL DEFAULT NULL;end
ALTER TABLE `gibbonMarkbookTarget` CHANGE `gibbonScaleGradeID` `gibbonScaleGradeID` INT(7) UNSIGNED ZEROFILL NULL DEFAULT NULL;end
ALTER TABLE `gibbonMessengerCannedResponse` CHANGE `gibbonPersonIDCreator` `gibbonPersonIDCreator` INT(10) UNSIGNED ZEROFILL NOT NULL;end
ALTER TABLE `gibbonOutcome` CHANGE `gibbonPersonIDCreator` `gibbonPersonIDCreator` INT(10) UNSIGNED ZEROFILL NOT NULL;end
ALTER TABLE `gibbonPersonMedicalSymptoms` CHANGE `gibbonPersonID` `gibbonPersonID` INT(10) UNSIGNED ZEROFILL NOT NULL, CHANGE `gibbonPersonIDTaker` `gibbonPersonIDTaker` INT(10) UNSIGNED ZEROFILL NOT NULL;end
ALTER TABLE `gibbonPersonUpdate` CHANGE `emergency1Name` `emergency1Name` VARCHAR(90) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `emergency2Name` `emergency2Name` VARCHAR(90) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `surname` `surname` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '', CHANGE `firstName` `firstName` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '', CHANGE `preferredName` `preferredName` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '', CHANGE `nameInCharacters` `nameInCharacters` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `profession` `profession` VARCHAR(90) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `employer` `employer` VARCHAR(90) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `jobTitle` `jobTitle` VARCHAR(90) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;end
ALTER TABLE `gibbonPlannerEntryStudentHomework` CHANGE `gibbonPersonID` `gibbonPersonID` INT(10) UNSIGNED ZEROFILL NOT NULL;end
ALTER TABLE `gibbonRubric` CHANGE `gibbonPersonIDCreator` `gibbonPersonIDCreator` INT(10) UNSIGNED ZEROFILL NOT NULL;end
ALTER TABLE `gibbonRubricEntry` CHANGE `gibbonRubricID` `gibbonRubricID` INT(8) UNSIGNED ZEROFILL NOT NULL;end
ALTER TABLE `gibbonStaffApplicationForm` CHANGE `surname` `surname` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `firstName` `firstName` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `preferredName` `preferredName` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `nameInCharacters` `nameInCharacters` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;end
ALTER TABLE `gibbonTTDayRowClass` CHANGE `gibbonSpaceID` `gibbonSpaceID` INT(10) UNSIGNED ZEROFILL NULL DEFAULT NULL;end
ALTER TABLE `gibbonTTSpaceChange` CHANGE `gibbonSpaceID` `gibbonSpaceID` INT(10) UNSIGNED ZEROFILL NULL DEFAULT NULL;end
ALTER TABLE `gibbonTTSpaceChange` CHANGE `gibbonPersonID` `gibbonPersonID` INT(10) UNSIGNED ZEROFILL NOT NULL;end
SELECT foreignKey FROM `gibbonTTSpaceBooking` LIMIT 0, 1;end
UPDATE gibboni18n SET active='Y' WHERE code='hr_HR';end
ALTER TABLE gibbonUnit DROP COLUMN embeddable;end
ALTER TABLE gibbonUnitBlock DROP COLUMN gibbonOutcomeIDList;end
ALTER TABLE gibbonUnitClassBlock DROP COLUMN gibbonOutcomeIDList;end
ALTER TABLE `gibbonTTSpaceBooking` CHANGE `foreignKey` `foreignKey` ENUM('gibbonSpaceID','gibbonLibraryItemID') NOT NULL DEFAULT 'gibbonSpaceID';end
UPDATE gibbonTTSpaceBooking SET foreignKey='gibbonSpaceID' WHERE foreignKey='';end
INSERT INTO `gibbonSetting` (`scope` ,`name` ,`nameDisplay` ,`description` ,`value`)VALUES ('System', 'mailerSMTPSecure', 'SMTP Encryption', 'Automatically sets the encryption based on the port, otherwise select one manually.', 'auto');end
";
