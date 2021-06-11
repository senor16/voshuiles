CREATE TABLE user (
  id INTEGER NOT NULL AUTO_INCREMENT,
  nom VARCHAR(30),
  prenom VARCHAR(20),
  tel INTEGER,
  genre ENUM('M','F'),
  ville VARCHAR(30),
  created_at DATETIME DEFAULT NOW(),
  date_naiss DATE,
  password VARCHAR(255),
  email VARCHAR(255),
  role ENUM('CLIENT','PRODUCTEUR'),
  remember VARCHAR(255),
  CONSTRAINT
    pk_client PRIMARY KEY(id),
  CONSTRAINT
    un_email UNIQUE (email),
  CONSTRAINT
    un_tel UNIQUE (tel)
);