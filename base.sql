Create database ecole_sys;

Use ecole_sys;

Create table user(
    id INT PRIMARY KEY auto_increment,
    user VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    roleUser ENUM('admin', 'prof', 'etudiant') NOT NULL
);

create table prof(
    id INT PRIMARY KEY auto_increment,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    genre CHAR(1) not NULL,
    email VARCHAR(50) NOT NULL,
    adresse VARCHAR(50) NOT NULL,
    user_id INT,
    CONSTRAINT fk_user_prof FOREIGN KEY (user_id) REFERENCES user(id)

);

create table etudiant(
    id INT PRIMARY KEY auto_increment,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    genre CHAR(1) not NULL,
    user_id INT,
    CONSTRAINT fk_user_etudiant FOREIGN KEY (user_id) REFERENCES user(id)
);

create table salle(
    id INT PRIMARY KEY auto_increment,
    nomSalle VARCHAR(50) NOT NULL
);

create table cours(
    id INT PRIMARY KEY auto_increment,
    libelle VARCHAR(50) NOT NULL,
    dateDebut DATE NOT NULL,
    dateFin DATE NOT NULL,
    idProf INT,
    idSalle INT,
    constraint fkprof foreign key(idProf) references prof(id),
    constraint fksalle foreign key(idSalle) references salle(id)
);

create table participation(
    id INT PRIMARY KEY auto_increment,
    idEtudiant INT,
    idCours INT,
    constraint fkEtudiant foreign key(idEtudiant) references etudiant(id),
    constraint fkCours foreign key(idCours) references cours(id),
    UNIQUE(idEtudiant, idCours)
);

INSERT INTO user (user, password, roleUser) VALUES
('root', 'root', 'admin'),
('predator', 'ismael', 'prof'),
('Abdoul Karim', 'abdoulkarim', 'etudiant');

INSERT INTO prof (nom, prenom, genre, email, adresse, user_id) VALUES
('Ismael', 'Adamou', 'M', 'ismo@gmail.com', '123 Rue Principale', 2);

INSERT INTO etudiant (nom, prenom, genre, user_id) VALUES
('Ismael', 'Adamou', 'M', 3);

INSERT INTO salle (nomSalle) VALUES ('Salle 101');

INSERT INTO cours (libelle, dateDebut, dateFin, idProf, idSalle) VALUES
('Mathématiques', '2024-11-10', '2024-12-10', 1, 1);

INSERT INTO participation (idEtudiant, idCours) VALUES (1, 1);
