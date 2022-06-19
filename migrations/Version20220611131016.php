<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220611131016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commandes DROP FOREIGN KEY FK_35D4282C9223694D');
        $this->addSql('DROP INDEX IDX_35D4282C9223694D ON commandes');
        $this->addSql('ALTER TABLE commandes ADD nom VARCHAR(255) NOT NULL, ADD telephone INT NOT NULL, ADD envoierapide TINYINT(1) NOT NULL, DROP livrapide, DROP envoie, DROP plus, CHANGE codepostal codepostal INT NOT NULL, CHANGE articleid_id article_id INT NOT NULL');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282C7294869C FOREIGN KEY (article_id) REFERENCES articles (id)');
        $this->addSql('CREATE INDEX IDX_35D4282C7294869C ON commandes (article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commandes DROP FOREIGN KEY FK_35D4282C7294869C');
        $this->addSql('DROP INDEX IDX_35D4282C7294869C ON commandes');
        $this->addSql('ALTER TABLE commandes ADD articleid_id INT NOT NULL, ADD envoie TINYINT(1) NOT NULL, ADD plus TINYINT(1) DEFAULT 0 NOT NULL, DROP article_id, DROP nom, DROP telephone, CHANGE codepostal codepostal VARCHAR(255) NOT NULL, CHANGE envoierapide livrapide TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282C9223694D FOREIGN KEY (articleid_id) REFERENCES articles (id)');
        $this->addSql('CREATE INDEX IDX_35D4282C9223694D ON commandes (articleid_id)');
    }
}
