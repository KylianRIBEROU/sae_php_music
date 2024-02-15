CREATE TABLE IF NOT EXISTS utilisateur (
    idU        INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    nomU       VARCHAR(100) UNIQUE,
    motdepasse VARCHAR(200),
    admin      INTEGER
);

CREATE TABLE IF NOT EXISTS album (
    idAlbum     INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    titreAlbum  VARCHAR(100),
    imageAlbum  VARCHAR(200),
    anneeSortie  INTEGER,
    idA          INTEGER NOT NULL,
    FOREIGN KEY (idA) REFERENCES artiste (idA)
);

CREATE TABLE IF NOT EXISTS artiste (
    idA  INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    nomA VARCHAR(100) UNIQUE,
    imageA VARCHAR(200)
);

CREATE TABLE IF NOT EXISTS detient (
    idAlbum INTEGER NOT NULL,
    idG INTEGER NOT NULL,
    PRIMARY KEY (idAlbum, idG),
    FOREIGN KEY (idAlbum) REFERENCES titre (idAlbum),
    FOREIGN KEY (idG) REFERENCES genre (idG)
);

CREATE TABLE IF NOT EXISTS favAlbum (
    idU     INTEGER NOT NULL,
    idAlbum INTEGER NOT NULL,
    PRIMARY KEY (idU, idAlbum),
    FOREIGN KEY (idU) REFERENCES utilisateur (idU),
    FOREIGN KEY (idAlbum) REFERENCES album (idAlbum)
);

CREATE TABLE IF NOT EXISTS favTitre (
    idU INTEGER NOT NULL,
    idT INTEGER NOT NULL,
    PRIMARY KEY (idU, idT),
    FOREIGN KEY (idU) REFERENCES utilisateur (idU),
    FOREIGN KEY (idT) REFERENCES titre (idT)
);

CREATE TABLE IF NOT EXISTS genre (
    idG  INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    nomG VARCHAR(100) UNIQUE
);

CREATE TABLE IF NOT EXISTS note (
    idU     INTEGER NOT NULL,
    idAlbum INTEGER NOT NULL,
    note    INTEGER NOT NULL,
    PRIMARY KEY (idU, idAlbum),
    FOREIGN KEY (idU) REFERENCES utilisateur (idU),
    FOREIGN KEY (idAlbum) REFERENCES album (idAlbum)
);

CREATE TABLE IF NOT EXISTS playlist (
    idP  INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    nomP VARCHAR(100),
    idU INTEGER NOT NULL,
    FOREIGN KEY (idU) REFERENCES utilisateur (idU)
);

CREATE TABLE IF NOT EXISTS titre (
    idT         INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    labelT      VARCHAR(100),
    anneeSortie INTEGER,
    duree       VARCHAR(10),
    url         VARCHAR(200),
    idAlbum     INTEGER NOT NULL,
    idA         INTEGER NOT NULL,
    FOREIGN KEY (idAlbum) REFERENCES album (idAlbum),
    FOREIGN KEY (idA) REFERENCES artiste (idA)
);

CREATE TABLE IF NOT EXISTS appartient (
    idP INTEGER NOT NULL,
    idT INTEGER NOT NULL,
    PRIMARY KEY (idP, idT),
    FOREIGN KEY (idP) REFERENCES playlist(idP),
    FOREIGN KEY (idT) REFERENCES titre (idT)
);
