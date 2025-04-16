# 🛍️ Sklep internetowy z odzieżą i obuwiem

Nowoczesna aplikacja e-commerce do sprzedaży ubrań i butów, zbudowana w oparciu o **Laravel**, **Vue.js** i **Inertia.js**. System wspiera pełen proces zakupowy, zarządzanie produktami oraz wygodny i responsywny interfejs użytkownika.

## 🔧 Technologie

- **Laravel** – backend, API, logika aplikacji
- **Vue.js** – frontend aplikacji
- **Inertia.js** – łączy Laravel z Vue bez potrzeby tworzenia API REST
- **Tailwind CSS** – stylowanie komponentów
- **Stripe & PayPal** – obsługa płatności online
- **MySQL** – baza danych

## ✨ Funkcje

### 🛒 Dla użytkownika
- Rejestracja i logowanie
- Przeglądanie produktów (ubrania, buty)
- Filtry, sortowanie, wyszukiwanie
- Dodawanie do koszyka
- Finalizacja zamówienia z płatnościami online (Stripe / PayPal)
- Obsługa kodów promocyjnych
- Historia zamówień
- Responsywny interfejs – działa na komputerach i urządzeniach mobilnych

### 🔐 Panel administracyjny
- Logowanie administratora
- Zarządzanie produktami (dodawanie, edycja, usuwanie)
- Zarządzanie kategoriami
- Podgląd zamówień i użytkowników
- Ustawianie i zarządzanie kodami rabatowymi

## 🚀 Wymagania

- PHP >= 8.1
- Node.js & npm
- Composer
- MySQL / MariaDB
- Konto Stripe i/lub PayPal (do testów lub produkcji)

## 🛠️ Instalacja

```bash
git clone https://github.com/twoje-konto/sklep-laravel-vue.git
cd sklep-laravel-vue

# Instalacja zależności backendu
composer install

# Instalacja zależności frontendowych
npm install

# Konfiguracja środowiska
cp .env.example .env
php artisan key:generate

# Ustaw dane do bazy danych oraz Stripe/PayPal w pliku .env

# Migracje i seedy
php artisan migrate --seed

# Kompilacja frontendu
npm run build

# Uruchomienie serwera
php artisan serve
```

## 🔐 Dane testowe

**Administrator:**

- Email: `admin@example.com`  
- Hasło: `123123`  

**Moderator:**

- Email: `moderator@example.com`  
- Hasło: `123123`  

**Użytkownik:**

- Email: `user@example.com`  
- Hasło: `123123` 
