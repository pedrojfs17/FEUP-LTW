PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS pet;
DROP TABLE IF EXISTS pet_age;
DROP TABLE IF EXISTS pet_gender;
DROP TABLE IF EXISTS pet_states;
DROP TABLE IF EXISTS pet_image;
DROP TABLE IF EXISTS color;
DROP TABLE IF EXISTS pet_type;
DROP TABLE IF EXISTS question;
DROP TABLE IF EXISTS reply;
DROP TABLE IF EXISTS pet_proposal;
DROP TABLE IF EXISTS proposal_decision;
DROP TABLE IF EXISTS favorite_pet;
DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS notification;

CREATE TABLE user (
  username VARCHAR PRIMARY KEY,
  password VARCHAR NOT NULL,
  shelter BOOLEAN NOT NULL CHECK (shelter = 0 OR shelter = 1),
  collaborator VARCHAR REFERENCES user ON DELETE SET NULL ON UPDATE CASCADE,
  fullname VARCHAR NOT NULL DEFAULT 'anonymous',
  age INTEGER NOT NULL DEFAULT 99,
  email VARCHAR NOT NULL DEFAULT 'example@email.com',
  mobile VARCHAR NOT NULL DEFAULT '+351919999999',
  location VARCHAR NOT NULL DEFAULT 'unknown',
  profile_image VARCHAR NOT NULL DEFAULT 'user',
  bio VARCHAR DEFAULT 'Your bio'
);

CREATE TABLE pet (
  pet_id INTEGER PRIMARY KEY,
  pet_type INTEGER REFERENCES pet_type,
  pet_name VARCHAR NOT NULL DEFAULT 'No name',
  pet_species VARCHAR NOT NULL,
  pet_age INTEGER REFERENCES pet_age,
  pet_gender INTEGER REFERENCES pet_gender,
  pet_size VARCHAR NOT NULL,
  pet_weight INTEGER NOT NULL,
  pet_color INTEGER REFERENCES color,
  pet_location VARCHAR NOT NULL,
  username INTEGER NOT NULL REFERENCES user ON DELETE CASCADE ON UPDATE CASCADE,
  pet_state INTEGER REFERENCES pet_states ON DELETE SET NULL
);

CREATE TABLE color (
  color_id INTEGER PRIMARY KEY,
  name VARCHAR NOT NULL
);

CREATE TABLE pet_type (
  type_id INTEGER PRIMARY KEY,
  name VARCHAR NOT NULL
);

CREATE TABLE pet_age (
  age_id INTEGER PRIMARY KEY,
  name VARCHAR NOT NULL,
  description VARCHAR NOT NULL
);

CREATE TABLE pet_gender (
  gender_id INTEGER PRIMARY KEY,
  name VARCHAR NOT NULL
);

CREATE TABLE pet_states (
  state_id INTEGER PRIMARY KEY,
  name VARCHAR NOT NULL,
  description VARCHAR NOT NULL
);

CREATE TABLE pet_image (
  pet_image_id INTEGER PRIMARY KEY,
  pet_image_name VARCHAR NOT NULL,
  pet_id INTEGER NOT NULL REFERENCES pet ON DELETE CASCADE
);

CREATE TABLE question (
  question_id INTEGER PRIMARY KEY,
  pet_id INTEGER NOT NULL REFERENCES pet ON DELETE CASCADE, --pet in question
  username VARCHAR NOT NULL REFERENCES user ON DELETE CASCADE ON UPDATE CASCADE, --user who asked
  published INTEGER, -- date when question was published in epoch format
  question_text VARCHAR NOT NULL
);

CREATE TABLE reply (
  reply_id INTEGER PRIMARY KEY,
  question_id INTEGER NOT NULL REFERENCES question ON DELETE CASCADE, --question
  username VARCHAR NOT NULL REFERENCES user ON DELETE CASCADE ON UPDATE CASCADE, --user who replied
  published INTEGER, -- date when question was published in epoch format
  reply_text VARCHAR NOT NULL
);

