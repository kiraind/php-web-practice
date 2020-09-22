CREATE TABLE Users (
    Id             INT PRIMARY KEY AUTO_INCREMENT,
    Username       VARCHAR(64) NOT NULL UNIQUE,
    BcryptPassword CHAR(60) NOT NULL
);

CREATE TABLE Links (
    UserId    INT NOT NULL,
    Link      VARCHAR(512) NOT NULL,
    Shortened CHAR(7) PRIMARY KEY,
    Clicks    INT NOT NULL DEFAULT 0,
    Created   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    foreign key (UserId) references Users(Id)
);

CREATE TABLE Tokens (
    Token  VARCHAR(32) PRIMARY KEY,
    UserId INT NOT NULL,

    foreign key (UserId) references Users(Id)
);