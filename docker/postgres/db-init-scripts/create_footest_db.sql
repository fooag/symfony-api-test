\c postgres

CREATE ROLE superadmin WITH NOLOGIN SUPERUSER INHERIT CREATEDB CREATEROLE NOREPLICATION;

CREATE USER sadmin LOGIN
    ENCRYPTED PASSWORD 'SuperSecret'
    NOSUPERUSER INHERIT NOCREATEDB NOCREATEROLE NOREPLICATION CONNECTION LIMIT 20
    IN ROLE superadmin;

CREATE ROLE app WITH NOLOGIN NOSUPERUSER INHERIT NOCREATEDB NOCREATEROLE NOREPLICATION;
COMMENT ON ROLE app IS 'Rolle für Benutzer, die von der Applikation genutzt werden';

CREATE USER web LOGIN
    ENCRYPTED PASSWORD 'FooBar'
    NOSUPERUSER INHERIT NOCREATEDB NOCREATEROLE NOREPLICATION CONNECTION LIMIT 200
    IN ROLE app;
COMMENT ON ROLE web IS 'account für die web-applikation';

DROP DATABASE IF EXISTS foo_intro;
CREATE DATABASE foo_intro OWNER web;

\c foo_intro;

CREATE EXTENSION pgcrypto;

GRANT USAGE ON SCHEMA public TO web;
ALTER DEFAULT PRIVILEGES IN SCHEMA public
    GRANT INSERT, SELECT, UPDATE, DELETE, TRUNCATE ON TABLES
    TO web;

CREATE TYPE public.geschlecht AS enum ('männlich', 'weiblich', 'divers');

CREATE TABLE public.bundesland (
    kuerzel char(2) PRIMARY KEY,
    name text NOT NULL
);

INSERT INTO public.bundesland VALUES
    ('BW', 'Baden-Württemberg'),
    ('BY', 'Bayern'),
    ('BE', 'Berlin'),
    ('BB', 'Brandenburg'),
    ('HB', 'Bremen'),
    ('HH', 'Hamburg'),
    ('HE', 'Hessen'),
    ('MV', 'Mecklenburg-Vorpommern'),
    ('NI', 'Niedersachsen'),
    ('NW', 'Nordrhein-Westfalen'),
    ('RP', 'Rheinland-Pfalz'),
    ('SL', 'Saarland'),
    ('SN', 'Sachsen'),
    ('ST', 'Sachsen-Anhalt'),
    ('SH', 'Schleswig-Holstein'),
    ('TH', 'Thüringen')
;

CREATE SCHEMA std;

GRANT ALL ON SCHEMA std TO sadmin WITH GRANT OPTION;
GRANT USAGE ON SCHEMA std TO web;
ALTER DEFAULT PRIVILEGES IN SCHEMA std
    GRANT INSERT, SELECT, UPDATE, DELETE, TRUNCATE ON TABLES
    TO web;

CREATE TABLE std.vermittler (
    id SERIAL NOT NULL PRIMARY KEY,
    nummer varchar (36) NOT NULL default (upper(left(gen_random_uuid()::text, 8))),
    vorname varchar(255),
    nachname varchar(255),
    firma varchar(255),
    geloescht boolean NOT NULL DEFAULT FALSE
);

INSERT INTO std.vermittler (id, nummer, vorname, nachname, firma) VALUES
(1000, 'ED138319', 'Marcus', 'Findel', 'VP-Felder GmbH'),
(2000, '37C71FA1', 'Christian', 'Karasius', 'Fondshaus AG'),
(3000, 'E065D5A8', 'Christian', 'Hauser', 'VP-Felder GmbH'),
(4000, '9B39F9FA', 'Fabian', 'Winkel', 'Fondshaus AG');

CREATE TABLE std.tbl_kunden (
    id varchar (36) NOT NULL default (upper(left(gen_random_uuid()::text, 8))) PRIMARY KEY,
    name varchar (255),
    vorname varchar (255),
    firma text,
    geburtsdatum timestamp,
    geloescht int,
    geschlecht public.geschlecht,
    email text,
    vermittler_id INT NOT NULL REFERENCES std.vermittler(id)
);

