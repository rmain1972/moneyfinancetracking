SELECT * FROM trans_T0 WHERE 
(transdate BETWEEN '2018-10-01' AND DATE_ADD('2018-10-31', INTERVAL 365 DAY)) 
ORDER BY transdate, debit, credit;

SELECT * FROM trans_T0 WHERE 
(transdate BETWEEN DATE_SUB(CURRENT_DATE(), INTERVAL 30 DAY) AND 
                   DATE_ADD('2018-10-31', INTERVAL 365 DAY)) 
ORDER BY transdate, debit, credit; 