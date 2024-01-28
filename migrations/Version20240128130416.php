<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240128130416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13B1777D41C');
        $this->addSql('DROP INDEX IDX_6117D13B1777D41C ON purchase');
        $this->addSql('ALTER TABLE purchase CHANGE sku_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_6117D13B4584665A ON purchase (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13B4584665A');
        $this->addSql('DROP INDEX IDX_6117D13B4584665A ON purchase');
        $this->addSql('ALTER TABLE purchase CHANGE product_id sku_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B1777D41C FOREIGN KEY (sku_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_6117D13B1777D41C ON purchase (sku_id)');
    }
}
