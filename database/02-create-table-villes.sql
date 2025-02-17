-- Création de la table `villes`.
CREATE TABLE villes (
	id INT NOT NULL AUTO_INCREMENT,
	nom VARCHAR(100) NOT NULL,
	pays VARCHAR(100) NOT NULL,
	capitale VARCHAR(100) NOT NULL,
	PRIMARY KEY (id),
	UNIQUE nom_unique (nom)
) ENGINE = InnoDB;
