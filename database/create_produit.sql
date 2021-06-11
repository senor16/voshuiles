CREATE TABLE produit(
  id INTEGER NOT NULL AUTO_INCREMENT,
  designation VARCHAR(20) NOT NULL,
  prix INTEGER NOT NULL,
  qualite VARCHAR(20),
  product INTEGER NOT NULL,
  quantite INTEGER,
  image VARCHAR(255),
  created_at DATETIME DEFAULT NOW(),
  updated_at DATETIME,
  souvenir VARCHAR(255),
  CONSTRAINT
  	pk_produit PRIMARY KEY(id),
  CONSTRAINT
  	fk_prod_product FOREIGN KEY(product)
  		REFERENCES producteur(id)
);