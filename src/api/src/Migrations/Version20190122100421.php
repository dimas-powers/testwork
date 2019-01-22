<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190122100421 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE orders ADD geo_country VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE orders ADD ip_address VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE orders ADD platform VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE orders ALTER id TYPE INT');
        $this->addSql('ALTER TABLE orders ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE orders ALTER customer_id TYPE INT');
        $this->addSql('ALTER TABLE orders ALTER customer_id DROP DEFAULT');
        $this->addSql('ALTER TABLE orders ALTER customer_id SET NOT NULL');
        $this->addSql('ALTER TABLE balance ALTER id TYPE INT');
        $this->addSql('ALTER TABLE balance ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE balance ALTER customer_id TYPE INT');
        $this->addSql('ALTER TABLE balance ALTER customer_id DROP DEFAULT');
        $this->addSql('ALTER TABLE balance ALTER customer_id SET NOT NULL');
        $this->addSql('ALTER TABLE customer ALTER id TYPE INT');
        $this->addSql('ALTER TABLE customer ALTER id DROP DEFAULT');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE customer ALTER id TYPE BIGINT');
        $this->addSql('ALTER TABLE customer ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE balance ALTER id TYPE BIGINT');
        $this->addSql('ALTER TABLE balance ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE balance ALTER customer_id TYPE BIGINT');
        $this->addSql('ALTER TABLE balance ALTER customer_id DROP DEFAULT');
        $this->addSql('ALTER TABLE balance ALTER customer_id DROP NOT NULL');
        $this->addSql('ALTER TABLE orders DROP geo_country');
        $this->addSql('ALTER TABLE orders DROP ip_address');
        $this->addSql('ALTER TABLE orders DROP platform');
        $this->addSql('ALTER TABLE orders ALTER id TYPE BIGINT');
        $this->addSql('ALTER TABLE orders ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE orders ALTER customer_id TYPE BIGINT');
        $this->addSql('ALTER TABLE orders ALTER customer_id DROP DEFAULT');
        $this->addSql('ALTER TABLE orders ALTER customer_id DROP NOT NULL');
    }
}
