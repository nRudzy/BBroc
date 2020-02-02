<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190402122122 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE brocante CHANGE lieu lieu INT DEFAULT NULL');
        $this->addSql('ALTER TABLE brocante ADD CONSTRAINT FK_1C7356D62F577D59 FOREIGN KEY (lieu) REFERENCES villesfr (ville_id)');
        $this->addSql('CREATE INDEX IDX_1C7356D62F577D59 ON brocante (lieu)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE brocante DROP FOREIGN KEY FK_1C7356D62F577D59');
        $this->addSql('DROP INDEX IDX_1C7356D62F577D59 ON brocante');
        $this->addSql('ALTER TABLE brocante CHANGE lieu lieu VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
