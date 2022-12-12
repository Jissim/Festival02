DELETE FROM Etablissement;
DELETE FROM Groupe;
DELETE FROM Attribution;
-- Certains etablissements sont fictifs
insert into Etablissement values ('00000001', 'College Montaigu', '1 rue du college', '54180', 'Heillecourt', '0355668945', null,1,'M.','Dupont','Alain',20);
insert into Etablissement values ('00000002', 'College Louis Armand', '33 avenue de Barbois', '54000', 'Nancy', '0399561459', null, 1,'Mme','Lefort','Anne',58);  
insert into Etablissement values ('00000003', 'College Albert Camus', '21 boulevard Joffre', '54000', 'Nancy', '0399117474', null, 1,'M.','Durand','Pierre',60);   
insert into Etablissement values ('00000004', 'Centre de rencontres regional', '32 rue de Vandoeuvre', '54600', 'Villiers les Nancy', '0399000000', null, 0, 'M.','Guenroc','Guy',200);

-- Certains groupes sont incomplètement renseignes
INSERT INTO Groupe (id, nom, nombrepersonnes, nompays, hebergement)values ('L001','Ligue Lorraine escrime',40,'France','O');
INSERT INTO Groupe (id, nom, nombrepersonnes, nompays, hebergement)values ('L002','Ligue Lorraine football',60,'France','O');
INSERT INTO Groupe (id, nom, nombrepersonnes, nompays, hebergement)values ('L003','Ligue Lorraine basketball',32,'France','O');
INSERT INTO Groupe (id, nom, nombrepersonnes, nompays, hebergement)values ('L004','Ligue Lorraine babyfoot',77,'France','O');
INSERT INTO Groupe (id, nom, nombrepersonnes, nompays, hebergement)values ('L005','Ligue Lorraine tennis',26,'France','O');
INSERT INTO Groupe (id, nom, nombrepersonnes, nompays, hebergement)values ('L006','Ligue Lorraine piscine',53,'France','O');
INSERT INTO Groupe (id, nom, nombrepersonnes, nompays, hebergement)values ('L007','Ligue Lorraine baseball',45,'France','O');

-- Les attributions sont fictives
insert into Attribution values ('00000001', 'L001', 11);
insert into Attribution values ('00000001', 'L002', 9);

insert into Attribution values ('00000002', 'L004', 13);
insert into Attribution values ('00000002', 'L003', 8);
insert into Attribution values ('00000003', 'L001', 3);
insert into Attribution values ('00000003', 'L006', 10);
insert into Attribution values ('00000003', 'L007', 7);

