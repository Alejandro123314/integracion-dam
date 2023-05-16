<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230515194211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tarea_usuario (tarea_id INT NOT NULL, usuario_id INT NOT NULL, INDEX IDX_2F594F5F6D5BDFE1 (tarea_id), INDEX IDX_2F594F5FDB38439E (usuario_id), PRIMARY KEY(tarea_id, usuario_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tarea_usuario ADD CONSTRAINT FK_2F594F5F6D5BDFE1 FOREIGN KEY (tarea_id) REFERENCES tarea (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tarea_usuario ADD CONSTRAINT FK_2F594F5FDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tarea_usuario DROP FOREIGN KEY FK_2F594F5F6D5BDFE1');
        $this->addSql('ALTER TABLE tarea_usuario DROP FOREIGN KEY FK_2F594F5FDB38439E');
        $this->addSql('DROP TABLE tarea_usuario');
    }
}
