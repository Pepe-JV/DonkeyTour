<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260220111948 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client_reserve ADD reserve_who BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE reserve ADD employee_id INT NOT NULL');
        $this->addSql('ALTER TABLE reserve ADD CONSTRAINT FK_1FE0EA228C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) NOT DEFERRABLE');
        $this->addSql('CREATE INDEX IDX_1FE0EA228C03F15C ON reserve (employee_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client_reserve DROP reserve_who');
        $this->addSql('ALTER TABLE reserve DROP CONSTRAINT FK_1FE0EA228C03F15C');
        $this->addSql('DROP INDEX IDX_1FE0EA228C03F15C');
        $this->addSql('ALTER TABLE reserve DROP employee_id');
    }
}
