# mundoDS :tv:
This is a mini social network to manage TV shows and episodes followed by the user & find friends that like the same shows!

The application is written in Vue.js and Laravel.

### Start the development :computer:
```
git clone https://github.com/igoortc/mundoDS.git
```
```
composer install
```
Fill out the `.env.example` with your variables, then remove the `.example`

```
php artisan key:generate
```
```
npm install
```

### Migrations and seeder :mushroom:
Check the database info on the `.env` file.
```
php artisan migrate
```
```
php artisan db:seed
```

### Running and serving the application :rocket:
```
npm run dev
```
```
php artisan serve
```
Go to [http://localhost:8000/](http://localhost:8000/).

### Troubleshooting :x:
* If an error (like `ELIFECYCLE`) comes up when running `npm run dev`, try deleting the `node_modules` folder then running `npm install` again.
* Make sure Laravel is [updated](https://laravel.com/docs/5.5/upgrade).
