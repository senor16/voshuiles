CREATE TABLE commande
(
    id             INTEGER     NOT NULL AUTO_INCREMENT,
    user           INTEGER     NOT NULL,
    product        INTEGER     NOT NULL,
    quantite       INTEGER     NOT NULL,
    date_c         DATETIME DEFAULT NOW(),
    lieu_livraison VARCHAR(30) NOT NULL,
    CONSTRAINT
        pk_commande PRIMARY KEY (id),
    CONSTRAINT
        fk_com_user FOREIGN KEY (user)
        REFERENCES user (id),
    CONSTRAINT
        fk_com_product FOREIGN KEY (product)
        REFERENCES product (id)
);