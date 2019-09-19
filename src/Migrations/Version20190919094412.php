<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190919094412 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE backpack (id INT AUTO_INCREMENT NOT NULL, category_backpack_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, last_modif DATETIME DEFAULT NULL, published_date DATETIME NOT NULL, INDEX IDX_C358569869BDFD5 (category_backpack_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE backpack_season (backpack_id INT NOT NULL, season_id INT NOT NULL, INDEX IDX_7A93B83931009DBE (backpack_id), INDEX IDX_7A93B8394EC001D1 (season_id), PRIMARY KEY(backpack_id, season_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE backpack_trip (backpack_id INT NOT NULL, trip_id INT NOT NULL, INDEX IDX_EBC3BE6231009DBE (backpack_id), INDEX IDX_EBC3BE62A5BC2E0E (trip_id), PRIMARY KEY(backpack_id, trip_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE backpack_country (backpack_id INT NOT NULL, country_id INT NOT NULL, INDEX IDX_A3F62DC131009DBE (backpack_id), INDEX IDX_A3F62DC1F92F3E70 (country_id), PRIMARY KEY(backpack_id, country_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE backpack_item (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, category_item_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, buy_url VARCHAR(255) DEFAULT NULL, add_date DATETIME NOT NULL, modify_date DATETIME NOT NULL, INDEX IDX_828E6E47A76ED395 (user_id), INDEX IDX_828E6E47D5B71220 (category_item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE backpack_item_season (backpack_item_id INT NOT NULL, season_id INT NOT NULL, INDEX IDX_F303E9B4E2EAB6F9 (backpack_item_id), INDEX IDX_F303E9B44EC001D1 (season_id), PRIMARY KEY(backpack_item_id, season_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_backpack (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_item (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, country_id INT DEFAULT NULL, text LONGTEXT NOT NULL, publish_date DATETIME NOT NULL, modify_date DATETIME DEFAULT NULL, INDEX IDX_9474526CA76ED395 (user_id), INDEX IDX_9474526CF92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(80) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country_trip (country_id INT NOT NULL, trip_id INT NOT NULL, INDEX IDX_F1657EDFF92F3E70 (country_id), INDEX IDX_F1657EDFA5BC2E0E (trip_id), PRIMARY KEY(country_id, trip_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notation (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, backpack_item_id INT DEFAULT NULL, comment_id INT DEFAULT NULL, country_id INT DEFAULT NULL, number_like INT DEFAULT NULL, number_dislike INT DEFAULT NULL, INDEX IDX_268BC95A76ED395 (user_id), INDEX IDX_268BC95E2EAB6F9 (backpack_item_id), INDEX IDX_268BC95F8697D13 (comment_id), INDEX IDX_268BC95F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE season (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(80) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trip (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, INDEX IDX_7656F53BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(90) DEFAULT NULL, last_name VARCHAR(100) DEFAULT NULL, date_of_birth DATE DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, is_actif TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_backpack (user_id INT NOT NULL, backpack_id INT NOT NULL, INDEX IDX_ECB86169A76ED395 (user_id), INDEX IDX_ECB8616931009DBE (backpack_id), PRIMARY KEY(user_id, backpack_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE backpack ADD CONSTRAINT FK_C358569869BDFD5 FOREIGN KEY (category_backpack_id) REFERENCES category_backpack (id)');
        $this->addSql('ALTER TABLE backpack_season ADD CONSTRAINT FK_7A93B83931009DBE FOREIGN KEY (backpack_id) REFERENCES backpack (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE backpack_season ADD CONSTRAINT FK_7A93B8394EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE backpack_trip ADD CONSTRAINT FK_EBC3BE6231009DBE FOREIGN KEY (backpack_id) REFERENCES backpack (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE backpack_trip ADD CONSTRAINT FK_EBC3BE62A5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE backpack_country ADD CONSTRAINT FK_A3F62DC131009DBE FOREIGN KEY (backpack_id) REFERENCES backpack (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE backpack_country ADD CONSTRAINT FK_A3F62DC1F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE backpack_item ADD CONSTRAINT FK_828E6E47A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE backpack_item ADD CONSTRAINT FK_828E6E47D5B71220 FOREIGN KEY (category_item_id) REFERENCES category_item (id)');
        $this->addSql('ALTER TABLE backpack_item_season ADD CONSTRAINT FK_F303E9B4E2EAB6F9 FOREIGN KEY (backpack_item_id) REFERENCES backpack_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE backpack_item_season ADD CONSTRAINT FK_F303E9B44EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE country_trip ADD CONSTRAINT FK_F1657EDFF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE country_trip ADD CONSTRAINT FK_F1657EDFA5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notation ADD CONSTRAINT FK_268BC95A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE notation ADD CONSTRAINT FK_268BC95E2EAB6F9 FOREIGN KEY (backpack_item_id) REFERENCES backpack_item (id)');
        $this->addSql('ALTER TABLE notation ADD CONSTRAINT FK_268BC95F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE notation ADD CONSTRAINT FK_268BC95F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_backpack ADD CONSTRAINT FK_ECB86169A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_backpack ADD CONSTRAINT FK_ECB8616931009DBE FOREIGN KEY (backpack_id) REFERENCES backpack (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE backpack_season DROP FOREIGN KEY FK_7A93B83931009DBE');
        $this->addSql('ALTER TABLE backpack_trip DROP FOREIGN KEY FK_EBC3BE6231009DBE');
        $this->addSql('ALTER TABLE backpack_country DROP FOREIGN KEY FK_A3F62DC131009DBE');
        $this->addSql('ALTER TABLE user_backpack DROP FOREIGN KEY FK_ECB8616931009DBE');
        $this->addSql('ALTER TABLE backpack_item_season DROP FOREIGN KEY FK_F303E9B4E2EAB6F9');
        $this->addSql('ALTER TABLE notation DROP FOREIGN KEY FK_268BC95E2EAB6F9');
        $this->addSql('ALTER TABLE backpack DROP FOREIGN KEY FK_C358569869BDFD5');
        $this->addSql('ALTER TABLE backpack_item DROP FOREIGN KEY FK_828E6E47D5B71220');
        $this->addSql('ALTER TABLE notation DROP FOREIGN KEY FK_268BC95F8697D13');
        $this->addSql('ALTER TABLE backpack_country DROP FOREIGN KEY FK_A3F62DC1F92F3E70');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF92F3E70');
        $this->addSql('ALTER TABLE country_trip DROP FOREIGN KEY FK_F1657EDFF92F3E70');
        $this->addSql('ALTER TABLE notation DROP FOREIGN KEY FK_268BC95F92F3E70');
        $this->addSql('ALTER TABLE backpack_season DROP FOREIGN KEY FK_7A93B8394EC001D1');
        $this->addSql('ALTER TABLE backpack_item_season DROP FOREIGN KEY FK_F303E9B44EC001D1');
        $this->addSql('ALTER TABLE backpack_trip DROP FOREIGN KEY FK_EBC3BE62A5BC2E0E');
        $this->addSql('ALTER TABLE country_trip DROP FOREIGN KEY FK_F1657EDFA5BC2E0E');
        $this->addSql('ALTER TABLE backpack_item DROP FOREIGN KEY FK_828E6E47A76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE notation DROP FOREIGN KEY FK_268BC95A76ED395');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53BA76ED395');
        $this->addSql('ALTER TABLE user_backpack DROP FOREIGN KEY FK_ECB86169A76ED395');
        $this->addSql('DROP TABLE backpack');
        $this->addSql('DROP TABLE backpack_season');
        $this->addSql('DROP TABLE backpack_trip');
        $this->addSql('DROP TABLE backpack_country');
        $this->addSql('DROP TABLE backpack_item');
        $this->addSql('DROP TABLE backpack_item_season');
        $this->addSql('DROP TABLE category_backpack');
        $this->addSql('DROP TABLE category_item');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE country_trip');
        $this->addSql('DROP TABLE notation');
        $this->addSql('DROP TABLE season');
        $this->addSql('DROP TABLE trip');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_backpack');
    }
}
