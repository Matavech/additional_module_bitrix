CREATE TABLE IF NOT EXISTS b_related_related_product (
    ID INT(11) AUTO_INCREMENT PRIMARY KEY,
    DEAL_ID INT(11) NOT NULL,
    TITLE VARCHAR(255) NOT NULL,
    PRICE DECIMAL(10,2) NOT NULL,
    CREATED_AT DATETIME DEFAULT CURRENT_TIMESTAMP
);
CREATE INDEX idx_deal_id ON b_related_related_product (DEAL_ID);
CREATE INDEX idx_price ON b_related_related_product (PRICE);
CREATE INDEX idx_title ON b_related_related_product (TITLE);