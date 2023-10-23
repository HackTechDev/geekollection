<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231023170843 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE library_item DROP FOREIGN KEY FK_B9D4EF73126F525E');
        $this->addSql('ALTER TABLE library_item DROP FOREIGN KEY FK_B9D4EF73FE2541D7');
        $this->addSql('ALTER TABLE library_user DROP FOREIGN KEY FK_2B5C1C24FE2541D7');
        $this->addSql('ALTER TABLE library_user DROP FOREIGN KEY FK_2B5C1C24A76ED395');
        $this->addSql('DROP TABLE library');
        $this->addSql('DROP TABLE library_item');
        $this->addSql('DROP TABLE library_user');
        $this->addSql('ALTER TABLE user ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE library (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE library_item (library_id INT NOT NULL, item_id INT NOT NULL, INDEX IDX_B9D4EF73FE2541D7 (library_id), INDEX IDX_B9D4EF73126F525E (item_id), PRIMARY KEY(library_id, item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE library_user (library_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_2B5C1C24A76ED395 (user_id), INDEX IDX_2B5C1C24FE2541D7 (library_id), PRIMARY KEY(library_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE library_item ADD CONSTRAINT FK_B9D4EF73126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE library_item ADD CONSTRAINT FK_B9D4EF73FE2541D7 FOREIGN KEY (library_id) REFERENCES library (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE library_user ADD CONSTRAINT FK_2B5C1C24FE2541D7 FOREIGN KEY (library_id) REFERENCES library (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE library_user ADD CONSTRAINT FK_2B5C1C24A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user DROP created_at, DROP updated_at');
    }
}
