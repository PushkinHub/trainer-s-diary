<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200226102250 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE training (id INT AUTO_INCREMENT NOT NULL, ward_id INT DEFAULT NULL, trainer_id INT DEFAULT NULL, repeats_actual INT DEFAULT NULL, repeats_expect INT DEFAULT NULL, trained_at DATETIME NOT NULL, note LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_D5128A8FD95D22FD (ward_id), INDEX IDX_D5128A8FFB08EDF6 (trainer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, middle_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, number INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D64996901F54 (number), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercise_type (id INT AUTO_INCREMENT NOT NULL, trainer_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, note LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, parameter_type INT NOT NULL, INDEX IDX_D5FB359BFB08EDF6 (trainer_id), UNIQUE INDEX exercise_type__name_trainer_id__idx (name, trainer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercise (id INT AUTO_INCREMENT NOT NULL, training_id INT NOT NULL, exercise_type_id INT NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_AEDAD51CBEFD98D1 (training_id), INDEX IDX_AEDAD51C1F597BD6 (exercise_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercise_type_alias (id INT AUTO_INCREMENT NOT NULL, exercise_type_id INT NOT NULL, trainer_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_AF1130031F597BD6 (exercise_type_id), INDEX IDX_AF113003FB08EDF6 (trainer_id), UNIQUE INDEX exercise_type__name_trainer_id__idx (name, trainer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercise_parameter (id INT AUTO_INCREMENT NOT NULL, value INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercise_parameter_exercise (exercise_parameter_id INT NOT NULL, exercise_id INT NOT NULL, INDEX IDX_67AD472796CE6EFF (exercise_parameter_id), INDEX IDX_67AD4727E934951A (exercise_id), PRIMARY KEY(exercise_parameter_id, exercise_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8FD95D22FD FOREIGN KEY (ward_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8FFB08EDF6 FOREIGN KEY (trainer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE exercise_type ADD CONSTRAINT FK_D5FB359BFB08EDF6 FOREIGN KEY (trainer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE exercise ADD CONSTRAINT FK_AEDAD51CBEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id)');
        $this->addSql('ALTER TABLE exercise ADD CONSTRAINT FK_AEDAD51C1F597BD6 FOREIGN KEY (exercise_type_id) REFERENCES exercise_type (id)');
        $this->addSql('ALTER TABLE exercise_type_alias ADD CONSTRAINT FK_AF1130031F597BD6 FOREIGN KEY (exercise_type_id) REFERENCES exercise_type (id)');
        $this->addSql('ALTER TABLE exercise_type_alias ADD CONSTRAINT FK_AF113003FB08EDF6 FOREIGN KEY (trainer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE exercise_parameter_exercise ADD CONSTRAINT FK_67AD472796CE6EFF FOREIGN KEY (exercise_parameter_id) REFERENCES exercise_parameter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercise_parameter_exercise ADD CONSTRAINT FK_67AD4727E934951A FOREIGN KEY (exercise_id) REFERENCES exercise (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE exercise DROP FOREIGN KEY FK_AEDAD51CBEFD98D1');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8FD95D22FD');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8FFB08EDF6');
        $this->addSql('ALTER TABLE exercise_type DROP FOREIGN KEY FK_D5FB359BFB08EDF6');
        $this->addSql('ALTER TABLE exercise_type_alias DROP FOREIGN KEY FK_AF113003FB08EDF6');
        $this->addSql('ALTER TABLE exercise DROP FOREIGN KEY FK_AEDAD51C1F597BD6');
        $this->addSql('ALTER TABLE exercise_type_alias DROP FOREIGN KEY FK_AF1130031F597BD6');
        $this->addSql('ALTER TABLE exercise_parameter_exercise DROP FOREIGN KEY FK_67AD4727E934951A');
        $this->addSql('ALTER TABLE exercise_parameter_exercise DROP FOREIGN KEY FK_67AD472796CE6EFF');
        $this->addSql('DROP TABLE training');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE exercise_type');
        $this->addSql('DROP TABLE exercise');
        $this->addSql('DROP TABLE exercise_type_alias');
        $this->addSql('DROP TABLE exercise_parameter');
        $this->addSql('DROP TABLE exercise_parameter_exercise');
    }
}
