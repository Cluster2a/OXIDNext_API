<?php

/**
 * This Software is the property of ITSOUP and is protected by copyright law - it is NOT Freeware.
 * Any unauthorized use of this software without a valid license is a violation of the license agreement and will be
 * prosecuted by civil and criminal law.
 *
 * @copyright      (C) ITSOUP Alexander Hirschfeld
 * @since              Version 1.0
 * @author             Alexander Hirschfeld <info@itsoup.de>
 * @link               https://www.itsoup.de
 */

declare(strict_types=1);

namespace ITSOUP\VariantExtension\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211110222634 extends AbstractMigration
{

    public function up(Schema $schema): void
    {
        $this->addSql("ALTER TABLE `oxarticles` ADD `NA_VARIANTEXTENSION` text NULL COMMENT 'Variant extension'");
        $this->addSql("ALTER TABLE `oxarticles` ADD `NA_VARIANTEXTENSION_1` text NULL");
        $this->addSql("ALTER TABLE `oxarticles` ADD `NA_VARIANTEXTENSION_2` text NULL");
        $this->addSql("ALTER TABLE `oxarticles` ADD `NA_VARIANTEXTENSION_3` text NULL");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("ALTER TABLE `oxarticles` DROP COLUMN `NA_VARIANTEXTENSION`");
        $this->addSql("ALTER TABLE `oxarticles` DROP COLUMN `NA_VARIANTEXTENSION_1`");
        $this->addSql("ALTER TABLE `oxarticles` DROP COLUMN `NA_VARIANTEXTENSION_2`");
        $this->addSql("ALTER TABLE `oxarticles` DROP COLUMN `NA_VARIANTEXTENSION_3`");
    }
}
