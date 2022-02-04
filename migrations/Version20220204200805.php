<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220204200805 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, telegram VARCHAR(255) NOT NULL, ticket_number INT NOT NULL, is_valid TINYINT(1) NOT NULL, image LONGTEXT DEFAULT NULL, updated_at DATETIME NOT NULL, is_subscribe TINYINT(1) NOT NULL, payment_type VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_D79F6B11E7927C74 (email), UNIQUE INDEX UNIQ_D79F6B1143320DA (telegram), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participant_tirage (participant_id INT NOT NULL, tirage_id INT NOT NULL, INDEX IDX_9868E47E9D1C3019 (participant_id), INDEX IDX_9868E47E82579054 (tirage_id), PRIMARY KEY(participant_id, tirage_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tirage (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, begin_date DATETIME NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE winner (id INT AUTO_INCREMENT NOT NULL, tirage_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_CF6600E82579054 (tirage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE participant_tirage ADD CONSTRAINT FK_9868E47E9D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participant_tirage ADD CONSTRAINT FK_9868E47E82579054 FOREIGN KEY (tirage_id) REFERENCES tirage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE winner ADD CONSTRAINT FK_CF6600E82579054 FOREIGN KEY (tirage_id) REFERENCES tirage (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participant_tirage DROP FOREIGN KEY FK_9868E47E9D1C3019');
        $this->addSql('ALTER TABLE participant_tirage DROP FOREIGN KEY FK_9868E47E82579054');
        $this->addSql('ALTER TABLE winner DROP FOREIGN KEY FK_CF6600E82579054');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE participant_tirage');
        $this->addSql('DROP TABLE tirage');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE winner');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
