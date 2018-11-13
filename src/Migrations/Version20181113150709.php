<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181113150709 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE invitation (id INT AUTO_INCREMENT NOT NULL, invitation_group_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(31) DEFAULT NULL, code INT NOT NULL, created DATETIME NOT NULL, last_change DATETIME NOT NULL, status INT NOT NULL, url_name VARCHAR(255) NOT NULL, token VARCHAR(32) NOT NULL, INDEX IDX_F11D61A2DE40A1DA (invitation_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invitation_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(15) DEFAULT NULL, custom_order INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(15) DEFAULT NULL, custom_order INT NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, invitation_id INT NOT NULL, person_group_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, status INT NOT NULL, custom_order INT NOT NULL, INDEX IDX_34DCD176A35D7AF0 (invitation_id), INDEX IDX_34DCD1766A127C70 (person_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A2DE40A1DA FOREIGN KEY (invitation_group_id) REFERENCES invitation_group (id)');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD176A35D7AF0 FOREIGN KEY (invitation_id) REFERENCES invitation (id)');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD1766A127C70 FOREIGN KEY (person_group_id) REFERENCES person_group (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD176A35D7AF0');
        $this->addSql('ALTER TABLE invitation DROP FOREIGN KEY FK_F11D61A2DE40A1DA');
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD1766A127C70');
        $this->addSql('DROP TABLE invitation');
        $this->addSql('DROP TABLE invitation_group');
        $this->addSql('DROP TABLE person_group');
        $this->addSql('DROP TABLE person');
    }
}
