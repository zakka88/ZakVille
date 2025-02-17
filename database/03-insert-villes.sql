-- Insertion de 10 villes
INSERT INTO villes
	(nom, pays, capitale) VALUES
	('Bangkok', 'Thaïlande', 'Bangkok'),
	('New-York', 'États-unis', 'Washington'),
	('Sidney', 'Australie', 'Canberra'),
	('Nara', 'Japon', 'Tokyo'),
	('Toronto', 'Canada', 'Ottawa'),
	('Séoul', 'Corée du Sud', 'Séoul'),
	('Marrakesh', 'Maroc', 'Rabat'),
	('Guadelajara', 'Mexique', 'Mexico'),
	('Rio de Janeiro', 'Brésil', 'Brasília'),
	('Verona', 'Italie', 'Rome')
;

-- Pour les tests
DROP PROCECEDURE GetDemonymeDuPays;
DROP PROCECEDURE GetISOPays;

DELIMITER $$

CREATE PROCEDURE GetDemonymeDuPays( in i_pays varchar(100), out o_demonyme varchar(100) )
BEGIN

SELECT
CASE
	WHEN pays = 'Thaïlande' THEN 'Thaïlandais, Namba One'
	WHEN pays = 'États-unis' THEN 'Américain'
	WHEN pays = 'Australie' THEN 'Australien, (Kangourou)'
	WHEN pays = 'Japon' THEN 'Japonais, 日本人 (Nihonjin)'
	WHEN pays = 'Canada' THEN 'Canadiens'
	WHEN pays = 'Corée du Sud' THEN 'Coréen, 한국인 (Hangugin)'
	WHEN pays = 'Maroc' THEN 'Marocain, راجل (Rajel)'
	WHEN pays = 'Mexique' THEN 'Méxicain, (Narco)'
	WHEN pays = 'Brésil' THEN 'Brésilien, (Brasileiro)'
	WHEN pays = 'Italie' THEN 'Italien, (Mafiosi)'
	ELSE 'Humain'
END INTO o_demonyme
FROM villes
WHERE pays = i_pays;

END $$

CREATE PROCEDURE GetISOPays( in i_pays varchar(100), out o_flag varchar(100) )
BEGIN

SELECT
CASE
	WHEN pays = 'Thaïlande' THEN 'TH'
	WHEN pays = 'États-unis' THEN 'US'
	WHEN pays = 'Australie' THEN 'AU'
	WHEN pays = 'Japon' THEN 'JP'
	WHEN pays = 'Canada' THEN 'CA'
	WHEN pays = 'Corée du Sud' THEN 'KR'
	WHEN pays = 'Maroc' THEN 'MA'
	WHEN pays = 'Mexique' THEN 'MX'
	WHEN pays = 'Brésil' THEN 'BR'
	WHEN pays = 'Italie' THEN 'IT'
	ELSE ''
END INTO o_flag
FROM villes
WHERE pays = i_pays;

END $$

DELIMITER ;
