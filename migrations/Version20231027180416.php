<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231027180416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item ADD box_id INT DEFAULT NULL, ADD edition_id INT DEFAULT NULL, ADD objectlink_id INT DEFAULT NULL, ADD oeuvrelink_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251ED8177B3F FOREIGN KEY (box_id) REFERENCES box (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E74281A5E FOREIGN KEY (edition_id) REFERENCES edition (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E1A1745F2 FOREIGN KEY (objectlink_id) REFERENCES objectlink (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E94B2C11C FOREIGN KEY (oeuvrelink_id) REFERENCES oeuvrelink (id)');
        $this->addSql('CREATE INDEX IDX_1F1B251ED8177B3F ON item (box_id)');
        $this->addSql('CREATE INDEX IDX_1F1B251E74281A5E ON item (edition_id)');
        $this->addSql('CREATE INDEX IDX_1F1B251E1A1745F2 ON item (objectlink_id)');
        $this->addSql('CREATE INDEX IDX_1F1B251E94B2C11C ON item (oeuvrelink_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251ED8177B3F');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E74281A5E');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E1A1745F2');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E94B2C11C');
        $this->addSql('DROP INDEX IDX_1F1B251ED8177B3F ON item');
        $this->addSql('DROP INDEX IDX_1F1B251E74281A5E ON item');
        $this->addSql('DROP INDEX IDX_1F1B251E1A1745F2 ON item');
        $this->addSql('DROP INDEX IDX_1F1B251E94B2C11C ON item');
        $this->addSql('ALTER TABLE item DROP box_id, DROP edition_id, DROP objectlink_id, DROP oeuvrelink_id');
    }
}
