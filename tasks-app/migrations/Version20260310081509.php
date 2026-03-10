<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260310081509 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "task" (id UUID NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, status VARCHAR(255) NOT NULL, deadline TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, user_appointed_id INT NOT NULL, user_completed_id INT NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_527EDB253B5744A0 ON "task" (user_appointed_id)');
        $this->addSql('CREATE INDEX IDX_527EDB257B00651C ON "task" (status)');
        $this->addSql('CREATE INDEX IDX_527EDB251AC3754 ON "task" (user_completed_id)');
        $this->addSql('ALTER TABLE "task" ADD CONSTRAINT FK_527EDB253B5744A0 FOREIGN KEY (user_appointed_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE "task" ADD CONSTRAINT FK_527EDB251AC3754 FOREIGN KEY (user_completed_id) REFERENCES "user" (id) NOT DEFERRABLE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "task" DROP CONSTRAINT FK_527EDB253B5744A0');
        $this->addSql('ALTER TABLE "task" DROP CONSTRAINT FK_527EDB251AC3754');
        $this->addSql('DROP TABLE "task"');
    }
}
