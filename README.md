# Gestión de Empresas - CRUD

Sistema de gestión empresarial para el registro, edición, eliminación y exportación de datos de empresas. Desarrollado con PHP (Backend), MySQL (Base de Datos) y una interfaz moderna basada en Bootstrap y jQuery.

## 📋 Requisitos

- **PHP:** >= 8.0
- **Servidor Web:** Apache (vía XAMPP, WAMP o Laragon)
- **Base de Datos:** MySQL / MariaDB
- **Gestor de Dependencias:** Composer
- **Extensiones PHP requeridas:** `pdo_mysql`, `mbstring`, `gd` (para PDFs).

## 🚀 Instalación

1.  **Clonar o copiar el proyecto** en tu directorio de servidor web (ej. `C:/xampp/htdocs/empresas`).
2.  **Instalar dependencias** de PHP:
    ```bash
    composer install
    ```
3.  **Configurar el entorno**:
    Crea un archivo `.env` en la raíz del proyecto basándote en la siguiente configuración:

    ```env
    DB_HOST=localhost
    DB_NAME=empresas_db
    DB_USER=root
    DB_PASS=
    ```

## 🗄️ Base de Datos

Crea una base de datos llamada `empresas_db` y ejecuta el siguiente script SQL para crear la tabla necesaria:

```sql
CREATE DATABASE IF NOT EXISTS empresas_db;
USE empresas_db;

CREATE TABLE IF NOT EXISTS `empresa` (
  `id_empresa` int(11) NOT NULL AUTO_INCREMENT,
  `rif` varchar(20) NOT NULL,
  `razon_social` varchar(150) NOT NULL,
  `direccion` text NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_empresa`),
  UNIQUE KEY `rif_unique` (`rif`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

## 🛣️ Rutas de la API (Endpoints)

Todas las rutas base se encuentran en `public/api/`:

| Método   | Endpoint                           | Descripción                                           |
| :------- | :--------------------------------- | :---------------------------------------------------- |
| `GET`    | `/api/empresas_list.php`           | Lista todas las empresas (admite parámetro `search`). |
| `GET`    | `/api/empresas_get.php?id={id}`    | Obtiene los detalles de una empresa específica.       |
| `POST`   | `/api/empresas_create.php`         | Crea una nueva empresa (requiere JSON en el body).    |
| `PUT`    | `/api/empresas_update.php?id={id}` | Actualiza una empresa existente.                      |
| `DELETE` | `/api/empresas_delete.php?id={id}` | Realiza un borrado lógico (`deleted_at`).             |
| `GET`    | `/api/empresas_export_json.php`    | Descarga la lista de empresas en formato JSON.        |
| `GET`    | `/api/empresas_report_pdf.php`     | Genera y descarga un reporte en PDF.                  |

## 📸 Capturas de Pantalla

- **Interfaz de Usuario (UI):** `assets/img/screenshot_ui.png`
- **Respuesta JSON:** `assets/img/screenshot_json.png`
- **Reporte PDF:** `assets/img/screenshot_pdf.png`
