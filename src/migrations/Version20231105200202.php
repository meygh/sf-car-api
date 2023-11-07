<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231105200202 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Creates car table
        $this->addSql('CREATE SEQUENCE car_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE car (
            id INT NOT NULL,
            brand VARCHAR(50) NOT NULL,
            model VARCHAR(100) NOT NULL,
            color VARCHAR(20) NOT NULL, PRIMARY KEY(id)
         )');
        
        // Creates review table
        $this->addSql('CREATE SEQUENCE review_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE review (
            id INT NOT NULL,
            car_id_id INT NOT NULL,
            star_rating SMALLINT NOT NULL,
            review_text VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)
        )');
        
        // Creates index on review and its foreign key to car table
        $this->addSql('CREATE INDEX IDX_794381C6A0EF1B80 ON review (car_id_id)');
        $this->addSql('ALTER TABLE review
            ADD CONSTRAINT FK_794381C6A0EF1B80
            FOREIGN KEY (car_id_id)
                REFERENCES car (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE car_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE review_id_seq CASCADE');
        $this->addSql('ALTER TABLE review DROP CONSTRAINT FK_794381C6A0EF1B80');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE review');
    }
}
