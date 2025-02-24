CREATE TABLE IF NOT EXISTS Cars (
                                    id serial NOT NULL PRIMARY KEY,
                                    name varchar(256),
    horsePower smallint,
    engineCapacity numeric,
    price money
    );

CREATE TABLE IF NOT EXISTS Users (
                                     id serial NOT NULL PRIMARY KEY,
                                     name varchar(64) NOT NULL,
    password varchar(64) NOT NULL,
    age smallint,
    phone varchar(32),
    isAdmin boolean NOT NULL DEFAULT false
    );

CREATE TABLE IF NOT EXISTS Requests (
                                        id serial NOT NULL,
                                        userId integer NOT NULL REFERENCES Users(id),
    carId integer NOT NULL REFERENCES Cars(id),
    startDate date,
    endDate date
    );

INSERT INTO Cars (name, horsepower, enginecapacity, price)
VALUES ('Audi RS Q8 2021', 600, 4.0, 130),
       ('Audi RS7 Sportback 2021', 600, 4.0, 180),
       ('Audi RS6 GT 2024', 630, 4.0, 166),
       ('Audi R8 V10 Plus 2024', 660, 5.2, 325),
       ('Porsche 911 2022', 394, 3.0, 128),
       ('Porsche 911 GT3 RS 2024', 525, 3.99, 170),
       ('BMW 5 Series 2023', 333, 3.0, 95),
       ('BMW X5 2023', 298, 2.99, 87),
       ('BMW X6 2023', 381, 3.0, 87),
       ('BMW 8 Series Gran Coupe 2024', 320, 3.0, 103),
       ('Bentley Flying Spur 2024', 550, 4.0, 246);

INSERT INTO Users (name, password, age, phone, isAdmin)
VALUES ('JosephJoestar', 'jojo1', 24, '+1(212)728-56-03', false),
       ('JonathanJoestar', 'jojo2', 17, '+44(035)216-80-96', false),
       ('JotaroKujo', 'jojo3', 16, '+81(11)221-32-39', false);

INSERT INTO Requests (userId, carId, startDate, endDate)
VALUES (1, 11, '01.09.2024 08:00:00', '08.09.2024 16:00:00');