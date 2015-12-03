<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151203185758 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs

        // sample categories
        $this->addSql("INSERT INTO category (name) VALUES ('Art');");
        $this->addSql("INSERT INTO category (name) VALUES ('Cars & Motorcycles');");
        $this->addSql("INSERT INTO category (name) VALUES ('DIY & Crafts');");
        $this->addSql("INSERT INTO category (name) VALUES ('Food & Drink');");
        $this->addSql("INSERT INTO category (name) VALUES ('Home Decor');");
        $this->addSql("INSERT INTO category (name) VALUES ('Popular');");
        $this->addSql("INSERT INTO category (name) VALUES ('Videographer');");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql("DELETE FROM category;");
    }
}
