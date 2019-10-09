<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191003122156 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE backpack_backpack_item (backpack_id INT NOT NULL, backpack_item_id INT NOT NULL, INDEX IDX_34801BD731009DBE (backpack_id), INDEX IDX_34801BD7E2EAB6F9 (backpack_item_id), PRIMARY KEY(backpack_id, backpack_item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE backpack_backpack_item ADD CONSTRAINT FK_34801BD731009DBE FOREIGN KEY (backpack_id) REFERENCES backpack (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE backpack_backpack_item ADD CONSTRAINT FK_34801BD7E2EAB6F9 FOREIGN KEY (backpack_item_id) REFERENCES backpack_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE backpack CHANGE category_backpack_id category_backpack_id INT DEFAULT NULL, CHANGE last_modif last_modif DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE backpack_item CHANGE user_id user_id INT DEFAULT NULL, CHANGE category_item_id category_item_id INT DEFAULT NULL, CHANGE buy_url buy_url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE comment CHANGE user_id user_id INT DEFAULT NULL, CHANGE country_id country_id INT DEFAULT NULL, CHANGE modify_date modify_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE notation CHANGE user_id user_id INT DEFAULT NULL, CHANGE backpack_item_id backpack_item_id INT DEFAULT NULL, CHANGE comment_id comment_id INT DEFAULT NULL, CHANGE country_id country_id INT DEFAULT NULL, CHANGE number_like number_like INT DEFAULT NULL, CHANGE number_dislike number_dislike INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trip CHANGE user_id user_id INT DEFAULT NULL, CHANGE start_date start_date DATE DEFAULT NULL, CHANGE end_date end_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE first_name first_name VARCHAR(90) DEFAULT NULL, CHANGE last_name last_name VARCHAR(100) DEFAULT NULL, CHANGE date_of_birth date_of_birth DATE DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE backpack_backpack_item');
        $this->addSql('ALTER TABLE backpack CHANGE category_backpack_id category_backpack_id INT DEFAULT NULL, CHANGE last_modif last_modif DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE backpack_item CHANGE user_id user_id INT DEFAULT NULL, CHANGE category_item_id category_item_id INT DEFAULT NULL, CHANGE buy_url buy_url VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE comment CHANGE user_id user_id INT DEFAULT NULL, CHANGE country_id country_id INT DEFAULT NULL, CHANGE modify_date modify_date DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE notation CHANGE user_id user_id INT DEFAULT NULL, CHANGE backpack_item_id backpack_item_id INT DEFAULT NULL, CHANGE comment_id comment_id INT DEFAULT NULL, CHANGE country_id country_id INT DEFAULT NULL, CHANGE number_like number_like INT DEFAULT NULL, CHANGE number_dislike number_dislike INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trip CHANGE user_id user_id INT DEFAULT NULL, CHANGE start_date start_date DATE DEFAULT \'NULL\', CHANGE end_date end_date DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE first_name first_name VARCHAR(90) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE last_name last_name VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE date_of_birth date_of_birth DATE DEFAULT \'NULL\', CHANGE email email VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
