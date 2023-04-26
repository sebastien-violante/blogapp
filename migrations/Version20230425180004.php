<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230425180004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE color (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE piece (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE piece_color (piece_id INT NOT NULL, color_id INT NOT NULL, INDEX IDX_74E5C982C40FCFA8 (piece_id), INDEX IDX_74E5C9827ADA1FB5 (color_id), PRIMARY KEY(piece_id, color_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE piece_color ADD CONSTRAINT FK_74E5C982C40FCFA8 FOREIGN KEY (piece_id) REFERENCES piece (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE piece_color ADD CONSTRAINT FK_74E5C9827ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE piece_color DROP FOREIGN KEY FK_74E5C982C40FCFA8');
        $this->addSql('ALTER TABLE piece_color DROP FOREIGN KEY FK_74E5C9827ADA1FB5');
        $this->addSql('DROP TABLE color');
        $this->addSql('DROP TABLE piece');
        $this->addSql('DROP TABLE piece_color');
    }
}
