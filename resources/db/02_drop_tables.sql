-- Suppression des contraintes avant de supprimer les tables
PRAGMA foreign_keys=off;

-- Suppression des tables dans l'ordre inverse de leur création
DROP TABLE IF EXISTS appartient;
DROP TABLE IF EXISTS titre;
DROP TABLE IF EXISTS playlist;
DROP TABLE IF EXISTS note;
DROP TABLE IF EXISTS genre;
DROP TABLE IF EXISTS favTitre;
DROP TABLE IF EXISTS favAlbum;
DROP TABLE IF EXISTS detient;
DROP TABLE IF EXISTS artiste;
DROP TABLE IF EXISTS album;
DROP TABLE IF EXISTS utilisateur;

-- Réactivation des contraintes après la suppression des tables
PRAGMA foreign_keys=on;
