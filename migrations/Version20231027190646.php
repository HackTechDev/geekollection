<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231027190646 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E1A1745F2');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E94B2C11C');
        $this->addSql('DROP TABLE objectlink');
        $this->addSql('DROP TABLE oeuvrelink');
        $this->addSql('DROP INDEX IDX_1F1B251E94B2C11C ON item');
        $this->addSql('DROP INDEX IDX_1F1B251E1A1745F2 ON item');
        $this->addSql('ALTER TABLE item DROP objectlink_id, DROP oeuvrelink_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE objectlink (id INT AUTO_INCREMENT NOT NULL, link VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE oeuvrelink (id INT AUTO_INCREMENT NOT NULL, link VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE item ADD objectlink_id INT DEFAULT NULL, ADD oeuvrelink_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E1A1745F2 FOREIGN KEY (objectlink_id) REFERENCES objectlink (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E94B2C11C FOREIGN KEY (oeuvrelink_id) REFERENCES oeuvrelink (id)');
        $this->addSql('CREATE INDEX IDX_1F1B251E94B2C11C ON item (oeuvrelink_id)');
        $this->addSql('CREATE INDEX IDX_1F1B251E1A1745F2 ON item (objectlink_id)');
    }
}