INSERT INTO std.tbl_kunden (
    id, name, vorname, firma, geburtsdatum, geloescht, email, vermittler_id
) VALUES
('D5F449CE', 'Meier', 'Bertram', NULL, '1973-03-06', 0, 'mebe@example.org', 1000),
('E97DEF37', 'Schmitz', 'Anke', 'Dies und Das GbR', '2000-12-02', 0, 'scan@example.org', 3000),
('80BA9796', 'Fink', 'Christian', NULL, NULL, 1, NULL, 1000),
('80B4F645', 'Strauss', 'Karsten', NULL, '1993-02-17', 0, 'stka@example.org', 2000),
('8C3C855C', 'von Burgenstaedt', 'Barius', NULL, '1993-10-27', 0, null, 4000),
('E2D547B5', 'von Burgenstaedt', 'Stefan', NULL, '1970-12-07', 0, 'burgenstaedt@example.org', 4000),
('05EEC268', 'von Burgenstaedt', 'Max', NULL, '1999-12-15', 0, null, 4000),
('C8EFDAAD', 'von Burgenstaedt', 'Stefanie', NULL, '1973-01-01', 0, 'burgenstaedt@example.org', 4000)
;

CREATE TABLE std.adresse (
    adresse_id serial PRIMARY KEY,
    strasse text,
    plz varchar (10),
    ort text,
    bundesland char(2) REFERENCES public.bundesland
);

INSERT INTO std.adresse (strasse, plz, ort, bundesland) VALUES
('Invalidenstr. 23', '10115', 'Berlin', 'BE'),
('Berliner Str. 12', NULL, 'Zossen', 'BB'),
('Am Fennpfuhl 2b', '23456', 'Much', 'NW'),
('Hauptstraße 17', '98543', 'Lieblichknuffeltal', 'BY'),
('Müllerstrasse 8', '13685', 'Marlow', 'BB'),
('Müllerdamm Allee 178', '11447', 'Burgenstaedt', 'BB')
;

CREATE TABLE std.kunde_adresse (
    kunde_id varchar (36) NOT NULL,
    adresse_id int NOT NULL,
    geschaeftlich boolean DEFAULT false,
    rechnungsadresse boolean,
    geloescht boolean NOT NULL DEFAULT false
);

INSERT INTO std.kunde_adresse (kunde_id, adresse_id, geschaeftlich, rechnungsadresse, geloescht) VALUES
('D5F449CE', 1, false, true, false),
('D5F449CE', 2, true, false, false),
('E97DEF37', 3, false, true, true),
('E97DEF37', 4, false, true, false),
('80BA9796', 5, false, true, false),
('80B4F645', 4, false, true, false),
('8C3C855C', 6, false, true, false),
('E2D547B5', 6, false, true, false),
('05EEC268', 6, false, true, false),
('C8EFDAAD', 6, false, true, false)
;

CREATE SCHEMA sec;

GRANT ALL ON SCHEMA sec TO sadmin WITH GRANT OPTION;
GRANT USAGE ON SCHEMA sec TO web;
ALTER DEFAULT PRIVILEGES IN SCHEMA sec
    GRANT INSERT, SELECT, UPDATE, DELETE, TRUNCATE ON TABLES
    TO web;

CREATE TABLE sec.vermittler_user (
    id integer PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    email varchar (200),
    passwd varchar (60),
    vermittler_id INT NOT NULL REFERENCES std.vermittler (id),
    aktiv int,
    last_login timestamp
);

INSERT INTO sec.vermittler_user (email, passwd, vermittler_id, aktiv, last_login) VALUES
('mfindel@vp-felder.de', crypt('hommes', gen_salt('bf', 10)), 1000, 1, now() - interval '2 hours'),
('chauser@vp-felder.de', crypt('hauser', gen_salt('bf', 10)), 3000, 0, now() - interval '3 years'),
('c_karasius@fondshaus.ag', crypt('supersicher', gen_salt('bf', 10)), 2000, 1, NULL);

CREATE TABLE sec.user (
    id integer PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    email varchar (200),
    passwd varchar (60),
    kundenid varchar (36) REFERENCES std.tbl_kunden (id),
    aktiv int,
    last_login timestamp
);

INSERT INTO sec.user (email, passwd, kundenid, aktiv, last_login) VALUES
('kari@example.com', crypt('bremnes', gen_salt('bf', 10)), 'D5F449CE', 1, now() - interval '2 hours'),
('ane@example.net', crypt('brun', gen_salt('bf', 10)), 'E97DEF37', 1, now()),
('sezen@example.net', crypt('aksu', gen_salt('bf', 10)), '80BA9796', 1, NULL),
('eleftheria@example.net', crypt('arvanitaki', gen_salt('bf', 10)), '80B4F645', 0, now() - interval '3 days'),
('ebba@example.net', crypt('forsberg', gen_salt('bf', 10)), NULL, 1, now());
