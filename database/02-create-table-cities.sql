-- Création de la table `cities`.
CREATE TABLE cities (
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(100) NOT NULL,
	country VARCHAR(100) NOT NULL,
	capital VARCHAR(100) NOT NULL,
	PRIMARY KEY (id),
	UNIQUE name_uniq (name)
) ENGINE = InnoDB;
