<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151121153808 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ext_translations (id INT AUTO_INCREMENT NOT NULL, locale VARCHAR(8) NOT NULL, object_class VARCHAR(255) NOT NULL, field VARCHAR(32) NOT NULL, foreign_key VARCHAR(64) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX translations_lookup_idx (locale, object_class, foreign_key), UNIQUE INDEX lookup_unique_idx (locale, object_class, field, foreign_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, first_name VARCHAR(64) DEFAULT NULL, last_name VARCHAR(64) DEFAULT NULL, date_of_birth DATETIME DEFAULT NULL, gender VARCHAR(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, registered_at DATETIME DEFAULT NULL, type VARCHAR(6) DEFAULT NULL, registration_step VARCHAR(5) DEFAULT NULL, facebook_id VARCHAR(255) DEFAULT NULL, facebook_access_token VARCHAR(255) DEFAULT NULL, google_id VARCHAR(255) DEFAULT NULL, google_access_token VARCHAR(255) DEFAULT NULL, yahoo_id VARCHAR(255) DEFAULT NULL, yahoo_access_token VARCHAR(1256) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D64992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_8D93D649A0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vendor (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(64) DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, contact_person VARCHAR(100) DEFAULT NULL, phone VARCHAR(32) DEFAULT NULL, mobile VARCHAR(32) DEFAULT NULL, address VARCHAR(256) DEFAULT NULL, state VARCHAR(35) DEFAULT NULL, postcode VARCHAR(15) DEFAULT NULL, country VARCHAR(2) NOT NULL, website VARCHAR(256) DEFAULT NULL, category VARCHAR(256) DEFAULT NULL, business_hours VARCHAR(250) DEFAULT NULL, description LONGTEXT DEFAULT NULL, social_media_links LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_F52233F6A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vendor_image (id INT AUTO_INCREMENT NOT NULL, vendor_id INT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, image_path VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_D37B061FF603EE73 (vendor_id), INDEX IDX_D37B061F12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vendor_video (id INT AUTO_INCREMENT NOT NULL, vendor_id INT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, image_path VARCHAR(255) NOT NULL, video_url VARCHAR(512) NOT NULL, video_type VARCHAR(10) NOT NULL, video_id VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_6A81D86CF603EE73 (vendor_id), INDEX IDX_6A81D86C12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vendor ADD CONSTRAINT FK_F52233F6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vendor_image ADD CONSTRAINT FK_D37B061FF603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (id)');
        $this->addSql('ALTER TABLE vendor_image ADD CONSTRAINT FK_D37B061F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE vendor_video ADD CONSTRAINT FK_6A81D86CF603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (id)');
        $this->addSql('ALTER TABLE vendor_video ADD CONSTRAINT FK_6A81D86C12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE vendor DROP FOREIGN KEY FK_F52233F6A76ED395');
        $this->addSql('ALTER TABLE vendor_image DROP FOREIGN KEY FK_D37B061F12469DE2');
        $this->addSql('ALTER TABLE vendor_video DROP FOREIGN KEY FK_6A81D86C12469DE2');
        $this->addSql('ALTER TABLE vendor_image DROP FOREIGN KEY FK_D37B061FF603EE73');
        $this->addSql('ALTER TABLE vendor_video DROP FOREIGN KEY FK_6A81D86CF603EE73');
        $this->addSql('DROP TABLE ext_translations');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE vendor');
        $this->addSql('DROP TABLE vendor_image');
        $this->addSql('DROP TABLE vendor_video');
    }
}
