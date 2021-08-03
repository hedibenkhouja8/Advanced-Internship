<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210803075027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inventory (id INT AUTO_INCREMENT NOT NULL, equipment VARCHAR(255) NOT NULL, user VARCHAR(255) NOT NULL, locaation VARCHAR(255) NOT NULL, notes LONGTEXT DEFAULT NULL, operating_system VARCHAR(255) DEFAULT NULL, state VARCHAR(255) NOT NULL, brand VARCHAR(255) NOT NULL, model VARCHAR(255) DEFAULT NULL, purchase_date VARCHAR(255) DEFAULT NULL, supplier VARCHAR(255) DEFAULT NULL, last_scan VARCHAR(255) DEFAULT NULL, last_maintenance VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE inventory');
    }
}
