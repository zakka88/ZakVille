-- Table générée par JMerise et modifiée avec soin.
-- Création de la table `cities`.
CREATE TABLE cities (
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(100) NOT NULL,
	country VARCHAR(100) NOT NULL,
	capital VARCHAR(100) NOT NULL,
	CONSTRAINT city_id_PK PRIMARY KEY (id),
	CONSTRAINT city_name_AK UNIQUE (name)
) ENGINE = InnoDB;
