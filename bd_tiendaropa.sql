-- Crear la base de datos
CREATE DATABASE TiendaRopa;
USE TiendaRopa;

-- Tabla: Categorías
CREATE TABLE Categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre_categoria VARCHAR(50) NOT NULL
);

-- Tabla: Productos
CREATE TABLE Productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    talla VARCHAR(5),
    color VARCHAR(30),
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    foto_url VARCHAR(255), 
    id_categoria INT,
    FOREIGN KEY (id_categoria) REFERENCES Categorias(id_categoria)
);

-- Tabla: Clientes
CREATE TABLE Clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    dni VARCHAR(15) UNIQUE,
    usuario VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    correo VARCHAR(100),
    telefono VARCHAR(15),
    direccion VARCHAR(150)
);

-- Tabla: Empleados
CREATE TABLE Empleados (
    id_empleado INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    cargo VARCHAR(50),
    correo VARCHAR(100),
    telefono VARCHAR(15)
);

-- Tabla: Ventas
CREATE TABLE Ventas (
    id_venta INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_cliente INT,
    id_empleado INT,
    total DECIMAL(10,2),
    FOREIGN KEY (id_cliente) REFERENCES Clientes(id_cliente),
    FOREIGN KEY (id_empleado) REFERENCES Empleados(id_empleado)
);

-- Tabla: Detalle_Venta
CREATE TABLE Detalle_Venta (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    id_venta INT,
    id_producto INT,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_venta) REFERENCES Ventas(id_venta),
    FOREIGN KEY (id_producto) REFERENCES Productos(id_producto)
);

-- 🔹 Insertar Categorías
INSERT INTO categorias (nombre_categoria) VALUES
('Polos'),
('Pantalones'),
('Zapatillas'),
('Chaquetas');

-- 🔹 Insertar Productos (4 por categoría, con marcas y modelos reales o realistas)
INSERT INTO productos (nombre, descripcion, talla, color, precio, stock, foto_url, id_categoria) VALUES
-- Polos (id_categoria = 1)
('Polo Nike Dri-FIT', 'Polo deportivo con tecnología Dri-FIT que absorbe el sudor.', 'M', 'Negro', 79.90, 50, 'nikedrifit.jpg', 1),
('Polo Adidas Essentials', 'Polo casual con logo bordado en el pecho.', 'L', 'Blanco', 69.90, 40, 'adidas_essentials.jpg', 1),
('Polo Puma Classics', 'Polo clásico con diseño sencillo y elegante.', 'S', 'Gris', 59.90, 60, 'puma_classics.jpg', 1),
('Polo Lacoste Slim Fit', 'Polo de algodón premium con logo de cocodrilo.', 'M', 'Azul Marino', 149.90, 30, 'lacoste_slim.jpg', 1),

--  Pantalones (id_categoria = 2)
('Jean Levis 511 Slim', 'Jean ajustado con diseño moderno.', '32', 'Azul Oscuro', 179.00, 35, 'levis_511.jpg', 2),
('Jogger Adidas Originals', 'Jogger deportivo para uso diario.', 'M', 'Gris', 129.90, 40, 'adidas_jogger.jpg', 2),
('Pantalón Dockers Alpha', 'Pantalón chino de corte moderno.', '34', 'Beige', 159.90, 25, 'dockers_alpha.jpg', 2),
('Jean Wrangler Regular Fit', 'Jean clásico de corte recto.', '30', 'Azul Claro', 139.90, 20, 'wrangler_regular.jpg', 2),

--  Zapatillas (id_categoria = 3)
('Zapatilla Nike Air Max 270', 'Zapatilla cómoda con cámara de aire visible.', '42', 'Negro', 399.00, 15, 'nike_air_max.jpg', 3),
('Zapatilla Adidas Ultraboost', 'Ideal para correr, con excelente amortiguación.', '41', 'Blanco', 479.00, 10, 'adidas_ultraboost.jpg', 3),
('Zapatilla Puma RS-X', 'Zapatilla retro con gran estilo urbano.', '43', 'Rojo', 349.90, 20, 'puma_rsx.jpg', 3),
('Zapatilla New Balance 574', 'Diseño clásico para uso diario.', '42', 'Gris', 299.00, 18, 'nb_574.jpg', 3),

--  Chaquetas (id_categoria = 4)
('Chaqueta The North Face Resolve', 'Chaqueta impermeable resistente al viento.', 'L', 'Negro', 499.00, 12, 'tnf_resolve.jpg', 4),
('Chaqueta Columbia Watertight II', 'Ideal para climas húmedos, ligera y cómoda.', 'M', 'Azul Marino', 459.00, 14, 'columbia_watertight.jpg', 4),
('Chaqueta Adidas Windbreaker', 'Chaqueta liviana para correr.', 'S', 'Verde', 299.90, 25, 'adidas_windbreaker.jpg', 4),
('Chaqueta Puma EvoKNIT', 'Chaqueta deportiva con diseño ergonómico.', 'M', 'Gris', 319.90, 10, 'puma_evoknit.jpg', 4);

--  Insertar Clientes
INSERT INTO clientes (nombres, apellidos, dni, correo, telefono, direccion) VALUES
('Juan', 'Pérez', '12345678', 'juan.perez@gmail.com', '999888777', 'Av. Siempre Viva 123'),
('Ana', 'Gonzales', '87654321', 'ana.gonzales@hotmail.com', '987654321', 'Calle Falsa 456');

--  Insertar Empleados
INSERT INTO empleados (nombres, apellidos, usuario, password, cargo, correo, telefono) VALUES
('Carlos', 'Ramírez', 'cramirez', '$2y$10$EizHkX.M2yAS9LHblS4pX.JgY29P.J.eXhA7sLwVvj6aNfG.NqT9S', 'Vendedor', 'carlos.ramirez@tiendaropa.com', '988776655'), -- pass: 12345
('Lucía', 'Mendoza', 'lmendoza', '$2y$10$EizHkX.M2yAS9LHblS4pX.JgY29P.J.eXhA7sLwVvj6aNfG.NqT9S', 'Cajera', 'lucia.mendoza@tiendaropa.com', '977665544'); -- pass: 12345

--  Insertar Ventas
INSERT INTO ventas (fecha, id_cliente, id_empleado, total) VALUES
('2025-07-29 10:30:00', 1, 1, 179.80),
('2025-07-29 11:00:00', 2, 2, 150.00);

--  Insertar Detalle de Venta
INSERT INTO detalle_venta (id_venta, id_producto, cantidad, precio_unitario) VALUES
(1, 1, 2, 29.90),   -- 2 polos
(1, 2, 1, 89.90),   -- 1 jean
(2, 3, 1, 150.00);  -- 1 zapatilla
