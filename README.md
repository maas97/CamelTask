## About Task Details

This is task for Camel Code Company with a simple but secure API process of pre-registration of a user with subscribing for new plans with optional addons,

The API comes with:

- security against XSS attacks with validation and filtration of each coming request against malicious scripts.
- against DDoS attacks with applying rate limit layer with 10 requests allowed per IP per 60 seconds.
- With agreement in the future with frontend team, CORS for API can be added for a specific Frontend URL so that only our frontend can use our API.
- [API Postman Documentation](https://documenter.getpostman.com/view/41018314/2sAYXBGfNe) so it can help the frontend team to use know which endpoints and how to use it more easily.

## The Task comes with:

- Optimized process for saving new details of each user, separating each step with caching user data for specific amount of time = 30 mins,
during that time each user will receive a unique UUID since it is a registration process with no-logging-user-JWT-token to apply authentication for specific user without logging in.

- If a user passed the 30 mins period of time, he must generate a new UUID and the UUID will be invalid to use.

- If a user tried to user our API for example to put the data of the second or third step without the first step, it will run a session error for him/her and they must start with the first step.

- Username comes with regex that is suitable for storing only valid names, with any letter of any language with only white spacing allowance, keeping in mind if user only sent white spaces it will run an error for them.

- Data won't be saved in our database of any user until he/she completes the whole process of registration, to avoid filling the DB with uncompleted useless data.


## What can be applied in the future if required:

- The ability to enhance the process by encrypting the UUID for each user to be secure against MITM attacks.
- Sending mails after completing the whole process using nodemailer or sending sms texts for there phone number using twilio service, to make the user verify his registration later with entering the password.
- Applying real-time caching data with each input event the user will do in the frontend applying techniques like debouncing and throttling so the user data will be cached to be saved later for every 5 seconds for example, that will be extremely crucial if the registration process has more steps.



<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
