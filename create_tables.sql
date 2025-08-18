-- Script de création des tables pour le système de gestion de présence

-- Création de la table Admin
CREATE TABLE "Admin" (
    "idAdmin" SERIAL PRIMARY KEY,
    "nom" VARCHAR(50) NOT NULL UNIQUE,
    "mot_de_passe" VARCHAR(255) NOT NULL
);

-- Création de la table Utilisateur
CREATE TABLE "Utilisateur" (
    "idUtilisateur" SERIAL PRIMARY KEY,
    "nom" VARCHAR(50) NOT NULL,
    "prenom" VARCHAR(50) NOT NULL,
    "poste" VARCHAR(100) NOT NULL,
    "id_biometrique" VARCHAR(100) UNIQUE
);

-- Création de la table Presence
CREATE TABLE "Presence" (
    "idPresence" SERIAL PRIMARY KEY,
    "idUtilisateur" INTEGER REFERENCES "Utilisateur"("idUtilisateur"),
    "date" DATE NOT NULL,
    "heure" TIME NOT NULL,
    "type" VARCHAR(20) DEFAULT 'entree' -- 'entree' ou 'sortie'
);

-- Insertion d'un administrateur par défaut (mot de passe : admin123)
INSERT INTO "Admin" ("nom", "mot_de_passe") VALUES ('admin', 'admin123');

-- Insertion de quelques utilisateurs d'exemple
INSERT INTO "Utilisateur" ("nom", "prenom", "poste", "id_biometrique") VALUES 
('Dupont', 'Jean', 'Développeur', 'BIO001'),
('Martin', 'Marie', 'Designer', 'BIO002'),
('Bernard', 'Pierre', 'Manager', 'BIO003');

-- Création d'index pour améliorer les performances
CREATE INDEX idx_presence_date ON "Presence"("date");
CREATE INDEX idx_presence_idutilisateur ON "Presence"("idUtilisateur");
CREATE INDEX idx_utilisateur_idbiometrique ON "Utilisateur"("id_biometrique");
