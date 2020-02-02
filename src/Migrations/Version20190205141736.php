<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190205141736 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE brocante (id_brocante INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, lieu VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id_brocante)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emplacement (id_emplacement INT AUTO_INCREMENT NOT NULL, surface INT NOT NULL, PRIMARY KEY(id_emplacement)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participer (id_brocante INT NOT NULL, id_utilisateur INT NOT NULL, role_brocante VARCHAR(255) NOT NULL, INDEX IDX_EDBE16F84CA8BA43 (id_brocante), INDEX IDX_EDBE16F850EAE44 (id_utilisateur), PRIMARY KEY(id_brocante, id_utilisateur)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE place (id_emplacement INT NOT NULL, id_brocante INT NOT NULL, prix DOUBLE PRECISION NOT NULL, disponible TINYINT(1) NOT NULL, INDEX IDX_741D53CDD8DDA801 (id_emplacement), INDEX IDX_741D53CD4CA8BA43 (id_brocante), PRIMARY KEY(id_emplacement, id_brocante)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id_utilisateur INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, tmp_email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, salt VARCHAR(40) NOT NULL, role VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email_key VARCHAR(40) DEFAULT NULL, password_key VARCHAR(40) DEFAULT NULL, signin_date DATETIME DEFAULT NULL, last_login_date DATETIME DEFAULT NULL, recover_date DATETIME DEFAULT NULL, birth_date DATETIME NOT NULL, PRIMARY KEY(id_utilisateur)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE participer ADD CONSTRAINT FK_EDBE16F84CA8BA43 FOREIGN KEY (id_brocante) REFERENCES brocante (id_brocante)');
        $this->addSql('ALTER TABLE participer ADD CONSTRAINT FK_EDBE16F850EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur)');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CDD8DDA801 FOREIGN KEY (id_emplacement) REFERENCES emplacement (id_emplacement)');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CD4CA8BA43 FOREIGN KEY (id_brocante) REFERENCES brocante (id_brocante)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE participer DROP FOREIGN KEY FK_EDBE16F84CA8BA43');
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY FK_741D53CD4CA8BA43');
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY FK_741D53CDD8DDA801');
        $this->addSql('ALTER TABLE participer DROP FOREIGN KEY FK_EDBE16F850EAE44');
        $this->addSql('DROP TABLE brocante');
        $this->addSql('DROP TABLE emplacement');
        $this->addSql('DROP TABLE participer');
        $this->addSql('DROP TABLE place');
        $this->addSql('DROP TABLE utilisateur');
    }
}