CREATE TABLE pet_proposal (
  pet_proposal_id INTEGER PRIMARY KEY,
  pet_id INTEGER NOT NULL REFERENCES pet ON DELETE CASCADE, --proposed pet
  username VARCHAR NOT NULL REFERENCES user ON DELETE CASCADE ON UPDATE CASCADE, --user who proposed
  published INTEGER DEFAULT (cast(strftime('%s','now') as int)), -- date when proposal was published in epoch format
  decision INTEGER REFERENCES proposal_decision DEFAULT 0, -- declined, pending and accepted
  motivation VARCHER
);

CREATE TABLE proposal_decision (
  decision_id INTEGER PRIMARY KEY,
  decision_code VARCHAR UNIQUE NOT NULL
);

CREATE TABLE favorite_pet (
  favorite_pet_id INTEGER PRIMARY KEY,
  pet_id INTEGER NOT NULL REFERENCES pet ON DELETE CASCADE, --favorite pet
  username VARCHAR NOT NULL REFERENCES user ON DELETE CASCADE ON UPDATE CASCADE --user who favorited
);

CREATE TABLE notification (
  notif_id INTEGER PRIMARY KEY,
  notif_sender VARCHAR NOT NULL REFERENCES user ON DELETE CASCADE ON UPDATE CASCADE,
  notif_receiver VARCHAR NOT NULL REFERENCES user ON DELETE CASCADE ON UPDATE CASCADE,
  notif_text VARCHAR NOT NULL,
  published INTEGER,
  seen BOOLEAN NOT NULL DEFAULT 0
);

.read proposal_response_trigger.sql

INSERT INTO user(username,password,shelter,collaborator,fullname,age,email,mobile,location,profile_image) VALUES ('shelterfeup', '$2y$12$GpSw8fQX9oXWdvf/InclYOcUvCReNbQV8eB1dog7QzzcO.Dy3mFv2',1,NULL,'Shelter FEUP',3,'shelterfeup@gmail.com','+351919977333','Rua dos Bragas','shelterfeup');
INSERT INTO user(username,password,shelter,collaborator,fullname,age,email,mobile,location,profile_image) VALUES ('shelterfmup', '$2y$12$GpSw8fQX9oXWdvf/InclYOcUvCReNbQV8eB1dog7QzzcO.Dy3mFv2',1,NULL,'Shelter FMUP',4,'shelterfmup@gmail.com','+351919977332','Rua não dos Bragas','shelterfmup');
INSERT INTO user(username,password,shelter,collaborator,fullname,age,email,mobile,location,bio,profile_image) VALUES ('tony', '$2y$12$GpSw8fQX9oXWdvf/InclYOcUvCReNbQV8eB1dog7QzzcO.Dy3mFv2',0,NULL,'Tony Dill',20,'tonydill@gmail.com','+351919977331','Warsaw','Looking for cute bears','tony');
INSERT INTO user(username,password,shelter,collaborator,fullname,age,email,mobile,location,bio,profile_image) VALUES ('svetlana', '$2y$12$GpSw8fQX9oXWdvf/InclYOcUvCReNbQV8eB1dog7QzzcO.Dy3mFv2',0,'shelterfmup','Svetlana Romanovski',20,'svetlanaromanovski@gmail.com','+351919977330','Porto','Full time TikToker','svet');
INSERT INTO user(username,password,shelter,collaborator,fullname,age,email,mobile,location,bio,profile_image) VALUES ('peter', '$2y$12$GpSw8fQX9oXWdvf/InclYOcUvCReNbQV8eB1dog7QzzcO.Dy3mFv2',0,'shelterfeup','Peter George',20,'petergeorge@gmail.com','+351919977329','Porto','Gym goer','pedgo');
INSERT INTO user(username,password,shelter,collaborator,fullname,age,email,mobile,location,bio,profile_image) VALUES ('golovkin', '$2y$12$GpSw8fQX9oXWdvf/InclYOcUvCReNbQV8eB1dog7QzzcO.Dy3mFv2',0,'shelterfmup','Golovkin',20,'golovkin@gmail.com','+351919977328','Porto','Looking for a companion','goal');

