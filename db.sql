CREATE OR REPLACE FUNCTION compare_date_now()
RETURNS BOOLEAN AS $$
DECLARE
    date_now DATE;
    last_date DATE;
    cur CURSOR FOR SELECT last_value(date_jour) over (order by id desc) as last_date from jour limit 1;
    re RECORD;
BEGIN 
    OPEN cur;
    FETCH NEXT FROM CUR INTO re;
    date_now := NOW();
    last_date := re.last_date;
    IF last_date IS NOT NULL THEN
        IF date_now > last_date THEN
            RETURN TRUE;
        ELSE
            RETURN FALSE;
        END IF;
    ELSE
        RETURN TRUE;
    END IF;
    
END;
$$
LANGUAGE PLPGSQL;
    
select jour.id, to_char(date_jour, 'DD-MM-YYYY'), to_char(presence.arrive, 'HH24:MI') as arrive, to_char(presence.depart, 'HH24:MI') as depart, utilisateur.nom, utilisateur.prenom, utilisateur.email from jour left join presence on jour.id = presence.id_jour left join utilisateur on utilisateur.id = presence.id_user where utilisateur.role = 'user'; 