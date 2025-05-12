CREATE TABLE Reservations (
    id INT PRIMARY KEY IDENTITY(1,1),
    name NVARCHAR(255),
    reservation_date DATE,
    reservation_time TIME,
    description NVARCHAR(255)
);