# 📊 Registracking

Sistema web para gestionar deudores, deudas y pagos. Reemplaza el Excel con una interfaz clara, alertas de vencimiento y un dashboard con la información clave.

---

## ✨ Características

- 🔐 Autenticación segura (Laravel Breeze)
- 👥 CRUD de deudores
- 💰 CRUD de deudas con estados automáticos (pendiente / parcial / pagado)
- 💵 Registro de pagos con historial
- 📈 Dashboard con totales y alertas de vencimiento
- 🔍 Búsqueda y filtros
- 📱 Diseño responsive
- 🔒 Cada usuario ve solo sus datos

---

## 🛠️ Tecnologías

- **Backend:** PHP 8.2 + Laravel 12
- **Frontend:** Blade + Tailwind CSS + Alpine.js
- **Base de datos:** MySQL
- **Build:** Vite

---

## 🚀 Instalación

```bash
git clone https://github.com/johnjmg/registracking.git
cd registracking
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Configura tu base de datos en `.env`:

```env
APP_NAME=Registracking
APP_LOCALE=es
DB_CONNECTION=mysql
DB_DATABASE=registracking
DB_USERNAME=root
DB_PASSWORD=
```

Luego ejecuta:

```bash
php artisan migrate
npm run build
php artisan serve
```

Abre `http://127.0.0.1:8000` y regístrate.

---

## 🧩 Modelo de datos

```
User (1) ── (N) Deudor (1) ── (N) Deuda (1) ── (N) Pago
```

Saldo pendiente = `monto_total - monto_pagado`.

---

## 🔒 Seguridad

Contraseñas con bcrypt · CSRF · XSS · SQL Injection · Autorización por usuario · Validación de entrada.

---

## 🗺️ Roadmap

- [x] Autenticación
- [x] Deudores, deudas y pagos
- [x] Dashboard, búsqueda y filtros
- [ ] Exportar a PDF/Excel
- [ ] Notificaciones por correo
- [ ] PWA

---

## 📄 Licencia

MIT

---

## 👨‍💻 Autor

**John Jáner M.G.** — Soluciones Jmartech  
Registracking © 2026