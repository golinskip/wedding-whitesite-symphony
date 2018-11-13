<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181113204654 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE parameter_value (id INT AUTO_INCREMENT NOT NULL, person_id INT DEFAULT NULL, parameter_id INT DEFAULT NULL, value LONGTEXT NOT NULL, INDEX IDX_6DB2A2B8217BBB47 (person_id), INDEX IDX_6DB2A2B87C56DBD6 (parameter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parameter (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, type INT NOT NULL, config LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parameter_value ADD CONSTRAINT FK_6DB2A2B8217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE parameter_value ADD CONSTRAINT FK_6DB2A2B87C56DBD6 FOREIGN KEY (parameter_id) REFERENCES parameter (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE parameter_value DROP FOREIGN KEY FK_6DB2A2B87C56DBD6');
        $this->addSql('DROP TABLE parameter_value');
        $this->addSql('DROP TABLE parameter');
    }
}
