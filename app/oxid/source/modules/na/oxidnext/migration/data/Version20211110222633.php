<?php

declare(strict_types=1);

namespace NetAdvising\OxidNext\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211110222633 extends AbstractMigration
{

    public function up(Schema $schema) : void
    {
        $this->addSql("ALTER TABLE `oxcategories` ADD `NA_SF_BANNER` varchar(128) NOT NULL DEFAULT '' COMMENT 'Banner image (multilanguage)'");
        $this->addSql("ALTER TABLE `oxcategories` ADD `NA_SF_BANNER_1` varchar(128) NOT NULL DEFAULT ''");
        $this->addSql("ALTER TABLE `oxcategories` ADD `NA_SF_BANNER_2` varchar(128) NOT NULL DEFAULT ''");
        $this->addSql("ALTER TABLE `oxcategories` ADD `NA_SF_BANNER_3` varchar(128) NOT NULL DEFAULT ''");
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("ALTER TABLE `oxcategories` DROP COLUMN `NA_SF_BANNER`");
        $this->addSql("ALTER TABLE `oxcategories` DROP COLUMN `NA_SF_BANNER_1`");
        $this->addSql("ALTER TABLE `oxcategories` DROP COLUMN `NA_SF_BANNER_2`");
        $this->addSql("ALTER TABLE `oxcategories` DROP COLUMN `NA_SF_BANNER_3`");
    }
}
