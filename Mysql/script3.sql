/*ALTER TABLE ATTRIBUTION DROP FOREIGN KEY fk1_Attribution;

ALTER TABLE ATTRIBUTION DROP FOREIGN KEY fk2_Attribution;*/

ALTER TABLE ATTRIBUTION
add constraint fk1_Attribution foreign key(idEtab) 
references Etablissement(id);

ALTER TABLE ATTRIBUTION
add constraint fk2_Attribution foreign key(idGroupe) 
references Groupe(id);