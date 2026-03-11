<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260311064337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task ADD user_created_id INT NOT NULL');
        $this->addSql('ALTER TABLE task ALTER user_appointed_id DROP NOT NULL');
        $this->addSql('ALTER TABLE task ALTER user_completed_id DROP NOT NULL');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25F987D8A8 FOREIGN KEY (user_created_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('CREATE INDEX IDX_527EDB25F987D8A8 ON task (user_created_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "task" DROP CONSTRAINT FK_527EDB25F987D8A8');
        $this->addSql('DROP INDEX IDX_527EDB25F987D8A8');
        $this->addSql('ALTER TABLE "task" DROP user_created_id');
        $this->addSql('ALTER TABLE "task" ALTER user_appointed_id SET NOT NULL');
        $this->addSql('ALTER TABLE "task" ALTER user_completed_id SET NOT NULL');
    }
}
