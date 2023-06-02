<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230602090515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575D5E86FF');
        $this->addSql('DROP TABLE etat');
        $this->addSql('ALTER TABLE copie ADD est_cloture TINYINT(1) NOT NULL');
        $this->addSql('DROP INDEX IDX_1323A575D5E86FF ON evaluation');
        $this->addSql('ALTER TABLE evaluation ADD est_cloture TINYINT(1) NOT NULL, DROP etat_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etat (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE evaluation ADD etat_id INT NOT NULL, DROP est_cloture');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575D5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_1323A575D5E86FF ON evaluation (etat_id)');
        $this->addSql('ALTER TABLE copie DROP est_cloture');
    }
}
