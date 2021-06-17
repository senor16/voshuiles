CREATE TABLE product(
  id INTEGER NOT NULL AUTO_INCREMENT,
  designation VARCHAR(30) NOT NULL,
  prix INTEGER NOT NULL,
  qualite VARCHAR(20),
  producteur INTEGER NOT NULL,
  quantite INTEGER,
  description VARCHAR(255),
  image VARCHAR(255),
  created_at DATETIME DEFAULT NOW(),
  updated_at DATETIME ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT
  	pk_produit PRIMARY KEY(id),
  CONSTRAINT
  	fk_prod_user FOREIGN KEY(producteur)
  		REFERENCES user(id)
);