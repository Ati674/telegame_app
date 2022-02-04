<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220129170406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated,FK_2A145AFF5DFCD4B8 please modify it to your needs
        $this->addSql('SET FOREIGN_KEY_CHECKS=0');
        $this->addSql('DROP INDEX IDX_2A145AFF5DFCD4B8 ON tirage');
        $this->addSql('ALTER TABLE tirage DROP winner_id');
        $this->addSql('ALTER TABLE winner DROP INDEX UNIQ_CF6600E82579054, ADD INDEX IDX_CF6600E82579054 (tirage_id)');
        $this->addSql('ALTER TABLE winner CHANGE tirage_id tirage_id INT DEFAULT NULL');
        $this->addSql('SET FOREIGN_KEY_CHECKS=1');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tirage ADD winner_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_2A145AFF5DFCD4B8 ON tirage (winner_id)');
        $this->addSql('ALTER TABLE winner DROP INDEX IDX_CF6600E82579054, ADD UNIQUE INDEX UNIQ_CF6600E82579054 (tirage_id)');
        $this->addSql('ALTER TABLE winner CHANGE tirage_id tirage_id INT NOT NULL');
    }
}