INSERT INTO pet_states (name, description) VALUES ('Preparing For Adoption', 'This pet is being prepared for adoption. You will be able to adopt it at a later moment.');
INSERT INTO pet_states (name, description) VALUES ('Up For Adoption', 'This pet can be adopted right now.');
INSERT INTO pet_states (name, description) VALUES ('Adoption approved', 'This pet has been adopted, but is still with their previous owner.');
INSERT INTO pet_states (name, description) VALUES ('Adopted', 'This pet has already been adopted and is in it''s new home');

INSERT INTO pet_age (name, description) VALUES ('Baby', '0-6 months');
INSERT INTO pet_age (name, description) VALUES ('Young', '6-24 months (2 years)');
INSERT INTO pet_age (name, description) VALUES ('Adult', '2 – 8 years');
INSERT INTO pet_age (name, description) VALUES ('Senior', '> 8 years');

INSERT INTO pet_gender (name) VALUES ('Male');
INSERT INTO pet_gender (name) VALUES ('Female');

INSERT INTO pet_type (name) VALUES ('Dog');
INSERT INTO pet_type (name) VALUES ('Cat');
INSERT INTO pet_type (name) VALUES ('Rabbit');
INSERT INTO pet_type (name) VALUES ('Hamster');
INSERT INTO pet_type (name) VALUES ('Bird');
INSERT INTO pet_type (name) VALUES ('Fish');
INSERT INTO pet_type (name) VALUES ('Other');

INSERT INTO color (name) VALUES ("Apricot / Beige");
INSERT INTO color (name) VALUES ("Bicolor");
INSERT INTO color (name) VALUES ("Black");
INSERT INTO color (name) VALUES ("Brindle");
INSERT INTO color (name) VALUES ("Brown / Chocolate"); --5
INSERT INTO color (name) VALUES ("Golden");
INSERT INTO color (name) VALUES ("Gray / Blue / Silver");
INSERT INTO color (name) VALUES ("Harlequin");
INSERT INTO color (name) VALUES ("Merle (Blue)");
INSERT INTO color (name) VALUES ("Merle (Red)"); --10
INSERT INTO color (name) VALUES ("Red / Chestnut / Orange");
INSERT INTO color (name) VALUES ("Sable");
INSERT INTO color (name) VALUES ("Tricolor (Brown, Black & White)");
INSERT INTO color (name) VALUES ("White / Cream");
INSERT INTO color (name) VALUES ("Yellow / Tan / Blond / Fawn");

INSERT INTO pet VALUES (NULL,1,'Catutz','Shiba Inu',2,1,1.20,180,6,'Porto','svetlana', 2);
INSERT INTO pet VALUES (NULL,1,'Xaval','Bulldog',3,1,1.20,180,14,'Porto','svetlana', 2);
INSERT INTO pet VALUES (NULL,1,'Ilário','Pug',1,1,1.20,180,14,'Porto','svetlana', 2);
INSERT INTO pet VALUES (NULL,1,'Bidonis','Husky',2,1,1.20,180,3,'Porto','svetlana', 1);
INSERT INTO pet VALUES (NULL,2,'Bony','Persian',2,1,0.7,180,14,'Poland','peter', 1);
INSERT INTO pet VALUES (NULL,2,'Ressabiat','Exotic Shorthair',1,2,0.7,180,3,'Poland','peter', 2);
INSERT INTO pet VALUES (NULL,2,'Machups','Munchkin',1,2,0.7,180,14,'Poland','peter', 2);
INSERT INTO pet VALUES (NULL,2,'Kebibus','Sphynx',3,1,0.7,180,7,'Poland','peter', 2);

INSERT INTO proposal_decision VALUES (-2, 'withdrawn');
INSERT INTO proposal_decision VALUES (-1, 'rejected');
INSERT INTO proposal_decision VALUES (0, 'pending');
INSERT INTO proposal_decision VALUES (1, 'approved');
INSERT INTO proposal_decision VALUES (2, 'complete');

