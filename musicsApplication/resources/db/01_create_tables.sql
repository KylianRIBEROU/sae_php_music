CREATE TABLE album (
  PRIMARY KEY (idAlbum),
  idAlbum    integer auto-increment NOT NULL,
  nomAlbum   varchar(200),
  imageAlbum varchar(200),
  idA        integer auto-increment NOT NULL,
  idT        integer auto-increment NULL
);

CREATE TABLE appartient (
  PRIMARY KEY (idP, idT),
  idP integer auto-increment NOT NULL,
  idT integer auto-increment NOT NULL
);

CREATE TABLE artiste (
  PRIMARY KEY (idA),
  idA  integer auto-increment NOT NULL,
  nomA varchar(100) unique
);

CREATE TABLE detient (
  PRIMARY KEY (idT, idG),
  idT integer auto-increment NOT NULL,
  idG integer auto-increment NOT NULL
);

CREATE TABLE favAlbum (
  PRIMARY KEY (idU, idAlbum),
  idU     integer auto-increment NOT NULL,
  idAlbum integer auto-increment NOT NULL
);

CREATE TABLE favTitre (
  PRIMARY KEY (idU, idT),
  idU integer auto-increment NOT NULL,
  idT integer auto-increment NOT NULL
);

CREATE TABLE genre (
  PRIMARY KEY (idG),
  idG  integer auto-increment NOT NULL,
  nomG unique varchar(100)
);

CREATE TABLE image (
  PRIMARY KEY (idImage),
  idImage   integer auto-increment NOT NULL,
  lienImage VARCHAR(42) NOT NULL,
  pos       VARCHAR(42),
  idA       integer auto-increment NOT NULL
);

CREATE TABLE note (
  PRIMARY KEY (idU, idAlbum),
  idU     integer auto-increment NOT NULL,
  idAlbum integer auto-increment NOT NULL,
  note    integer NOT NULL
);

CREATE TABLE playlist (
  PRIMARY KEY (idP),
  idP  integer auto-increment NOT NULL,
  nomP varchar 100
);

CREATE TABLE titre (
  PRIMARY KEY (idT),
  idT         integer auto-increment NOT NULL,
  labelT      varchar(100),
  anneeSortie integer,
  duree       integer,
  idA         integer auto-increment NOT NULL
);

CREATE TABLE utilisateur (
  PRIMARY KEY (idU),
  idU        integer auto-increment NOT NULL,
  nomU       unique varchar(100),
  motdepasse varchar(200),
  admin      integer
);

ALTER TABLE album ADD FOREIGN KEY (idT) REFERENCES titre (idT);
ALTER TABLE album ADD FOREIGN KEY (idA) REFERENCES artiste (idA);

ALTER TABLE appartient ADD FOREIGN KEY (idT) REFERENCES titre (idT);
ALTER TABLE appartient ADD FOREIGN KEY (idP) REFERENCES playlist (idP);

ALTER TABLE detient ADD FOREIGN KEY (idG) REFERENCES genre (idG);
ALTER TABLE detient ADD FOREIGN KEY (idT) REFERENCES titre (idT);

ALTER TABLE favAlbum ADD FOREIGN KEY (idAlbum) REFERENCES album (idAlbum);
ALTER TABLE favAlbum ADD FOREIGN KEY (idU) REFERENCES utilisateur (idU);

ALTER TABLE favTitre ADD FOREIGN KEY (idT) REFERENCES titre (idT);
ALTER TABLE favTitre ADD FOREIGN KEY (idU) REFERENCES utilisateur (idU);

ALTER TABLE image ADD FOREIGN KEY (idA) REFERENCES artiste (idA);

ALTER TABLE note ADD FOREIGN KEY (idAlbum) REFERENCES album (idAlbum);
ALTER TABLE note ADD FOREIGN KEY (idU) REFERENCES utilisateur (idU);

ALTER TABLE titre ADD FOREIGN KEY (idA) REFERENCES artiste (idA);

