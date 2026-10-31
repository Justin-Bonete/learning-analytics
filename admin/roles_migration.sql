UPDATE admin
SET is_superadmin = CASE
    WHEN LOWER(TRIM(username)) = 'gryanlyle.navarro@deped.gov.ph' THEN 1
    ELSE 0
END
WHERE is_superadmin = 1
   OR LOWER(TRIM(username)) = 'gryanlyle.navarro@deped.gov.ph';