-- Creates a database, codeday.
-- Drops any existing database named codeday.
-- Creates a table, Phrases which stores phrases.
-- Drops any existing table named Phrases.
DROP DATABASE IF EXISTS codeday;
CREATE DATABASE codeday;
USE codeday;
DROP TABLE IF EXISTS Phrases;
CREATE TABLE Phrases(
	phrase VARCHAR(1000) NOT NULL PRIMARY KEY
);