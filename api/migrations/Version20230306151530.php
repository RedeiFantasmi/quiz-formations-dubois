<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230306151530 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE copie DROP FOREIGN KEY FK_A6E330BC79F37AE5');
        $this->addSql('ALTER TABLE copie DROP FOREIGN KEY FK_A6E330BCFB448723');
        $this->addSql('DROP INDEX IDX_A6E330BCFB448723 ON copie');
        $this->addSql('DROP INDEX IDX_A6E330BC79F37AE5 ON copie');
        $this->addSql('ALTER TABLE copie ADD user_id INT NOT NULL, ADD evaluation_id INT NOT NULL, DROP id_user_id, DROP id_evaluation_id');
        $this->addSql('ALTER TABLE copie ADD CONSTRAINT FK_A6E330BCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE copie ADD CONSTRAINT FK_A6E330BC456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id)');
        $this->addSql('CREATE INDEX IDX_A6E330BCA76ED395 ON copie (user_id)');
        $this->addSql('CREATE INDEX IDX_A6E330BC456C5646 ON copie (evaluation_id)');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A5755BA17805');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575D3C32F8F');
        $this->addSql('DROP INDEX IDX_1323A575D3C32F8F ON evaluation');
        $this->addSql('DROP INDEX IDX_1323A5755BA17805 ON evaluation');
        $this->addSql('ALTER TABLE evaluation ADD quiz_id INT NOT NULL, ADD etat_id INT NOT NULL, DROP id_quiz_id, DROP id_etat_id');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575D5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
        $this->addSql('CREATE INDEX IDX_1323A575853CD175 ON evaluation (quiz_id)');
        $this->addSql('CREATE INDEX IDX_1323A575D5E86FF ON evaluation (etat_id)');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E1BD125E3');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E5BA17805');
        $this->addSql('DROP INDEX IDX_B6F7494E1BD125E3 ON question');
        $this->addSql('DROP INDEX IDX_B6F7494E5BA17805 ON question');
        $this->addSql('ALTER TABLE question ADD quiz_id INT NOT NULL, ADD type_id INT NOT NULL, DROP id_quiz_id, DROP id_type_id');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494E853CD175 ON question (quiz_id)');
        $this->addSql('CREATE INDEX IDX_B6F7494EC54C8C93 ON question (type_id)');
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA92369CFA23');
        $this->addSql('DROP INDEX IDX_A412FA92369CFA23 ON quiz');
        $this->addSql('ALTER TABLE quiz CHANGE id_formateur_id formateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA92155D8F51 FOREIGN KEY (formateur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_A412FA92155D8F51 ON quiz (formateur_id)');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC71C9BAB46');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC76353B48');
        $this->addSql('DROP INDEX IDX_5FB6DEC76353B48 ON reponse');
        $this->addSql('DROP INDEX IDX_5FB6DEC71C9BAB46 ON reponse');
        $this->addSql('ALTER TABLE reponse ADD copie_id INT NOT NULL, ADD question_id INT NOT NULL, DROP id_copie_id, DROP id_question_id');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC74C4047D3 FOREIGN KEY (copie_id) REFERENCES copie (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC71E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('CREATE INDEX IDX_5FB6DEC74C4047D3 ON reponse (copie_id)');
        $this->addSql('CREATE INDEX IDX_5FB6DEC71E27F6BF ON reponse (question_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64971C15D5C');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64989E8BDC');
        $this->addSql('DROP INDEX IDX_8D93D64971C15D5C ON user');
        $this->addSql('DROP INDEX IDX_8D93D64989E8BDC ON user');
        $this->addSql('ALTER TABLE user CHANGE id_role_id role_id INT NOT NULL, CHANGE id_formation_id formation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D60322AC ON user (role_id)');
        $this->addSql('CREATE INDEX IDX_8D93D6495200282E ON user (formation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E853CD175');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EC54C8C93');
        $this->addSql('DROP INDEX IDX_B6F7494E853CD175 ON question');
        $this->addSql('DROP INDEX IDX_B6F7494EC54C8C93 ON question');
        $this->addSql('ALTER TABLE question ADD id_quiz_id INT NOT NULL, ADD id_type_id INT NOT NULL, DROP quiz_id, DROP type_id');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E1BD125E3 FOREIGN KEY (id_type_id) REFERENCES type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E5BA17805 FOREIGN KEY (id_quiz_id) REFERENCES quiz (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B6F7494E1BD125E3 ON question (id_type_id)');
        $this->addSql('CREATE INDEX IDX_B6F7494E5BA17805 ON question (id_quiz_id)');
        $this->addSql('ALTER TABLE copie DROP FOREIGN KEY FK_A6E330BCA76ED395');
        $this->addSql('ALTER TABLE copie DROP FOREIGN KEY FK_A6E330BC456C5646');
        $this->addSql('DROP INDEX IDX_A6E330BCA76ED395 ON copie');
        $this->addSql('DROP INDEX IDX_A6E330BC456C5646 ON copie');
        $this->addSql('ALTER TABLE copie ADD id_user_id INT NOT NULL, ADD id_evaluation_id INT NOT NULL, DROP user_id, DROP evaluation_id');
        $this->addSql('ALTER TABLE copie ADD CONSTRAINT FK_A6E330BC79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE copie ADD CONSTRAINT FK_A6E330BCFB448723 FOREIGN KEY (id_evaluation_id) REFERENCES evaluation (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_A6E330BCFB448723 ON copie (id_evaluation_id)');
        $this->addSql('CREATE INDEX IDX_A6E330BC79F37AE5 ON copie (id_user_id)');
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA92155D8F51');
        $this->addSql('DROP INDEX IDX_A412FA92155D8F51 ON quiz');
        $this->addSql('ALTER TABLE quiz CHANGE formateur_id id_formateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA92369CFA23 FOREIGN KEY (id_formateur_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_A412FA92369CFA23 ON quiz (id_formateur_id)');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC74C4047D3');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC71E27F6BF');
        $this->addSql('DROP INDEX IDX_5FB6DEC74C4047D3 ON reponse');
        $this->addSql('DROP INDEX IDX_5FB6DEC71E27F6BF ON reponse');
        $this->addSql('ALTER TABLE reponse ADD id_copie_id INT NOT NULL, ADD id_question_id INT NOT NULL, DROP copie_id, DROP question_id');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC71C9BAB46 FOREIGN KEY (id_copie_id) REFERENCES copie (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC76353B48 FOREIGN KEY (id_question_id) REFERENCES question (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5FB6DEC76353B48 ON reponse (id_question_id)');
        $this->addSql('CREATE INDEX IDX_5FB6DEC71C9BAB46 ON reponse (id_copie_id)');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575853CD175');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575D5E86FF');
        $this->addSql('DROP INDEX IDX_1323A575853CD175 ON evaluation');
        $this->addSql('DROP INDEX IDX_1323A575D5E86FF ON evaluation');
        $this->addSql('ALTER TABLE evaluation ADD id_quiz_id INT NOT NULL, ADD id_etat_id INT NOT NULL, DROP quiz_id, DROP etat_id');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A5755BA17805 FOREIGN KEY (id_quiz_id) REFERENCES quiz (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575D3C32F8F FOREIGN KEY (id_etat_id) REFERENCES etat (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_1323A575D3C32F8F ON evaluation (id_etat_id)');
        $this->addSql('CREATE INDEX IDX_1323A5755BA17805 ON evaluation (id_quiz_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495200282E');
        $this->addSql('DROP INDEX IDX_8D93D649D60322AC ON user');
        $this->addSql('DROP INDEX IDX_8D93D6495200282E ON user');
        $this->addSql('ALTER TABLE user CHANGE role_id id_role_id INT NOT NULL, CHANGE formation_id id_formation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64971C15D5C FOREIGN KEY (id_formation_id) REFERENCES formation (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64989E8BDC FOREIGN KEY (id_role_id) REFERENCES role (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D64971C15D5C ON user (id_formation_id)');
        $this->addSql('CREATE INDEX IDX_8D93D64989E8BDC ON user (id_role_id)');
    }
}
