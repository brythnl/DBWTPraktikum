DELIMITER //

CREATE PROCEDURE Anmeldungszahler(IN anmeldung_id INTEGER )
BEGIN
    UPDATE benutzer 
    SET anzahlanmeldungen = anzahlanmeldungen +1 
    WHERE id = anmeldung_id;
END //

DELIMITER ;


