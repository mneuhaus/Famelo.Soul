<?php
namespace TYPO3\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
	Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20141220231501 extends AbstractMigration {

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function up(Schema $schema) {
		// this up() migration is autogenerated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

		$this->addSql("CREATE TABLE famelo_soul_domain_model_abstractfragment (persistence_object_identifier VARCHAR(40) NOT NULL, soul VARCHAR(40) DEFAULT NULL, name VARCHAR(255) NOT NULL, dtype VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, createdat DATETIME DEFAULT NULL, emailverified TINYINT(1) DEFAULT NULL, INDEX IDX_3D10774D09FCB3 (soul), PRIMARY KEY(persistence_object_identifier))");
		$this->addSql("CREATE TABLE famelo_soul_domain_model_soul (persistence_object_identifier VARCHAR(40) NOT NULL, token VARCHAR(255) NOT NULL, identifier VARCHAR(255) NOT NULL, dtype VARCHAR(255) NOT NULL, PRIMARY KEY(persistence_object_identifier))");
		$this->addSql("CREATE TABLE famelo_soul_domain_model_partysoul (persistence_object_identifier VARCHAR(40) NOT NULL, PRIMARY KEY(persistence_object_identifier))");
		$this->addSql("ALTER TABLE famelo_soul_domain_model_abstractfragment ADD CONSTRAINT FK_3D10774D09FCB3 FOREIGN KEY (soul) REFERENCES famelo_soul_domain_model_soul (persistence_object_identifier) ON DELETE CASCADE");
		$this->addSql("ALTER TABLE famelo_soul_domain_model_partysoul ADD CONSTRAINT FK_EBCEEA9F47A46B0A FOREIGN KEY (persistence_object_identifier) REFERENCES famelo_soul_domain_model_soul (persistence_object_identifier) ON DELETE CASCADE");
	}

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function down(Schema $schema) {
		// this down() migration is autogenerated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

		$this->addSql("ALTER TABLE famelo_soul_domain_model_abstractfragment DROP FOREIGN KEY FK_3D10774D09FCB3");
		$this->addSql("ALTER TABLE famelo_soul_domain_model_partysoul DROP FOREIGN KEY FK_EBCEEA9F47A46B0A");
		$this->addSql("DROP TABLE famelo_soul_domain_model_abstractfragment");
		$this->addSql("DROP TABLE famelo_soul_domain_model_soul");
		$this->addSql("DROP TABLE famelo_soul_domain_model_partysoul");
	}
}