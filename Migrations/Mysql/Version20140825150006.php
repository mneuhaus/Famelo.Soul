<?php
namespace TYPO3\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
	Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20140825150006 extends AbstractMigration {

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function up(Schema $schema) {
		// this up() migration is autogenerated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

		$this->addSql("CREATE TABLE famelo_soul_domain_model_abstractsoulpiece (persistence_object_identifier VARCHAR(40) NOT NULL, soul VARCHAR(40) DEFAULT NULL, vote VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, dtype VARCHAR(255) NOT NULL, INDEX IDX_9B7EF25ED09FCB3 (soul), PRIMARY KEY(persistence_object_identifier))");
		$this->addSql("CREATE TABLE famelo_soul_domain_model_abstractsoulpiece_children_join (soul_abstractsoulpiece VARCHAR(40) NOT NULL, child_inverse_id VARCHAR(40) NOT NULL, INDEX IDX_CBF2A44A2AF78C4B (soul_abstractsoulpiece), INDEX IDX_CBF2A44A60D73502 (child_inverse_id), PRIMARY KEY(soul_abstractsoulpiece, child_inverse_id))");
		$this->addSql("CREATE TABLE famelo_soul_domain_model_emailverificationpiece (persistence_object_identifier VARCHAR(40) NOT NULL, PRIMARY KEY(persistence_object_identifier))");
		$this->addSql("CREATE TABLE famelo_soul_domain_model_soul (persistence_object_identifier VARCHAR(40) NOT NULL, rootpiece VARCHAR(40) DEFAULT NULL, party VARCHAR(40) DEFAULT NULL, vote VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_288DD06D5E32C20F (rootpiece), UNIQUE INDEX UNIQ_288DD06D89954EE0 (party), PRIMARY KEY(persistence_object_identifier))");
		$this->addSql("ALTER TABLE famelo_soul_domain_model_abstractsoulpiece ADD CONSTRAINT FK_9B7EF25ED09FCB3 FOREIGN KEY (soul) REFERENCES famelo_soul_domain_model_soul (persistence_object_identifier)");
		$this->addSql("ALTER TABLE famelo_soul_domain_model_abstractsoulpiece_children_join ADD CONSTRAINT FK_CBF2A44A2AF78C4B FOREIGN KEY (soul_abstractsoulpiece) REFERENCES famelo_soul_domain_model_abstractsoulpiece (persistence_object_identifier)");
		$this->addSql("ALTER TABLE famelo_soul_domain_model_abstractsoulpiece_children_join ADD CONSTRAINT FK_CBF2A44A60D73502 FOREIGN KEY (child_inverse_id) REFERENCES famelo_soul_domain_model_abstractsoulpiece (persistence_object_identifier)");
		$this->addSql("ALTER TABLE famelo_soul_domain_model_emailverificationpiece ADD CONSTRAINT FK_8A7EB68147A46B0A FOREIGN KEY (persistence_object_identifier) REFERENCES famelo_soul_domain_model_abstractsoulpiece (persistence_object_identifier) ON DELETE CASCADE");
		$this->addSql("ALTER TABLE famelo_soul_domain_model_soul ADD CONSTRAINT FK_288DD06D5E32C20F FOREIGN KEY (rootpiece) REFERENCES famelo_soul_domain_model_abstractsoulpiece (persistence_object_identifier)");
		$this->addSql("ALTER TABLE famelo_soul_domain_model_soul ADD CONSTRAINT FK_288DD06D89954EE0 FOREIGN KEY (party) REFERENCES typo3_party_domain_model_abstractparty (persistence_object_identifier)");
	}

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function down(Schema $schema) {
		// this down() migration is autogenerated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

		$this->addSql("ALTER TABLE famelo_soul_domain_model_abstractsoulpiece_children_join DROP FOREIGN KEY FK_CBF2A44A2AF78C4B");
		$this->addSql("ALTER TABLE famelo_soul_domain_model_abstractsoulpiece_children_join DROP FOREIGN KEY FK_CBF2A44A60D73502");
		$this->addSql("ALTER TABLE famelo_soul_domain_model_emailverificationpiece DROP FOREIGN KEY FK_8A7EB68147A46B0A");
		$this->addSql("ALTER TABLE famelo_soul_domain_model_soul DROP FOREIGN KEY FK_288DD06D5E32C20F");
		$this->addSql("ALTER TABLE famelo_soul_domain_model_abstractsoulpiece DROP FOREIGN KEY FK_9B7EF25ED09FCB3");
		$this->addSql("DROP TABLE famelo_soul_domain_model_abstractsoulpiece");
		$this->addSql("DROP TABLE famelo_soul_domain_model_abstractsoulpiece_children_join");
		$this->addSql("DROP TABLE famelo_soul_domain_model_emailverificationpiece");
		$this->addSql("DROP TABLE famelo_soul_domain_model_soul");
	}
}