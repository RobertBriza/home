<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240303160106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE day (id INT AUTO_INCREMENT NOT NULL, day_info_id INT DEFAULT NULL, value DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', UNIQUE INDEX UNIQ_E5A02990A54EB17A (day_info_id), UNIQUE INDEX unique_value (value), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE day_info (id INT AUTO_INCREMENT NOT NULL, day_in_week VARCHAR(255) NOT NULL, day_number VARCHAR(255) NOT NULL, holiday_name VARCHAR(255) DEFAULT NULL, is_holiday TINYINT(1) NOT NULL, month JSON NOT NULL COMMENT \'(DC2Type:json)\', month_number VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, year VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE day ADD CONSTRAINT FK_E5A02990A54EB17A FOREIGN KEY (day_info_id) REFERENCES day_info (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE day DROP FOREIGN KEY FK_E5A02990A54EB17A');
        $this->addSql('DROP TABLE day');
        $this->addSql('DROP TABLE day_info');
    }
}
