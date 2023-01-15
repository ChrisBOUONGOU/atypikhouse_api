<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230113080100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, city_id INT NOT NULL, latitude VARCHAR(255) DEFAULT NULL, longitude VARCHAR(255) DEFAULT NULL, line1 VARCHAR(255) NOT NULL, postal_code VARCHAR(20) NOT NULL, INDEX IDX_D4E6F818BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE day_unavailability (id INT AUTO_INCREMENT NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dynamic_property (id INT AUTO_INCREMENT NOT NULL, offer_type_id INT NOT NULL, name VARCHAR(255) NOT NULL, is_mandatory TINYINT(1) NOT NULL, type VARCHAR(50) NOT NULL, INDEX IDX_149A9DC64444A9A (offer_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dynamic_property_update_notification (id INT AUTO_INCREMENT NOT NULL, dynamic_property_id INT NOT NULL, owner_id INT NOT NULL, is_sent TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_1ABEDE459217F7F1 (dynamic_property_id), INDEX IDX_1ABEDE457E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dynamic_property_value (id INT AUTO_INCREMENT NOT NULL, offer_id INT NOT NULL, dynamic_property_id INT NOT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_685AE89B53C674EE (offer_id), INDEX IDX_685AE89B9217F7F1 (dynamic_property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipment_offer (equipment_id INT NOT NULL, offer_id INT NOT NULL, INDEX IDX_C08FA6DA517FE9FE (equipment_id), INDEX IDX_C08FA6DA53C674EE (offer_id), PRIMARY KEY(equipment_id, offer_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipment_update_notification (id INT AUTO_INCREMENT NOT NULL, equipment_id INT NOT NULL, owner_id INT NOT NULL, is_sent TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_29859109517FE9FE (equipment_id), INDEX IDX_298591097E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exceptional_unavailability (id INT AUTO_INCREMENT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorites (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, offer_id INT NOT NULL, INDEX IDX_E46960F5A76ED395 (user_id), INDEX IDX_E46960F553C674EE (offer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE highlight (id INT AUTO_INCREMENT NOT NULL, offer_id INT NOT NULL, content VARCHAR(255) NOT NULL, INDEX IDX_C998D83453C674EE (offer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, offer_id INT NOT NULL, url VARCHAR(255) NOT NULL, alt VARCHAR(255) DEFAULT NULL, INDEX IDX_6A2CA10C53C674EE (offer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer (id INT AUTO_INCREMENT NOT NULL, address_id INT NOT NULL, offer_type_id INT NOT NULL, owner_id INT NOT NULL, title VARCHAR(120) NOT NULL, summary LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, capacity INT DEFAULT NULL, nb_beds INT DEFAULT NULL, unit_price INT NOT NULL, status VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_29D6873EF5B7AF75 (address_id), INDEX IDX_29D6873E64444A9A (offer_type_id), INDEX IDX_29D6873E7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer_comment (id INT AUTO_INCREMENT NOT NULL, offer_id INT NOT NULL, client_id INT NOT NULL, content LONGTEXT NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_357C946553C674EE (offer_id), INDEX IDX_357C946519EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer_message (id INT AUTO_INCREMENT NOT NULL, from_user_id INT NOT NULL, to_user_id INT NOT NULL, offer_id INT NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_17B5F6762130303A (from_user_id), INDEX IDX_17B5F67629F6EE60 (to_user_id), INDEX IDX_17B5F67653C674EE (offer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_trending TINYINT(1) DEFAULT NULL, image_url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer_unavailability (id INT AUTO_INCREMENT NOT NULL, offer_id INT NOT NULL, INDEX IDX_988E9B0A53C674EE (offer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, offer_id INT NOT NULL, client_id INT NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, unit_price INT NOT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', last_modified DATETIME DEFAULT NULL, total_price INT NOT NULL, payment_date DATETIME DEFAULT NULL, cancel_date DATETIME DEFAULT NULL, payment_id VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_42C8495553C674EE (offer_id), INDEX IDX_42C8495519EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, external_id VARCHAR(255) NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, birthdate DATE DEFAULT NULL, password VARCHAR(255) NOT NULL, phone_number VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F818BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE dynamic_property ADD CONSTRAINT FK_149A9DC64444A9A FOREIGN KEY (offer_type_id) REFERENCES offer_type (id)');
        $this->addSql('ALTER TABLE dynamic_property_update_notification ADD CONSTRAINT FK_1ABEDE459217F7F1 FOREIGN KEY (dynamic_property_id) REFERENCES dynamic_property (id)');
        $this->addSql('ALTER TABLE dynamic_property_update_notification ADD CONSTRAINT FK_1ABEDE457E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE dynamic_property_value ADD CONSTRAINT FK_685AE89B53C674EE FOREIGN KEY (offer_id) REFERENCES offer (id)');
        $this->addSql('ALTER TABLE dynamic_property_value ADD CONSTRAINT FK_685AE89B9217F7F1 FOREIGN KEY (dynamic_property_id) REFERENCES dynamic_property (id)');
        $this->addSql('ALTER TABLE equipment_offer ADD CONSTRAINT FK_C08FA6DA517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipment_offer ADD CONSTRAINT FK_C08FA6DA53C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipment_update_notification ADD CONSTRAINT FK_29859109517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id)');
        $this->addSql('ALTER TABLE equipment_update_notification ADD CONSTRAINT FK_298591097E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F553C674EE FOREIGN KEY (offer_id) REFERENCES offer (id)');
        $this->addSql('ALTER TABLE highlight ADD CONSTRAINT FK_C998D83453C674EE FOREIGN KEY (offer_id) REFERENCES offer (id)');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C53C674EE FOREIGN KEY (offer_id) REFERENCES offer (id)');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873EF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873E64444A9A FOREIGN KEY (offer_type_id) REFERENCES offer_type (id)');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873E7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE offer_comment ADD CONSTRAINT FK_357C946553C674EE FOREIGN KEY (offer_id) REFERENCES offer (id)');
        $this->addSql('ALTER TABLE offer_comment ADD CONSTRAINT FK_357C946519EB6921 FOREIGN KEY (client_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE offer_message ADD CONSTRAINT FK_17B5F6762130303A FOREIGN KEY (from_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE offer_message ADD CONSTRAINT FK_17B5F67629F6EE60 FOREIGN KEY (to_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE offer_message ADD CONSTRAINT FK_17B5F67653C674EE FOREIGN KEY (offer_id) REFERENCES offer (id)');
        $this->addSql('ALTER TABLE offer_unavailability ADD CONSTRAINT FK_988E9B0A53C674EE FOREIGN KEY (offer_id) REFERENCES offer (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495553C674EE FOREIGN KEY (offer_id) REFERENCES offer (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495519EB6921 FOREIGN KEY (client_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F818BAC62AF');
        $this->addSql('ALTER TABLE dynamic_property DROP FOREIGN KEY FK_149A9DC64444A9A');
        $this->addSql('ALTER TABLE dynamic_property_update_notification DROP FOREIGN KEY FK_1ABEDE459217F7F1');
        $this->addSql('ALTER TABLE dynamic_property_update_notification DROP FOREIGN KEY FK_1ABEDE457E3C61F9');
        $this->addSql('ALTER TABLE dynamic_property_value DROP FOREIGN KEY FK_685AE89B53C674EE');
        $this->addSql('ALTER TABLE dynamic_property_value DROP FOREIGN KEY FK_685AE89B9217F7F1');
        $this->addSql('ALTER TABLE equipment_offer DROP FOREIGN KEY FK_C08FA6DA517FE9FE');
        $this->addSql('ALTER TABLE equipment_offer DROP FOREIGN KEY FK_C08FA6DA53C674EE');
        $this->addSql('ALTER TABLE equipment_update_notification DROP FOREIGN KEY FK_29859109517FE9FE');
        $this->addSql('ALTER TABLE equipment_update_notification DROP FOREIGN KEY FK_298591097E3C61F9');
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY FK_E46960F5A76ED395');
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY FK_E46960F553C674EE');
        $this->addSql('ALTER TABLE highlight DROP FOREIGN KEY FK_C998D83453C674EE');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C53C674EE');
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873EF5B7AF75');
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873E64444A9A');
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873E7E3C61F9');
        $this->addSql('ALTER TABLE offer_comment DROP FOREIGN KEY FK_357C946553C674EE');
        $this->addSql('ALTER TABLE offer_comment DROP FOREIGN KEY FK_357C946519EB6921');
        $this->addSql('ALTER TABLE offer_message DROP FOREIGN KEY FK_17B5F6762130303A');
        $this->addSql('ALTER TABLE offer_message DROP FOREIGN KEY FK_17B5F67629F6EE60');
        $this->addSql('ALTER TABLE offer_message DROP FOREIGN KEY FK_17B5F67653C674EE');
        $this->addSql('ALTER TABLE offer_unavailability DROP FOREIGN KEY FK_988E9B0A53C674EE');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495553C674EE');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495519EB6921');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE day_unavailability');
        $this->addSql('DROP TABLE dynamic_property');
        $this->addSql('DROP TABLE dynamic_property_update_notification');
        $this->addSql('DROP TABLE dynamic_property_value');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('DROP TABLE equipment_offer');
        $this->addSql('DROP TABLE equipment_update_notification');
        $this->addSql('DROP TABLE exceptional_unavailability');
        $this->addSql('DROP TABLE favorites');
        $this->addSql('DROP TABLE highlight');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE offer');
        $this->addSql('DROP TABLE offer_comment');
        $this->addSql('DROP TABLE offer_message');
        $this->addSql('DROP TABLE offer_type');
        $this->addSql('DROP TABLE offer_unavailability');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE user');
    }
}
