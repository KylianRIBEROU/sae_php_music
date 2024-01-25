

CREATE TABLE utilisateur (
  idU        INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  nomU       VARCHAR(100) UNIQUE,
  motdepasse VARCHAR(200),
  admin      INTEGER
);


CREATE TABLE album (
  idAlbum   INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  titreAlbum VARCHAR(100),
  imageAlbum varchar(200),
  anneeSortie INTEGER,
  idA       INTEGER NOT NULL,
  FOREIGN KEY (idA) REFERENCES artiste (idA)
);

CREATE TABLE artiste (
  idA  INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  nomA VARCHAR(100) UNIQUE
);

CREATE TABLE detient (
  idAlbum INTEGER NOT NULL,
  idG INTEGER NOT NULL,
  PRIMARY KEY (idAlbum, idG),
  FOREIGN KEY (idAlbum) REFERENCES album (idAlbum),
  FOREIGN KEY (idG) REFERENCES genre (idG)
);

CREATE TABLE favAlbum (
  idU     INTEGER NOT NULL,
  idAlbum INTEGER NOT NULL,
  PRIMARY KEY (idU, idAlbum),
  FOREIGN KEY (idU) REFERENCES utilisateur (idU),
  FOREIGN KEY (idAlbum) REFERENCES album (idAlbum)
);

CREATE TABLE favTitre (
  idU INTEGER NOT NULL,
  idT INTEGER NOT NULL,
  PRIMARY KEY (idU, idT),
  FOREIGN KEY (idU) REFERENCES utilisateur (idU),
  FOREIGN KEY (idT) REFERENCES titre (idT)
);

CREATE TABLE genre (
  idG  INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  nomG VARCHAR(100) UNIQUE
);

CREATE TABLE image (
  idImage   INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  lienImage VARCHAR(42) NOT NULL,
  pos       VARCHAR(42),
  idA       INTEGER NOT NULL,
  FOREIGN KEY (idA) REFERENCES artiste (idA)
);






CREATE TABLE note (
  idU     INTEGER NOT NULL,
  idAlbum INTEGER NOT NULL,
  note    INTEGER NOT NULL,
  PRIMARY KEY (idU, idAlbum),
  FOREIGN KEY (idU) REFERENCES utilisateur (idU),
  FOREIGN KEY (idAlbum) REFERENCES album (idAlbum)
);

CREATE TABLE playlist (
  idP  INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  nomP VARCHAR(100),
  idU INTEGER NOT NULL,
  FOREIGN KEY (idU) REFERENCES utilisateur (idU)
);

CREATE TABLE titre (
  idT         INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  labelT      VARCHAR(100),
  anneeSortie INTEGER,
  duree       INTEGER,
  idA         INTEGER NOT NULL,
  idAlbum 	  INTEGER,
  FOREIGN KEY (idAlbum) REFERENCES album (idAlbum)
  FOREIGN KEY (idA) REFERENCES artiste (idA)
);


CREATE TABLE appartient (
  idP INTEGER NOT NULL,
  idT INTEGER NOT NULL,
  PRIMARY KEY (idP, idT),
  FOREIGN KEY (idP) REFERENCES playlist(idP),
  FOREIGN KEY (idT) REFERENCES titre (idT)
);