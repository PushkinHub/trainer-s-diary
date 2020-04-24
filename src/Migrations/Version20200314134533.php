<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200314134533 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE exercise_parameter_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exercise_parameter CHANGE parameter_type type_id INT NOT NULL');
        $this->addSql('ALTER TABLE exercise_parameter ADD CONSTRAINT FK_844097FAC54C8C93 FOREIGN KEY (type_id) REFERENCES exercise_parameter_type (id)');
        $this->addSql('CREATE INDEX IDX_844097FAC54C8C93 ON exercise_parameter (type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE exercise_parameter DROP FOREIGN KEY FK_844097FAC54C8C93');
        $this->addSql('DROP TABLE exercise_parameter_type');
        $this->addSql('DROP INDEX IDX_844097FAC54C8C93 ON exercise_parameter');
        $this->addSql('ALTER TABLE exercise_parameter CHANGE type_id parameter_type INT NOT NULL');
    }
}
