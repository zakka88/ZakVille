-- Création de la table `users`.
--
-- Dans cette table, nous avons ajouté un champs relationnel `city_id` faisant
-- référence l'id de la table `cities`.
--
-- Les cardinalités sont :
--
-- Un utilisateur PEUT habiter dans une seule ville (0:1). Une ville PEUT être
-- habitée par plusieurs utilisateurs (1:N).
--
-- NOTE à prendre en considération: si la ville venait à disparaître de notre
-- table `cities`, le champs `city_id` de la table `users` DEVRAIT se mettre
-- automatiquement à NULL, une contrainte à configurer.
--
--
-- Table générée par JMerise et modifié avec soin.
CREATE TABLE users (
	id INT NOT NULL AUTO_INCREMENT,
	firstname VARCHAR(50) NOT NULL,
	username VARCHAR(50) NOT NULL,
	password VARCHAR(255) NOT NULL,
	city_id INT,
	CONSTRAINT user_username_AK UNIQUE (username),
	CONSTRAINT user_id_PK PRIMARY KEY (id),
	CONSTRAINT users_cities_FK FOREIGN KEY (city_id) REFERENCES cities(id)
) ENGINE = InnoDB;
