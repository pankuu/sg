<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230404223939 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE accident_notification_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE inspection_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE accident_notification (id INT NOT NULL, priority VARCHAR(255) NOT NULL, date_of_visit TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, service_notes TEXT DEFAULT NULL, description VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, phone_number VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX accident_notification_description_idx ON accident_notification (description)');
        $this->addSql('CREATE TABLE inspection (id INT NOT NULL, review_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, week_of_the_year INT DEFAULT NULL, maintenance_after_review VARCHAR(255) DEFAULT NULL, description VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, phone_number VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX inspection_description_idx ON inspection (description)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE accident_notification_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE inspection_id_seq CASCADE');
        $this->addSql('DROP TABLE accident_notification');
        $this->addSql('DROP TABLE inspection');
    }
}
