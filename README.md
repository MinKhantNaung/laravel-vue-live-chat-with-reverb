# Real-Time Chat Application

A real-time chat application that allows users to send and receive messages instantly, with additional real-time features like typing indicators and whisper messages.

## 🚀 Features

- 🔒 User authentication and session handling
- 💬 One-to-one real-time messaging
- ✍️ Typing indicator to show when a user is typing
- 🤫 Whisper messages (private inline messages)
- ⚡ Instant updates using broadcasting

## 📦 Tech Stack (VILT)

- **Backend:** PHP (Laravel 12)
- **Frontend:** Vue.js, Inertia, Typescript, Tailwind (UI)
- **Real-time:** Laravel Echo + Reverb (a Pusher alternative)
- **Database:** MySQL

## ⚙️ Installation

Follow these steps to set up the project locally:

1. **Clone the repository**

```bash
git clone https://github.com/MinKhantNaung/laravel-vue-live-chat-with-reverb.git
cd laravel-vue-live-chat-with-reverb
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Generate application key**
```bash
php artisan key:generate
```

4. **Edit your .env file to match your database and app configuration**
nano .env  # or edit manually

5. **Run database migrations**
```bash
php artisan migrate
```

6. **Install JavaScript dependencies**
```bash
npm install
```

7. **Build front-end assets**
```bash
npm run build
```

8. **Start Laravel's local development server, queue worker, and Vite development server (Laravel 12+)**
```bash
composer run dev
```

9. **Start the Reverb server**
```bash
php artisan reverb:start
```

## 📚 Related Projects / Credits

This project was inspired by or built upon the following open-source repository:

- 🔗 [Laravel 11 Vue API Stack](https://github.com/qirolab/laravel-reverb-chat) by [@QiroLab](https://github.com/qirolab)  
  A clean implementation of a Laravel 11 + Vue.js chat system using an API-first architecture.

> Parts of this project are adapted from the above repo. Thanks for sharing it with the community!

## 📄 License

This project is open-source and available under the [MIT License](./LICENSE).

## 👤 Author

Developed by [Min Khant Naung](https://github.com/MinKhantNaung). Contributions and suggestions welcome!
