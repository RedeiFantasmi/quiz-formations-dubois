<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230306144900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE copie (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_evaluation_id INT NOT NULL, note DOUBLE PRECISION DEFAULT NULL, annotation VARCHAR(255) DEFAULT NULL, INDEX IDX_A6E330BC79F37AE5 (id_user_id), INDEX IDX_A6E330BCFB448723 (id_evaluation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etat (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation (id INT AUTO_INCREMENT NOT NULL, id_quiz_id INT NOT NULL, id_etat_id INT NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, INDEX IDX_1323A5755BA17805 (id_quiz_id), INDEX IDX_1323A575D3C32F8F (id_etat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation_formation (evaluation_id INT NOT NULL, formation_id INT NOT NULL, INDEX IDX_9240EA3B456C5646 (evaluation_id), INDEX IDX_9240EA3B5200282E (formation_id), PRIMARY KEY(evaluation_id, formation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, id_quiz_id INT NOT NULL, id_type_id INT NOT NULL, note_max DOUBLE PRECISION NOT NULL, enonce VARCHAR(255) NOT NULL, choix1 VARCHAR(255) DEFAULT NULL, choix2 VARCHAR(255) DEFAULT NULL, choix3 VARCHAR(255) DEFAULT NULL, choix4 VARCHAR(255) DEFAULT NULL, INDEX IDX_B6F7494E5BA17805 (id_quiz_id), INDEX IDX_B6F7494E1BD125E3 (id_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz (id INT AUTO_INCREMENT NOT NULL, id_formateur_id INT NOT NULL, titre VARCHAR(255) NOT NULL, INDEX IDX_A412FA92369CFA23 (id_formateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, id_copie_id INT NOT NULL, id_question_id INT NOT NULL, reponse VARCHAR(255) DEFAULT NULL, rep_choix1 TINYINT(1) NOT NULL, rep_choix2 TINYINT(1) NOT NULL, rep_choix3 TINYINT(1) NOT NULL, rep_choix4 TINYINT(1) NOT NULL, note DOUBLE PRECISION DEFAULT NULL, annotation VARCHAR(255) DEFAULT NULL, INDEX IDX_5FB6DEC71C9BAB46 (id_copie_id), INDEX IDX_5FB6DEC76353B48 (id_question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, id_role_id INT NOT NULL, id_formation_id INT DEFAULT NULL, mail VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, INDEX IDX_8D93D64989E8BDC (id_role_id), INDEX IDX_8D93D64971C15D5C (id_formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE copie ADD CONSTRAINT FK_A6E330BC79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE copie ADD CONSTRAINT FK_A6E330BCFB448723 FOREIGN KEY (id_evaluation_id) REFERENCES evaluation (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A5755BA17805 FOREIGN KEY (id_quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575D3C32F8F FOREIGN KEY (id_etat_id) REFERENCES etat (id)');
        $this->addSql('ALTER TABLE evaluation_formation ADD CONSTRAINT FK_9240EA3B456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluation_formation ADD CONSTRAINT FK_9240EA3B5200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E5BA17805 FOREIGN KEY (id_quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E1BD125E3 FOREIGN KEY (id_type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA92369CFA23 FOREIGN KEY (id_formateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC71C9BAB46 FOREIGN KEY (id_copie_id) REFERENCES copie (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC76353B48 FOREIGN KEY (id_question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64989E8BDC FOREIGN KEY (id_role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64971C15D5C FOREIGN KEY (id_formation_id) REFERENCES formation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE copie DROP FOREIGN KEY FK_A6E330BC79F37AE5');
        $this->addSql('ALTER TABLE copie DROP FOREIGN KEY FK_A6E330BCFB448723');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A5755BA17805');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575D3C32F8F');
        $this->addSql('ALTER TABLE evaluation_formation DROP FOREIGN KEY FK_9240EA3B456C5646');
        $this->addSql('ALTER TABLE evaluation_formation DROP FOREIGN KEY FK_9240EA3B5200282E');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E5BA17805');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E1BD125E3');
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA92369CFA23');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC71C9BAB46');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC76353B48');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64989E8BDC');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64971C15D5C');
        $this->addSql('DROP TABLE copie');
        $this->addSql('DROP TABLE etat');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP TABLE evaluation_formation');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user');
    }
}
