<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190321161718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE place');
        $this->addSql('CREATE TABLE place (id INT AUTO_INCREMENT NOT NULL, id_emplacement INT DEFAULT NULL, id_brocante INT DEFAULT NULL, prix DOUBLE PRECISION NOT NULL, disponible TINYINT(1) NOT NULL, INDEX IDX_741D53CDD8DDA801 (id_emplacement), INDEX IDX_741D53CD4CA8BA43 (id_brocante), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CDD8DDA801 FOREIGN KEY (id_emplacement) REFERENCES emplacement (id_emplacement)');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CD4CA8BA43 FOREIGN KEY (id_brocante) REFERENCES brocante (id_brocante)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE place');
        $this->addSql('CREATE TABLE place (id_emplacement INT NOT NULL, id_brocante INT NOT NULL, prix DOUBLE PRECISION NOT NULL, disponible TINYINT(1) NOT NULL, INDEX IDX_741D53CDD8DDA801 (id_emplacement), INDEX IDX_741D53CD4CA8BA43 (id_brocante), PRIMARY KEY(id_emplacement, id_brocante)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CDD8DDA801 FOREIGN KEY (id_emplacement) REFERENCES emplacement (id_emplacement)');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CD4CA8BA43 FOREIGN KEY (id_brocante) REFERENCES brocante (id_brocante)');
    }
}
