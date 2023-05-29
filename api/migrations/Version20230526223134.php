<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230526223134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evaluation_formation DROP FOREIGN KEY FK_9240EA3B456C5646');
        $this->addSql('ALTER TABLE evaluation_formation DROP FOREIGN KEY FK_9240EA3B5200282E');
        $this->addSql('DROP TABLE evaluation_formation');
        $this->addSql('ALTER TABLE evaluation ADD formation_id INT NOT NULL');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A5755200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('CREATE INDEX IDX_1323A5755200282E ON evaluation (formation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evaluation_formation (evaluation_id INT NOT NULL, formation_id INT NOT NULL, INDEX IDX_9240EA3B5200282E (formation_id), INDEX IDX_9240EA3B456C5646 (evaluation_id), PRIMARY KEY(evaluation_id, formation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE evaluation_formation ADD CONSTRAINT FK_9240EA3B456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluation_formation ADD CONSTRAINT FK_9240EA3B5200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A5755200282E');
        $this->addSql('DROP INDEX IDX_1323A5755200282E ON evaluation');
        $this->addSql('ALTER TABLE evaluation DROP formation_id');
    }
}