INSERT INTO pet_proposal VALUES (NULL,7,'svetlana',1508247632, 0, 'Bué baddie amoooo. Quero este pet para o explorar no TikTok a tentar fazer as pessoas pensar que ele tem uma consciência e que se exprime através de botões! Bué tiktok amoo!');
INSERT INTO pet_proposal VALUES (NULL,1,'tony',1508247632, 0, 'Bué baddie amoooo. Quero este pet para o explorar no TikTok a tentar fazer as pessoas pensar que ele tem uma consciência e que se exprime através de botões! Bué tiktok amoo!');
INSERT INTO pet_proposal VALUES (NULL,2,'tony',1508247632, 0, 'Bué baddie amoooo. Quero este pet para o explorar no TikTok a tentar fazer as pessoas pensar que ele tem uma consciência e que se exprime através de botões! Bué tiktok amoo!');
INSERT INTO pet_proposal VALUES (NULL,3,'tony',1508247632, 0, 'Bué baddie amoooo. Quero este pet para o explorar no TikTok a tentar fazer as pessoas pensar que ele tem uma consciência e que se exprime através de botões! Bué tiktok amoo!');
INSERT INTO pet_proposal VALUES (NULL,2,'peter',1508247632, 0, 'Bué baddie amoooo. Quero este pet para o explorar no TikTok a tentar fazer as pessoas pensar que ele tem uma consciência e que se exprime através de botões! Bué tiktok amoo!');
INSERT INTO pet_proposal VALUES (NULL,6,'golovkin',1508247632, 0, 'Bué baddie amoooo. Quero este pet para o explorar no TikTok a tentar fazer as pessoas pensar que ele tem uma consciência e que se exprime através de botões! Bué tiktok amoo!');
INSERT INTO pet_proposal VALUES (NULL,8,'golovkin',1508247632, 0, 'Bué baddie amoooo. Quero este pet para o explorar no TikTok a tentar fazer as pessoas pensar que ele tem uma consciência e que se exprime através de botões! Bué tiktok amoo!');

UPDATE pet_proposal SET decision = 1 WHERE pet_proposal_id = 1;
UPDATE pet_proposal SET decision = -1 WHERE pet_proposal_id = 2;
UPDATE pet_proposal SET decision = 2 WHERE pet_proposal_id = 6;
UPDATE pet_proposal SET decision = -2 WHERE pet_proposal_id = 8;

INSERT INTO pet_image VALUES (NULL,'shibainu.jpg',1);
INSERT INTO pet_image VALUES (NULL,'bulldog.jpg',2);
INSERT INTO pet_image VALUES (NULL,'pug.jpeg',3);
INSERT INTO pet_image VALUES (NULL,'husky.jpg',4);
INSERT INTO pet_image VALUES (NULL,'persian.jpg',5);
INSERT INTO pet_image VALUES (NULL,'exotic_shorthair.jpg',6);
INSERT INTO pet_image VALUES (NULL,'munchkin.jpg',7);
INSERT INTO pet_image VALUES (NULL,'sphynx.jpg',8);
INSERT INTO pet_image VALUES (NULL,'shibainu2.jpg',1);

INSERT INTO question VALUES (NULL,1,'tony',1508247632,'Is he well behaved?');
INSERT INTO question VALUES (NULL,1,'peter',1508247632,'Is he big?');
INSERT INTO question VALUES (NULL,3,'golovkin',1508247632,'Does he need any special care?');
INSERT INTO question VALUES (NULL,6,'svetlana',1508247632,'How big does she get?');
INSERT INTO question VALUES (NULL,1,'tony',1508247632,'Is he a baby?');

INSERT INTO reply VALUES (NULL,1,'svetlana',1508247632,'Yes, very well behaved');
INSERT INTO reply VALUES (NULL,2,'svetlana',1508247632,'Not really, but he is very young');
INSERT INTO reply VALUES (NULL,5,'svetlana',1508247632,'No, he is almost 2 years old');

INSERT INTO favorite_pet VALUES (NULL,6,'svetlana');
INSERT INTO favorite_pet VALUES (NULL,3,'peter');
INSERT INTO favorite_pet VALUES (NULL,7,'svetlana');
INSERT INTO favorite_pet VALUES (NULL,4,'tony');
