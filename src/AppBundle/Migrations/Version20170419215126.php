<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170419215126 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE media__gallery_media (id INT AUTO_INCREMENT NOT NULL, position INT NOT NULL, enabled TINYINT(1) NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media__media (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, enabled TINYINT(1) NOT NULL, provider_name VARCHAR(255) NOT NULL, provider_status INT NOT NULL, provider_reference VARCHAR(255) NOT NULL, provider_metadata LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', width INT DEFAULT NULL, height INT DEFAULT NULL, length NUMERIC(10, 0) DEFAULT NULL, content_type VARCHAR(255) DEFAULT NULL, content_size INT DEFAULT NULL, copyright VARCHAR(255) DEFAULT NULL, author_name VARCHAR(255) DEFAULT NULL, context VARCHAR(64) DEFAULT NULL, cdn_is_flushable TINYINT(1) DEFAULT NULL, cdn_flush_identifier VARCHAR(64) DEFAULT NULL, cdn_flush_at DATETIME DEFAULT NULL, cdn_status INT DEFAULT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media__gallery (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, context VARCHAR(64) NOT NULL, default_format VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE helpful (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, file VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) DEFAULT NULL, company_name VARCHAR(255) NOT NULL, business_address VARCHAR(255) DEFAULT NULL, legal_address VARCHAR(255) DEFAULT NULL, tin VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE properties_product (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, type_id INT DEFAULT NULL, image_id INT DEFAULT NULL, price_owner_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, count VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_4DCF0580549213EC (property_id), INDEX IDX_4DCF0580C54C8C93 (type_id), INDEX IDX_4DCF05803DA5256D (image_id), INDEX IDX_4DCF05801C8A5AEE (price_owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE properties (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, type_id INT DEFAULT NULL, category_id INT DEFAULT NULL, file_id INT DEFAULT NULL, financing TINYINT(1) NOT NULL, insurance TINYINT(1) NOT NULL, shipment VARCHAR(255) DEFAULT NULL, advance INT DEFAULT NULL, budget INT DEFAULT NULL, overview LONGTEXT DEFAULT NULL, removed TINYINT(1) DEFAULT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, price_count INT DEFAULT NULL, actived TINYINT(1) DEFAULT NULL, property_type LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_87C331C77E3C61F9 (owner_id), INDEX IDX_87C331C7C54C8C93 (type_id), INDEX IDX_87C331C712469DE2 (category_id), INDEX IDX_87C331C793CB796C (file_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorites (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, property_id INT DEFAULT NULL, category TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_E46960F57E3C61F9 (owner_id), INDEX IDX_E46960F5549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conditions (id INT AUTO_INCREMENT NOT NULL, `condition` VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE properties_types (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, limit_days INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_C326967B3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_E01FBE6A7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_1DD399503DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE price_product (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, property_id INT DEFAULT NULL, established TINYINT(1) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_B86CCCF17E3C61F9 (owner_id), INDEX IDX_B86CCCF1549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE price (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, product_id INT DEFAULT NULL, owner_id INT DEFAULT NULL, file_id INT DEFAULT NULL, price INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, financing VARCHAR(255) NOT NULL, shipment TINYINT(1) NOT NULL, established TINYINT(1) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_CAC822D9549213EC (property_id), INDEX IDX_CAC822D94584665A (product_id), INDEX IDX_CAC822D97E3C61F9 (owner_id), INDEX IDX_CAC822D993CB796C (file_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE privacy (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, phone VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, admin_email VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE files (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_63540597E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE properties_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shipment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE properties_product ADD CONSTRAINT FK_4DCF0580549213EC FOREIGN KEY (property_id) REFERENCES properties (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE properties_product ADD CONSTRAINT FK_4DCF0580C54C8C93 FOREIGN KEY (type_id) REFERENCES product_type (id)');
        $this->addSql('ALTER TABLE properties_product ADD CONSTRAINT FK_4DCF05803DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE properties_product ADD CONSTRAINT FK_4DCF05801C8A5AEE FOREIGN KEY (price_owner_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE properties ADD CONSTRAINT FK_87C331C77E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE properties ADD CONSTRAINT FK_87C331C7C54C8C93 FOREIGN KEY (type_id) REFERENCES properties_types (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE properties ADD CONSTRAINT FK_87C331C712469DE2 FOREIGN KEY (category_id) REFERENCES properties_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE properties ADD CONSTRAINT FK_87C331C793CB796C FOREIGN KEY (file_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F57E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F5549213EC FOREIGN KEY (property_id) REFERENCES properties (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE properties_types ADD CONSTRAINT FK_C326967B3DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A7E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD399503DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE price_product ADD CONSTRAINT FK_B86CCCF17E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE price_product ADD CONSTRAINT FK_B86CCCF1549213EC FOREIGN KEY (property_id) REFERENCES properties (id)');
        $this->addSql('ALTER TABLE price ADD CONSTRAINT FK_CAC822D9549213EC FOREIGN KEY (property_id) REFERENCES properties (id)');
        $this->addSql('ALTER TABLE price ADD CONSTRAINT FK_CAC822D94584665A FOREIGN KEY (product_id) REFERENCES properties_product (id)');
        $this->addSql('ALTER TABLE price ADD CONSTRAINT FK_CAC822D97E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE price ADD CONSTRAINT FK_CAC822D993CB796C FOREIGN KEY (file_id) REFERENCES files (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT FK_63540597E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE properties_product DROP FOREIGN KEY FK_4DCF05803DA5256D');
        $this->addSql('ALTER TABLE properties DROP FOREIGN KEY FK_87C331C793CB796C');
        $this->addSql('ALTER TABLE properties_types DROP FOREIGN KEY FK_C326967B3DA5256D');
        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD399503DA5256D');
        $this->addSql('ALTER TABLE properties_product DROP FOREIGN KEY FK_4DCF05801C8A5AEE');
        $this->addSql('ALTER TABLE properties DROP FOREIGN KEY FK_87C331C77E3C61F9');
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY FK_E46960F57E3C61F9');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A7E3C61F9');
        $this->addSql('ALTER TABLE price_product DROP FOREIGN KEY FK_B86CCCF17E3C61F9');
        $this->addSql('ALTER TABLE price DROP FOREIGN KEY FK_CAC822D97E3C61F9');
        $this->addSql('ALTER TABLE files DROP FOREIGN KEY FK_63540597E3C61F9');
        $this->addSql('ALTER TABLE price DROP FOREIGN KEY FK_CAC822D94584665A');
        $this->addSql('ALTER TABLE properties_product DROP FOREIGN KEY FK_4DCF0580549213EC');
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY FK_E46960F5549213EC');
        $this->addSql('ALTER TABLE price_product DROP FOREIGN KEY FK_B86CCCF1549213EC');
        $this->addSql('ALTER TABLE price DROP FOREIGN KEY FK_CAC822D9549213EC');
        $this->addSql('ALTER TABLE properties DROP FOREIGN KEY FK_87C331C7C54C8C93');
        $this->addSql('ALTER TABLE price DROP FOREIGN KEY FK_CAC822D993CB796C');
        $this->addSql('ALTER TABLE properties_product DROP FOREIGN KEY FK_4DCF0580C54C8C93');
        $this->addSql('ALTER TABLE properties DROP FOREIGN KEY FK_87C331C712469DE2');
        $this->addSql('DROP TABLE media__gallery_media');
        $this->addSql('DROP TABLE media__media');
        $this->addSql('DROP TABLE media__gallery');
        $this->addSql('DROP TABLE helpful');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE properties_product');
        $this->addSql('DROP TABLE properties');
        $this->addSql('DROP TABLE favorites');
        $this->addSql('DROP TABLE conditions');
        $this->addSql('DROP TABLE properties_types');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE price_product');
        $this->addSql('DROP TABLE price');
        $this->addSql('DROP TABLE privacy');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE files');
        $this->addSql('DROP TABLE product_type');
        $this->addSql('DROP TABLE properties_category');
        $this->addSql('DROP TABLE shipment');
    }
}
