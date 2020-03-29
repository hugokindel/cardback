-- On efface la base de donnée si elle existe déjà
DROP DATABASE IF EXISTS cardback;

-- On la crée
CREATE DATABASE IF NOT EXISTS cardback;

-- On l'utilise
USE cardback;

-- On efface les tables si elles existe déjà
DROP TABLE IF EXISTS cards, packCards, packs, userPacks, users;

-- On crée la table "users"
CREATE TABLE users(
    id INT NOT NULL,
    email VARCHAR(254) NOT NULL,
    password CHAR(32) NOT NULL,
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    creationDate DATE NOT NULL,

    PRIMARY KEY(id),
    UNIQUE KEY(email)
);

-- On crée la table "packs"
CREATE TABLE packs(
    id INT NOT NULL,
    name VARCHAR(254) NOT NULL,
    creationDate DATE NOT NULL,

    PRIMARY KEY(id),
    UNIQUE KEY(name)
);

-- On crée la table "cards"
CREATE TABLE cards(
    id INT NOT NULL,
    question VARCHAR(254) NOT NULL,
    answer VARCHAR(254) NOT NULL,
    creationDate DATE NOT NULL,

    PRIMARY KEY(id)
);

-- On crée la table "userPacks" (lien utilisateur-paquet)
CREATE TABLE userPacks (
    userId INT NOT NULL,
    packId INT NOT NULL,

    FOREIGN KEY(userId) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY(packId) REFERENCES packs(id) ON DELETE CASCADE,

    PRIMARY KEY (userId, packId)
);

-- On crée la table "packCards" (lien paquet-carte)
CREATE TABLE packCards (
    packId INT NOT NULL,
    cardId INT NOT NULL,

    FOREIGN KEY(packId) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY(cardId) REFERENCES packs(id) ON DELETE CASCADE,

    PRIMARY KEY (packId, cardId)
);