# mundoDS
This is a code for a social network to manage TV shows and episodes followed by the user & find friends that like the same shows!

The application is being written using Vue.js and Laravel.

#### STILL IN DEVELOPMENT

### Start the development
```
git clone https://github.com/igoortc/mundoDS.git
```
```
composer install
```
Check the `.env` file

```
php artisan key:generate
```
```
npm install
```

### Migrations and seeder
Check the database info on the `.env` file.
```
php artisan migrate
```
```
php artisan db:seed
```
```
php artisan serve
```

### Running the application
```
npm run dev
```
Go to [http://localhost:8000/](http://localhost:8000/).

### Troubleshooting
* If an error (like `ELIFECYCLE`) comes up when running `npm run dev`, try deleting the `node_modules` folder then running `npm install` again.
* Make sure Laravel is [updated](https://laravel.com/docs/5.5/upgrade).
