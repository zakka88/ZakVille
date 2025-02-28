-- Insertion de 10 villes
INSERT INTO cities
	(name, country, capital) VALUES
	('Bangkok', 'Thaïlande', 'Bangkok'),
	('New-York', 'États-unis', 'Washington'),
	('Sidney', 'Australie', 'Canberra'),
	('Nara', 'Japon', 'Tokyo'),
	('Toronto', 'Canada', 'Ottawa'),
	('Séoul', 'Corée du Sud', 'Séoul'),
	('Marrakesh', 'Maroc', 'Rabat'),
	('Pékin', 'Chine', 'Pékin'),
	('Rio de Janeiro', 'Brésil', 'Brasília'),
	('Verona', 'Italie', 'Rome')
;

-- Pour les tests
DROP PROCEDURE IF EXISTS GetCountryDemonym;
DROP PROCEDURE IF EXISTS GetCountryISO;

DELIMITER $$

CREATE PROCEDURE GetCountryDemonym( in i_country varchar(100), out o_demonym varchar(100) )
BEGIN

SELECT
CASE
	WHEN country = 'Thaïlande'    THEN 'Thaïlandais, Namba One'
	WHEN country = 'États-unis'   THEN 'Américain'
	WHEN country = 'Australie'    THEN 'Australien, (Kangourou)'
	WHEN country = 'Japon'        THEN 'Japonais, 日本人 (Nihonjin)'
	WHEN country = 'Canada'       THEN 'Canadien'
	WHEN country = 'Corée du Sud' THEN 'Coréen, 한국인 (Hangugin)'
	WHEN country = 'Maroc'        THEN 'Marocain, راجل (Rajel)'
	WHEN country = 'Chine'        THEN 'Chinois'
	WHEN country = 'Brésil'       THEN 'Brésilien, (Brasileiro)'
	WHEN country = 'Italie'       THEN 'Italien, (Mafiosi)'
	ELSE CONCAT('Habitant de ', country)
END INTO o_demonym
FROM cities
WHERE country = i_country
LIMIT 1;

END $$

CREATE PROCEDURE GetCountryISO( in i_country varchar(100), out o_flag varchar(100) )
BEGIN

SELECT
CASE
	WHEN country = 'Thaïlande'    THEN 'TH'
	WHEN country = 'États-unis'   THEN 'US'
	WHEN country = 'Australie'    THEN 'AU'
	WHEN country = 'Japon'        THEN 'JP'
	WHEN country = 'Canada'       THEN 'CA'
	WHEN country = 'Corée du Sud' THEN 'KR'
	WHEN country = 'Maroc'        THEN 'MA'
	WHEN country = 'Chine'        THEN 'CN'
	WHEN country = 'Brésil'       THEN 'BR'
	WHEN country = 'Italie'       THEN 'IT'
	ELSE ''
END INTO o_flag
FROM cities
WHERE country = i_country
LIMIT 1;

END $$

DELIMITER ;
