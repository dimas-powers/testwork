<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190120212443 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE customer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE balance_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE orders_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE customer (id BIGINT, email VARCHAR(255) NOT NULL, token VARCHAR(255) DEFAULT NULL, active INT NOT NULL, roles VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, username VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE balance (id BIGINT, customer_id BIGINT, amount BIGINT NOT NULL, currency VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_ACF41FFE9395C3F3 ON balance (customer_id)');
        $this->addSql('CREATE TABLE orders (id BIGINT, customer_id BIGINT, description VARCHAR(255) NOT NULL, amount BIGINT NOT NULL, currency VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E52FFDEE9395C3F3 ON orders (customer_id)');
        $this->addSql('ALTER TABLE balance ADD CONSTRAINT FK_ACF41FFE9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE balance DROP CONSTRAINT FK_ACF41FFE9395C3F3');
        $this->addSql('ALTER TABLE orders DROP CONSTRAINT FK_E52FFDEE9395C3F3');
        $this->addSql('DROP SEQUENCE customer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE balance_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE orders_id_seq CASCADE');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE balance');
        $this->addSql('DROP TABLE orders');
    }
}
