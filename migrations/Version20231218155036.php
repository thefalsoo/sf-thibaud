<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231218155036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE outil_tag (outils_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_85DB84ACAF7E699 (outils_id), INDEX IDX_85DB84ACBAD26311 (tag_id), PRIMARY KEY(outils_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE outil_tag ADD CONSTRAINT FK_85DB84ACAF7E699 FOREIGN KEY (outils_id) REFERENCES outils (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE outil_tag ADD CONSTRAINT FK_85DB84ACBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE outil_tag DROP FOREIGN KEY FK_85DB84ACAF7E699');
        $this->addSql('ALTER TABLE outil_tag DROP FOREIGN KEY FK_85DB84ACBAD26311');
        $this->addSql('DROP TABLE outil_tag');
    }
}
