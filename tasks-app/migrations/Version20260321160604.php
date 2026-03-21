<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260321160604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task DROP CONSTRAINT fk_527edb253b5744a0');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT fk_527edb251ac3754');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT fk_527edb25f987d8a8');
        $this->addSql('DROP INDEX idx_527edb253b5744a0');
        $this->addSql('DROP INDEX idx_527edb25f987d8a8');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "task" ADD CONSTRAINT fk_527edb253b5744a0 FOREIGN KEY (user_appointed_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "task" ADD CONSTRAINT fk_527edb251ac3754 FOREIGN KEY (user_completed_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "task" ADD CONSTRAINT fk_527edb25f987d8a8 FOREIGN KEY (user_created_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_527edb253b5744a0 ON "task" (user_appointed_id)');
        $this->addSql('CREATE INDEX idx_527edb25f987d8a8 ON "task" (user_created_id)');
    }
}
