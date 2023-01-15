<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230115130051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE day_unavailability CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE day_unavailability ADD CONSTRAINT FK_798CB928BF396750 FOREIGN KEY (id) REFERENCES offer_unavailability (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exceptional_unavailability CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE exceptional_unavailability ADD CONSTRAINT FK_F4B40F5FBF396750 FOREIGN KEY (id) REFERENCES offer_unavailability (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offer_unavailability ADD discr VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE day_unavailability DROP FOREIGN KEY FK_798CB928BF396750');
        $this->addSql('ALTER TABLE day_unavailability CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE exceptional_unavailability DROP FOREIGN KEY FK_F4B40F5FBF396750');
        $this->addSql('ALTER TABLE exceptional_unavailability CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE offer_unavailability DROP discr');
    }
}
